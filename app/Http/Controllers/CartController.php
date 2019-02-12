<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Ticket;
use App\Question;
use Mail;

use App\Mail\VoucherPurchase;
use App\Mail\SendVoucher;
use App\Events\VoucherPurchased;

use Illuminate\Support\Facades\Auth;

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

        $data = [
            'cartItems' => $cartItems,
            'cartSubTotal' => $cartSubTotal,
            'cartTotal' => $cartTotal,
            'condition' => null,
            'credit' => 0,
        ];

        $user = Auth::user();
        if($user)
        {
            $data['credit'] = $user->credit->sum('amount');
        }

        if($condition && $condition->getValue() != 0)
        {
            $data['condition'] = $condition;
        }
        
        return view('cart-payment', $data);
    }

    public function credit(Request $request)
    {
        $inputs = $request->all();
        $credit = $inputs['credit'];
        
        $dbCredit = 0;
        // validate credit
        $user = Auth::user();
        if($user)
        {
            $dbCredit = $user->credit->sum('amount');
        }

        if ($credit <= $dbCredit) {

            $condition = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'Credit',
                'type' => 'credit',
                'target' => 'total', // this condition will be applied to cart's total when getTotal() is called.
                'value' => $credit * -1,
            ));

            \Cart::condition($condition);
        }

        return redirect()->action(
            'CartController@payment'
        );
    }

    public function emptyCart(Request $request) {
        \Cart::clear();
    }

    public function addToCart(Request $request)
    {
        $input = $request->all();
        $number_of_tickets = $input['number_of_tickets'];

        $grouppedInput = array();

        for($i=1;$i<=$number_of_tickets;$i++)
        {
            $ticket_keys = preg_filter('/^ticket_'.$i.'_(.*)/', '$1', array_keys($input));
            foreach($ticket_keys as $key)
            {
                $grouppedInput['ticket_'.$i][$key] = $input['ticket_'.$i.'_'.$key];
            }
        }
        
        foreach($grouppedInput as $ticketValues)
        {
            $ticket = Ticket::find($ticketValues['type']);
            $race = $ticket->race()->first();

            if($ticketValues['use'] == 'myself')
            {
                $user = Auth::user();
                if($user)
                {
                    $attributes = [
                        'For' => $user->name,
                        'E-mail' => $user->email,
                        'Phone' => $user->phone,
                    ];
                }
            }
            else {
                $attributes = [
                    'For' => $ticketValues['firstname'] . ' ' . $ticketValues['lastname'],
                    'E-mail' => $ticketValues['email'],
                    'Phone' => $ticketValues['phone'],
                ];
            }
            
            $attributes['Race'] = $race->name;
            $attributes['Ticket Type'] = $ticket->name;
            $attributes['Price'] = $ticket->price;
            
            $metas = preg_filter('/^meta_(.*)/', '$1', array_keys($ticketValues));
            $metas = array_values($metas);

            foreach($metas as $meta)
            {
                $question = Question::where("id", $meta)
                            ->with('answertype', 'answervalue')
                            ->first();
                
                $answervalues = $question->answervalue()->get();

                if(count($answervalues))
                {
                    $answer = $answervalues->firstWhere('id', $ticketValues['meta_'.$meta]);
                    $attributes[$question->question_text] = $answer->value;
                }
                else
                {
                    $attributes[$question->question_text] = $ticketValues['meta_'.$meta];
                }
            }
            
            \Cart::add(array(
                'id' => uniqid("TFT-" . $ticket->id),
                'name' => $ticket->name,
                'price' => $ticket->price,
                'quantity' => 1,
                'conditions' => [],
                'attributes' => $attributes
            ));
        }

        return redirect()->action(
            'CartController@index'
        );
    }
}
