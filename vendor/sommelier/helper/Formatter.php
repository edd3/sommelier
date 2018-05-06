<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace sommelier\helper;

class Formatter
{

    public static function toDateTime($n)
    {
        return date('Y-m-d H:i:s',$n);
    }

    public static function toDate($n)
    {
        return date('Y-m-d',$n);
    }
}
