<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayMob;
use App\PayMob\PayMobCash;
use App\PayMob\PayMobCredit;
use App\Order;
use App\Voucher;
use App\Usercredit;
use App\Promocode;
use App\UserPromocodeOrder;
use App\Events\VoucherPurchased;
use App\Events\TicketPurchased;
use App\Events\TicketRefund;
use App\UserRace;
use App\Ticket;
use Auth;
use Carbon\Carbon;

class PaymentController extends Controller
{

    public function __construct()
    {
        if (\Request::is('api*') || \Request::wantsJson()) {
            $this->middleware(['auth:api']);
        } else {
            $this->middleware('auth');
        }
    }

    /**
     * POST Request from cart-payment for online payment button
     */
    public function buyTickets(Request $request)
    {
        $inputs = $request->all();
        $paymentMethod = $inputs['paymet_method'];

        $user = Auth::user();
        \Cart::session($user->id);
        $cartTotal = \Cart::getTotal();
        $cartSubTotal = \Cart::getSubTotal();
        $cartItems = \Cart::getContent()->toArray();
        $credit = \Cart::getCondition('Credit');
        $voucher = \Cart::getCondition('Voucher');

        if ($credit) {
            $meta['credit'] = $credit->parsedRawValue;
        }

        if ($voucher) {
            $meta['voucher'] = $voucher->getAttributes();
            $voucher = Voucher::where('code', $meta['voucher']['code'])->first();
            $voucher_credit = $voucher->amount - ($credit ? $credit->parsedRawValue : 0) - $cartSubTotal;
            $usercredit = new Usercredit();
            $usercredit->user_id = $user->id;
            $usercredit->amount = $voucher_credit;
            $usercredit->action = 'Voucher Remaining';
            $usercredit->save();
        }

        foreach ($cartItems as $item) {
            $meta[$item['id']] = new \stdClass();
            $meta[$item['id']]->type = 'ticket';
            $meta[$item['id']]->paymentMethod = $paymentMethod;
            foreach ($item['attributes'] as $key => $attribute) {
                $meta[$item['id']]->$key = $attribute;
            }
            if (count($item['conditions'])) {
                $meta[$item['id']]->code = $item['conditions'][0]->getAttributes()['code'];
                $meta[$item['id']]->Price = $meta[$item['id']]->Price - $item['conditions'][0]->parsedRawValue;
            }
        }


        $order = new Order();
        $order->id = uniqid('TFO-');
        $order->totalCost = $cartTotal + ($credit ? $credit->parsedRawValue : 0)
        + ($voucher ? $voucher->amount - $voucher_credit : 0);
        $order->user_id = $user->id;
        $order->meta = json_encode($meta);

        if ($cartTotal > 0) {
            $order->save();
            $order->totalCost = $cartTotal;
            return $this->makePayment($order, $paymentMethod);
        } else {
            $order->success = 'true';
            $order->save();

            return $this->postInvoice($order);
        }
    }

    public function buyVouchers(Request $request)
    {
        $inputs = $request->all();
        $paymentMethod = $inputs['paymet_method'];

        $meta = new \stdClass();
        $meta->type = 'voucher';
        $meta->qty = $inputs['qty'];
        $meta->discount_amount = $inputs['discount_amount'];
        $meta->recipient_email = $inputs['recipient_email'];
        $meta->recipient_name = $inputs['recipient_name'];
        $meta->recipient_phone = $inputs['recipient_phone'];
        $meta->message = $inputs['message'];
        $meta->paymentMethod = $paymentMethod;

        $user = Auth::user();

        $order = new Order();
        $order->id = uniqid('TFV-');
        $order->user_id = $user->id;
        $order->totalCost = $inputs['qty'] * $inputs['discount_amount'];
        $order->meta = json_encode($meta);

        $order->save();

        return $this->makePayment($order, $paymentMethod);
    }

