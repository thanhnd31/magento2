<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 31/08/2017
 * Time: 14:05
 */

namespace ThanhND\SocialLogin\Helper;


class Data
{
    public function getAvailableSocials(){
        $availableSocials = array(
            "google"=>"Google",
            "facebookk"=>"Facebook",
            "twitter"=>"Twitter",
            "instagram"=>"Instagram"
        );

        return $availableSocials;
    }
}