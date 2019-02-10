<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayMob;
use App\Order;
use App\Events\VoucherPurchased;

class PaymentController extends Controller
{
    public function index(Request $request) {
        $auth = PayMob::authPaymob();

        $inputs = $request->all();

        $meta = new \stdClass();
        $meta->type = 'voucher';
        $meta->qty = $inputs["qty"];
        $meta->discount_amount = $inputs["discount_amount"];
        $meta->user_email = $inputs["recipient_email"];
        
        $order = new Order();
        $order->id = uniqid('TFV-');
        $order->totalCost = $inputs["qty"] * $inputs["discount_amount"];
        $order->meta = json_encode($meta);
        
        $order->save();


        $paymobOrder = PayMob::makeOrderPaymob(
            $auth->token, // this is token from step 1.
            $auth->profile->id, // this is the merchant id from step 1.
            $order->totalCost * 100, // total amount by cents/piasters.
            $order->id // your (merchant) order id.
        );

        $order->update(['paymob_order_id' => $paymobOrder->id]); 

        $paymentKey = PayMob::getPaymentKeyPaymob(
            $auth->token, // from step 1.
            $order->totalCost * 100, // total amount by cents/piasters.
            $paymobOrder->id // paymob order id from step 2.
            // For billing data
            // $user->email, // optional
            // $user->firstname, // optional
            // $user->lastname, // optional
            // $user->phone, // optional
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

        $meta = json_decode($order->meta);
        if ($meta->type == 'voucher') {
            event(new VoucherPurchased($meta));
        }
    }
}