    public function makePayment($order, $paymentMethod)
    {
        $auth = PayMob::authPaymob();

        $paymobOrder = PayMob::makeOrderPaymob(
            $auth->token, // this is token from step 1.
            $auth->profile->id, // this is the merchant id from step 1.
            $order->totalCost * 100, // total amount by cents/piasters.
            $order->id // your (merchant) order id.
        );

        $order->update(['paymob_order_id' => $paymobOrder->id]);

        $user = Auth::user();

        if ($paymentMethod === 'card') {
            $pbc = new PayMobCredit();
            $paymentKey = $pbc->getPaymentKeyPaymob(
                $auth->token, // from step 1.
                $order->totalCost * 100, // total amount by cents/piasters.
                $paymobOrder->id, // paymob order id from step 2.
                $user->email,
                $user->firstname,
                $user->lastname,
                $user->phone
            );

            return view('payment', ['paymentKey' => $paymentKey]);
        } else {
            $pbc = new PayMobCash();
            $paymentKey = $pbc->getCashPaymentKeyPaymob(
                $auth->token, // from step 1.
                $order->totalCost * 100, // total amount by cents/piasters.
                $paymobOrder->id, // paymob order id from step 2.
                // For billing data
                $user->email,
                $user->firstname,
                $user->lastname,
                $user->phone,
                'Cairo', // City (helio)
                'EG', // Counry
                'Cairo' // State (list)
            );

            $payment = $pbc->makePayment($paymentKey->token);

            $this->consumeCartConditions($order);
            \Cart::session($user->id);
            \Cart::clear();
            \Cart::clearCartConditions();

            return $this->successCash($order);
        }
    }

    /**
     * Transaction succeeded.
     *
     * @param  object  $order
     * @return void
     */
    protected function succeeded($order)
    {
    }

    /**
     * Transaction voided.
     *
     * @param  object  $order
     * @return void
     */
    protected function voided($order)
    {
    }

    /**
     * Transaction refunded.
     *
     * @param  object  $order
     * @return void
     */
    protected function refunded($order)
    {
    }

    /**
     * Transaction failed.
     *
     * @param  object  $order
     * @return void
     */
    protected function failed($order)
    {
    }

    /**
     * Processed callback from PayMob servers.
     * Save the route for this method in PayMob dashboard >> processed callback route.
     *
     * @param  \Illumiante\Http\Request  $request
     * @return  Response
     */
    public function processedCallback(Request $request)
    {
        $orderId = $request['obj']['order']['id'];
        $order = Order::wherePaymobOrderId($orderId)->first();
        // Statuses.
        $isSuccess = $request['obj']['success'];
        $isVoided = $request['obj']['is_voided'];
        $isRefunded = $request['obj']['is_refunded'];
        if ($isSuccess && !$isVoided && !$isRefunded) { // transcation succeeded.
            $this->succeeded($order);
        } elseif ($isSuccess && $isVoided) { // transaction voided.
            $this->voided($order);
        } elseif ($isSuccess && $isRefunded) { // transaction refunded.
            $this->refunded($order);
        } elseif (!$isSuccess) { // transaction failed.
            $this->failed($order);
        }
        return response()->json(['success' => true], 200);
    }

