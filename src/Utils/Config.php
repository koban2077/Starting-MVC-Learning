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
                $arr = explode(' ', $value);
                if (strpos($arr[0], trim($key)) !== false) {
                    $credentials = explode(':', $arr[0]);
                    return trim($credentials[1]);
                }
            }
        }
    }
}