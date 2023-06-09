<?php


namespace App\Helpers;


use Ramsey\Uuid\Type\Integer;

class ArrayHelper
{
    public static function pluck($collection, $attr){
        $array = [];
        dd($collection);
        foreach ($collection as $item){
            $array[] = $item[$attr];
        }
        return $array;
    }
}
