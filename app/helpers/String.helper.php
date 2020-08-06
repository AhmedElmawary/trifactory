<?php
namespace App\Helpers;

use DateTime;
use DateTimeZone;
use Exception;

class StringHelper
{
    private static $rawString
        = "0123456789asdfghjklzxcvbnm,./qwertyuiopASD\r\t\eFGHJKLZXCVBNMQWERTYUIOP[]=)(*&^%$#@!~`?;:'\*/-.";

    private static $rawStringlen ;

    private static $lastInedx ;

    public static function setRawStringFromString(String $string) :void
    {
        self::$rawString = $string;
    }

    public static function setRawStringFromArray(Array $arrayOfString) :void
    {
        self::validateInput($arrayOfString);
        $arrayOfString = implode($arrayOfString);
        self::$rawString = $arrayOfString;
    }

    public static function generateHashWithTimeZoneFor(int $limit):string
    {
        return self::generateHashFor($limit)
               .date_format(new DateTime("now", new DateTimeZone("Africa/Cairo")), "d-m-Y_H:I:s:u");
    }

    public static function generateHashFor(int $limit) :string
    {
        self::validateInput($limit);

        self::rawStringSize();
        $returnedHash='';
        for ($i=0; $i++ < $limit;) {
            $returnedHash.= self::$rawString[rand(0, self::$lastInedx)];
        }
        return $returnedHash;
    }

    private static function rawStringSize() :void
    {
        self::$rawStringlen = strlen(self::$rawString);
        self::lastIndex();
    }

    private static function lastIndex() :void
    {
        self::$lastInedx = self::$rawStringlen-1;
    }

    private static function validateInput(/**mixed */ $input) :void
    {
        if (!isset($input) || empty($input)) {
            throw new Exception("invalid input");
        }
    }
}
