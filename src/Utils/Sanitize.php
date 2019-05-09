<?php
declare(strict_types=1);


namespace DemoApi\Utils;


class Sanitize
{
    public static function sanitize_string(string $input): string
    {
        return filter_var($input, FILTER_SANITIZE_STRING);
    }
}
