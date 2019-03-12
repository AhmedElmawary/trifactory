<?php

namespace App\Rules;

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
        $promocode = \App\Promocode::where('code', $value)
                   ->where('published', 'YES')
                   ->where('race_id', $this->cartItem['attributes']['_race_id'])
                   ->first();

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
