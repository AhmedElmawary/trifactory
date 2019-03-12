<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Voucher implements Rule
{
    public $user;
    public $message = 'error!';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
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
        $voucher = \App\Voucher::where('code', $value)->first();

        if (!$voucher) {
            $this->message = 'Invalid voucher code.';
            return false;
        }

        if (intval($voucher->user_id) !== $this->user->id) {
            $this->message = 'Invalid voucher code for this user.';
            return false;
        }

        if ($voucher->usedOn !== null) {
            $this->message = 'This voucher has expired.';
            return false;
        }

        if ($voucher->order_id !== null) {
            $this->message = 'This voucher has expired.';
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
