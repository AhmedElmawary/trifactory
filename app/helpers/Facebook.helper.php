<?php

namespace App\Helpers;

class FacebookHelper
{

    private static $fields = [
        'first_name',
        'last_name',
        'email',
        'gender',
        'verified',
        'link',
        'birthday'];
   
    public static function getHelperFields() :Array
    {
        return self::$fields;
    }

    public static function setHelperFields(Array $fields) :void
    {
        self::$fields = $fields;
    }
    
    public static function addHelperField(String $fields) :void
    {
        self::$fields[] = $fields;
    }

    public static function getHeleperField(int $index)
    {
        return self::$fields[$index];
    }
}
