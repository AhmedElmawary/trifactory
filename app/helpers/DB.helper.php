<?php
namespace App\Helpers;

use App\User;

class DBHelper
{
    public static function insertFBIdAndImageToUser($user, $userFb):void
    {
        $user->fb_id = $userFb->getId();
        $user->profile_image = $userFb->getId().".jpeg";
        $user->save();
        $user->generateToken();
    }

    public static function retreiveUserByFBidOrEmail($userFb)
    {
        return User::where("email", $userFb->getEmail())
            ->orWhere("fb_id", $userFb->getId())
            ->first();
    }
}
