<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Question;
use App\Voucher;
use Illuminate\Support\Facades\Auth;
use App\Promocode;
use Validator;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cartSubTotal = \Cart::getSubTotal();
        $cartTotal = \Cart::getTotal();
        $cartItems = \Cart::getContent()->toArray();

        return view('cart', [
            'cartItems' => $cartItems,
            'cartSubTotal' => $cartSubTotal,
            'cartTotal' => $cartTotal,
        ]);
    }

    public function payment(Request $request)
    {
        $cartSubTotal = \Cart::getSubTotal();
        $cartTotal = \Cart::getTotal();
        $cartItems = \Cart::getContent()->toArray();
        $condition = \Cart::getCondition('Credit');
        $voucher = \Cart::getCondition('Voucher');

        $data = [
            'cartItems' => $cartItems,
            'cartSubTotal' => $cartSubTotal,
            'cartTotal' => $cartTotal,
            'condition' => null,
            'voucher' => null,
            'credit' => 0,
        ];

        $user = Auth::user();
        if ($user) {
            $data['credit'] = $user->credit->sum('amount');
        }

        if ($condition && $condition->getValue() != 0) {
            $data['condition'] = $condition;
        }

        if ($voucher && $voucher->getValue() != 0) {
            $data['voucher'] = $voucher;
        }

        return view('cart-payment', $data);
    }

    public function itemCode(Request $request)
    {
        $inputs = $request->all();
        $item = $inputs['item'];

        $cartItems = \Cart::getContent()->toArray();

        $code = null;
        if (isset($inputs['code'])) {
            $code = $inputs['code'];
        } else {
            \Cart::clearItemConditions($item);
        }

        $validator = Validator::make($request->all(), [
            'item' => ['required'],
            'code' => [
                new \App\Rules\Promocode($cartItems, $item),
            ]
        ]);

        if ($validator->fails()) {
            return redirect()
            ->action('CartController@index')
            ->withErrors($validator, $item)
            ->withInput();
        }

        if (array_key_exists($item, $cartItems)) {
            $cartItem = $cartItems[$item];

            $promocode = Promocode::where('code', $code)
                        ->where('published', 'YES')
                        ->where('race_id', $cartItem['attributes']['_race_id'])
                        ->first();

            if ($promocode) {
                $value = null;

                if (strpos($promocode->value, '%')) {
                    $value = $cartItem['price'] * $cartItem['quantity'] * str_replace('%', '', $promocode->value);
                    $value = '- ' . ceil($value / 100);
                } else {
                    $value = '-' . $promocode->value;
                }

                $condition = new \Darryldecode\Cart\CartCondition([
                    'name' => $promocode->code,
                    'type' => 'promocode',
                    'value' => $value,
                    'attributes' => [
                        'code' => $code
                    ]
                ]);

                \Cart::addItemCondition($item, $condition);
            }
        }

        return redirect()->action(
            'CartController@index'
        );
    }

    public function voucher(Request $request)
    {
        $inputs = $request->all();
        $code = null;
        if (isset($inputs['code'])) {
            $code = $inputs['code'];
        }

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'code' => [
                new \App\Rules\Voucher($user),
            ]
        ]);

        if ($validator->fails()) {
            return redirect()
            ->action('CartController@payment')
            ->withErrors($validator)
            ->withInput();
        }

        if ($code == null) {
            \Cart::removeCartCondition('Voucher');
        } else {
            if ($user) {
                $voucher = Voucher::where('code', $code)
                        ->where('user_id', $user->id)
                        ->where('usedOn', null)
                        ->where('order_id', null)
                        ->first();

                if ($voucher) {
                    $condition = new \Darryldecode\Cart\CartCondition([
                        'name' => 'Voucher',
                        'type' => 'voucher',
                        'target' => 'total',
                        'value' => $voucher->amount * -1,
                        'attributes' => [
                            'code' => $code
                        ]
                    ]);

                    \Cart::condition($condition);
                }
            }
        }

        return redirect()->action(
            'CartController@payment'
        );
    }

    public function credit(Request $request)
    {
        $inputs = $request->all();
        $credit = $inputs['credit'];

        $cartTotal = \Cart::getTotal();

        $dbCredit = 0;
        // validate credit
        $user = Auth::user();
        if ($user) {
            $dbCredit = $user->credit->sum('amount');
        }

        if ($credit <= $dbCredit) {
            if ($cartTotal < $credit) {
                $credit = $cartTotal;
            }

            $condition = new \Darryldecode\Cart\CartCondition([
                'name' => 'Credit',
                'type' => 'credit',
                'target' => 'total', // this condition will be applied to cart's total when getTotal() is called.
                'value' => $credit * -1,
            ]);

            \Cart::condition($condition);
        }

        return redirect()->action(
            'CartController@payment'
        );
    }

    public function emptyCart(Request $request)
    {
        \Cart::clear();
        \Cart::clearCartConditions();
    }

    public function removeFromCart(Request $request)
    {
        $inputs = $request->all();
        $itemKey = $inputs['item_key'];

        \Cart::remove($itemKey);

        return redirect()->action(
            'CartController@index'
        );
    }

    public function addToCart(Request $request)
    {
        $input = $request->all();
        $number_of_tickets = $input['number_of_tickets'];

        $grouppedInput = [];

        for ($i = 1; $i <= $number_of_tickets; $i++) {
            $ticket_keys = preg_filter('/^ticket_' . $i . '_(.*)/', '$1', array_keys($input));
            foreach ($ticket_keys as $key) {
                $grouppedInput['ticket_' . $i][$key] = $input['ticket_' . $i . '_' . $key];
            }
        }

        foreach ($grouppedInput as $ticketValues) {
            $ticket = Ticket::find($ticketValues['type']);
            $race = $ticket->race()->first();

            if ($ticketValues['use'] == 'myself') {
                $user = Auth::user();
                if ($user) {
                    $attributes = [
                        'For' => $user->name,
                        'E-mail' => $user->email,
                        'Phone' => $user->phone,
                    ];
                }
            } else {
                $attributes = [
                    'For' => $ticketValues['firstname'] . ' ' . $ticketValues['lastname'],
                    'E-mail' => $ticketValues['email'],
                    'Phone' => $ticketValues['phone'],
                ];
            }

            $attributes['Event'] = $race->event()->first()->name;
            $attributes['Race'] = $race->name;
            $attributes['Ticket Type'] = $ticket->name;
            $attributes['Price'] = $ticket->price;
            $attributes['_race_id'] = $race->id;
            $attributes['_ticket_id'] = $ticket->id;

            $metas = preg_filter('/^meta_(.*)/', '$1', array_keys($ticketValues));
            $metas = array_values($metas);

            foreach ($metas as $meta) {
                $question = Question::where('id', $meta)
                            ->with('answertype', 'answervalue')
                            ->first();

                $answervalues = $question->answervalue()->get();

                // for lists
                if (count($answervalues)) {
                    $answer = $answervalues->firstWhere('id', $ticketValues['meta_' . $meta]);
                    $attributes[$question->question_text] = $answer->value;
                    $attributes['_qid' . $question->id] = $answer->id;
                } else {
                    $attributes[$question->question_text] = $ticketValues['meta_' . $meta];
                    $attributes['_qid' . $question->id] = $ticketValues['meta_' . $meta];
                }
            }

            \Cart::add([
                'id' => uniqid('TFT-' . $ticket->id),
                'name' => $ticket->name,
                'price' => $ticket->price,
                'quantity' => 1,
                'conditions' => [],
                'attributes' => $attributes
            ]);
        }

        return redirect()->action(
            'CartController@index'
        );
    }
}
