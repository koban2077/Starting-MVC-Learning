<?php

namespace App\Utils;

class Config
{
    public static function get(string $key): string
    {
        $path = __DIR__ . '/../../.env';

        $content = file($path);
        foreach ($content as $line => $value) {
            if ($line != 0) {
                $arr = explode('=', $value);
                if ($arr[0] == $key){
                    return trim($arr[1]);
                }

            }
        }
    }
}