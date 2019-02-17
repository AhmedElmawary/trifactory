<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayMob;
use App\Order;
use App\Events\VoucherPurchased;
use App\Events\TicketPurchased;
use Auth;

class PaymentController extends Controller
{
    public function buyTickets(Request $request)
    {

        $inputs = $request->all();
        $paymentMethod = $inputs['paymet_method'];
        
        $cartTotal = \Cart::getTotal();
        $cartItems = \Cart::getContent()->toArray();

        foreach ($cartItems as $item) {
            $meta[$item['id']] = new \stdClass();
            $meta[$item['id']]->type = 'ticket';
            $meta[$item['id']]->paymentMethod = $paymentMethod;
            foreach ($item['attributes'] as $key => $attribute) {
                $meta[$item['id']]->$key = $attribute;
            }
        }

        $user = Auth::user();

        $order = new Order();
        $order->id = uniqid('TFT-');
        $order->totalCost = $cartTotal;
        $order->user_id = $user->id;
        $order->meta = json_encode($meta);
        
        $order->save();
        
        return $this->makePayment($order);
    }

    public function buyVouchers(Request $request)
    {

        $inputs = $request->all();
        $paymentMethod = $inputs['paymet_method'];
        
        $meta = new \stdClass();
        $meta->type = 'voucher';
        $meta->qty = $inputs["qty"];
        $meta->discount_amount = $inputs["discount_amount"];
        $meta->user_email = $inputs["recipient_email"];
        $meta[$item['id']]->paymentMethod = $paymentMethod;
        
        $user = Auth::user();

        $order = new Order();
        $order->id = uniqid('TFV-');
        $order->user_id = $user->id;
        $order->totalCost = $inputs["qty"] * $inputs["discount_amount"];
        $order->meta = json_encode($meta);

        $order->save();

        return $this->makePayment($order);
    }

    public function makePayment($order)
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
            
        $paymentKey = PayMob::getPaymentKeyPaymob(
            $auth->token, // from step 1.
            $order->totalCost * 100, // total amount by cents/piasters.
            $paymobOrder->id // paymob order id from step 2.
            // For billing data
            // $user->email, // optional
            // $user->firstname, // optional
            // $user->lastname, // optional
            // $user->phone // optional
            // $city->name, // optional
            // $country->name // optional
        );
        
        return view('payment', ['paymentKey' => $paymentKey]);
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
        $order   = Order::wherePaymobOrderId($orderId)->first();
        // Statuses.
        $isSuccess  = $request['obj']['success'];
        $isVoided   = $request['obj']['is_voided'];
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
        
        if ($order->success === 'true') {
            $meta = json_decode($order->meta);
        
            if (property_exists($meta, 'type')) {
                event(new VoucherPurchased($meta));
            } else {
                $user = Auth::user();
                foreach ($meta as $ticketId => $ticket) {
                    event(new TicketPurchased($ticketId, $ticket, $user));
                }
            }

            \Cart::clear();
        }

        return $this->success($order);
    }

    public function success($order)
    {
        return view('payment-success', ['order' => $order]);
    }
}
