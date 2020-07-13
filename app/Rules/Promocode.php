<?php

namespace App\Rules;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;

class Promocode implements Rule
{
    public $cartItems;
    public $item;
    public $cartItem;
    public $cartItemCode = null;
    public $cartCodes = [];
    public $message = 'error!';
    private $promo_races;
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
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $promocode = \App\Promocode::where('code', $value)->first();

        if (!isset(($promocode))) {
            $this->message = 'The selected code is invalid.';
            return false;
        }
        $this->promo_races = json_decode($promocode->promo_races);

        if (! isset($this->promo_races)) {
            $this->message = 'The selected code is invalid.';
            return false;
        }

        foreach ($this->cartItems as $cartItem) {
            if (count($cartItem['conditions'])) {
                $this->cartCodes[] = $cartItem['conditions'][0]->getAttributes()['code'];
            }
        }
       
        if (isset($this->promo_races) && ! in_array($this->cartItem["attributes"]["_race_id"], $this->promo_races)) {
            $this->message = 'The selected code is invalid.';
            return false;
        }

        if (in_array($value, $this->cartCodes) && $promocode->unlimited == 0 && $promocode->limit == -1) {
            $this->message = 'The selected code can only be used once.';
            return false;
        }

        if ($promocode->limit == 0
            || (in_array($value, $this->cartCodes)
            && $promocode->limit <= array_count_values($this->cartCodes)[$value]
            && $promocode->unlimited == 0)
        ) {
            $this->message = 'The selected code limit has exceeded.';
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