    /**
     * Display invoice page (PayMob response callback).
     * Save the route for this method to PayMob dashboard >> response callback route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function invoice(Request $request)
    {
        $orderId = $request->order;
        $order = Order::wherePaymobOrderId($orderId)->first();
        $order->success = $request->success;
        $order->save();

        return $this->postInvoice($order);
    }

    public function consumeCartConditions($order)
    {
        $user = $order->user()->first();
        $meta = json_decode($order->meta);

        if (property_exists($meta, 'credit')) {
            $userCredit = new Usercredit;
            $userCredit->amount = $meta->credit * -1;
            $userCredit->action = $order->id;
            $userCredit->user_id = $user->id;
            $userCredit->save();
        }

        if (property_exists($meta, 'voucher')) {
            $voucher = Voucher::where('code', $meta->voucher->code)->first();
            if ($voucher) {
                $voucher->order_id = $order->id;
                $voucher->usedOn = Carbon::now()->format('Y-m-d H:i:s');
                $voucher->save();
            }
        }
    }

    public function consumePromocode($order, $code)
    {
        $user = $order->user()->first();

        $promocode = Promocode::where('code', $code)->first();

        if ($promocode->unlimited == 1) {
            return;
        }
        
        $userPromocodeRace = new UserPromocodeOrder();
        $userPromocodeRace->user_id = $user->id;
        $userPromocodeRace->order_id = $order->id;
        $userPromocodeRace->promocode_id = $promocode->id;

        $userPromocodeRace->save();
    }

    public function postInvoice($order)
    {
        if ($order->success === 'true') {
            $user = $order->user()->first();
            $meta = json_decode($order->meta);

            $this->consumeCartConditions($order);

            if (property_exists($meta, 'type')) {
                event(new VoucherPurchased($order, $meta, $user));
            } else {
                foreach ($meta as $ticketId => $ticket) {
                    if ($ticketId !== 'credit' && $ticketId !== 'voucher') {
                        if (property_exists($ticket, 'code')) {
                            $this->consumePromocode($order, $ticket->code);
                        }
                        event(new TicketPurchased($order, $ticketId, $ticket, $user));
                    }
                }
            }
            \Cart::session($user->id);
            \Cart::clear();
            \Cart::clearCartConditions();
        }

        return $this->success($order);
    }

    public function success($order)
    {
        if (\Request::is('api*') || \Request::wantsJson()) {
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'payment-success',
                'data' => $order
            ]);
        } else {
            // return view('payment-success', ['order' => $order]);
            return redirect()->route('payment_success', ['order' => $order]);
        }
    }

    public function successCash($order)
    {
        if (\Request::is('api*') || \Request::wantsJson()) {
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'cash-success',
                'data' => $order
            ]);
        } else {
            return view('cash-success', ['order' => $order]);
        }
    }
    
    public function refundTicket(Request $request)
    {
        $user = Auth::user();

        if (!isset($request->participant_user_id) || $request->participant_user_id == $user->id) {
            $userrace = UserRace::find($request->userrace_id);
            $order = Order::where('id', $request->order_id)->first();
            $userrace->questionanswer()->delete();
            $userrace->delete();

            $ticket = Ticket::find($request->ticket_id);

            $general_ticket = Ticket::where('race_id', $request->race_id)->where('name', 'like', '%general%')->first();
            $general_ticket_ticket_end = date("Y-m-d", strtotime($general_ticket['ticket_end']));
            $date_now = date("Y-m-d");

            foreach (json_decode($order['meta'], true) as $key => $value) {
                if (preg_match("/TFT/i", $key) &&
                (!isset($request->participant_ticket_id) || $request->participant_ticket_id == $key)) {
                    if ($value['_ticket_id'] == $request->ticket_id) {
                        if ($general_ticket_ticket_end < $date_now && $user->id != 1481) {
                            $ticket_cost = round($value['Price']*0.2, 0);
                        } else {
                            $ticket_cost = $value['Price'];
                        }
                        if ($order->success == 'true') {
                            $order->success = 'refunded: '.$key;
                        } else {
                            $order->success .= ', refunded: '.$key;
                        }
                        $order->save();
                    }
                }
            }

            $usercredit = new Usercredit();
            $usercredit->user_id = $user->id;
            $usercredit->amount = $ticket_cost;
            $usercredit->action = 'Refund: '.$ticket->race_id.' - '.$ticket->name;
            $usercredit->save();
        }
        if (\Request::is('api*') || \Request::wantsJson()) {
            return response()->json(['status' => 200, 'message' => 'refund-success', 'data' => $usercredit]);
        } else {
            return back();
        }
    }
}
