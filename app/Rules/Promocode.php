<?php

namespace App\Rules;

use Auth;
use Illuminate\Contracts\Validation\Rule;

class Promocode implements Rule
{
    public $cartItems;
    public $item;
    public $cartItem;
    public $cartItemCode = null;
    public $cartCodes = [];
    public $message = 'error!';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($cartItems, $item)
    {
        $this->cartItems = $cartItems;
        $this->item = $item;
        $this->cartItem = $this->cartItems[$this->item];
        if (count($this->cartItem['conditions'])) {
            $this->cartItemCode = $this->cartItem['conditions'][0]->getAttributes()['code'];
        }
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = Auth::user();

        $races = [];
        $promocode = \App\Promocode::where('code', $value)->first();
        if ($promocode) {
            $races = $promocode->races()->get();
            $promocode = null;
        }

        if (count($races) > 0) {
            $promocode = \App\Promocode::where('code', $value)
                ->where('published', 'YES')
                ->whereHas('races', function ($query) {
                    $query->where('race_id', '=', $this->cartItem['attributes']['_race_id']);
                })
                ->whereDoesntHave('userPromocodeOrder', function ($query) use ($user) {
                    $query->where('user_id', '=', $user->id);
                })
                ->first();
        } else {
            $promocode = \App\Promocode::where('code', $value)
                ->where('published', 'YES')
                ->whereDoesntHave('userPromocodeOrder', function ($query) use ($user) {
                    $query->where('user_id', '=', $user->id);
                })
                ->first();
        }


        if (!$promocode) {
            $this->message = 'The selected code is invalid.';
            return false;
        }

        foreach ($this->cartItems as $cartItem) {
            if (count($cartItem['conditions'])) {
                $this->cartCodes[] = $cartItem['conditions'][0]->getAttributes()['code'];
            }
        }

        if (in_array($value, $this->cartCodes)) {
            $this->message = 'The selected code can only be used once.';
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
