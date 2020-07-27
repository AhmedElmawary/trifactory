<?php

namespace App\Helpers;

class JsonHelper
{
    public static function toJsonDataObject($mixed)
    {
        return response()->json(
            [
            'data' => $mixed->toArray(),
            ]
        );
    }

    public static function toJsonObject($mixed)
    {
        return response()->json($mixed);
    }
}
