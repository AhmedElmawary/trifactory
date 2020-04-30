<?php

namespace App\PayMob;

use BaklySystems\PayMob\Facades\PayMob;

class PayMobCash extends PayMob
{
     /**
     * Send POST cURL request to paymob servers.
     *
     * @param  string  $url
     * @param  array  $json
     * @return array
     */
    protected function cURL($url, $json)
    {
        // Create curl resource
        $ch = curl_init($url);
        // Request headers
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        // Return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // $output contains the output string
        $output = curl_exec($ch);
        // Close curl resource to free up system resources
        curl_close($ch);
        return json_decode($output);
    }

    /**
     * Get payment key to load iframe on paymob servers
     *
     * @param  string  $token
     * @param  int  $amount_cents
     * @param  int  $order_id
     * @param  string  $email
     * @param  string  $fname
     * @param  string  $lname
     * @param  int  $phone
     * @param  string  $city
     * @param  string  $country
     * @return array
     */
    public function getCashPaymentKeyPaymob(
        $token,
        $amount_cents,
        $order_id,
        $email = 'null',
        $fname = 'null',
        $lname = 'null',
        $phone = 'null',
        $city = 'null',
        $country = 'null',
        $state = 'null',
        $street = 'null',
        $building = 'null',
        $floor = 'null',
        $apartment = 'null'
    ) {
        // Request body
        $json = [
            'amount_cents' => $amount_cents,
            'expiration'   => 36000,
            'order_id'     => $order_id,
            "billing_data" => [
                "email"        => $email,
                "first_name"   => $fname,
                "last_name"    => $lname,
                "phone_number" => $phone,
                "city"         => $city,
                "country"      => $country,
                "state"      => $state,
                'street'       => $street,
                'building'     => $building,
                'floor'        => $floor,
                'apartment'    => $apartment
            ],
            'currency'            => 'EGP',
            'integration_id'      => config('paymob.cash_integration_id'),
        ];

        // Send curl
        $payment_key = $this->cURL(
            'https://accept.paymobsolutions.com/api/acceptance/payment_keys?token='.$token,
            $json
        );

        return $payment_key;
    }

        /**
     * Make payment for API (moblie clients).
     *
     * @param  string  $token
     * @return array
     */
    public function makePayment(
        $token
    ) {
        // JSON body.
        $json = [
          'source' => [
            'identifier'        => 'cash',
            'subtype'           => 'CASH',
           ],
          'payment_token' => $token
        ];
        // Send curl
        $payment = $this->cURL(
            'https://accept.paymobsolutions.com/api/acceptance/payments/pay',
            $json
        );
        return $payment;
    }
}
