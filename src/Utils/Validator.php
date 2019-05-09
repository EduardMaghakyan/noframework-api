<?php
declare(strict_types=1);


namespace DemoApi\Utils;


class Validator
{
    public static function isValidSkuFormat(string $sku): bool
    {
        $pattern = '/^[A-Z]{2}-[0-9]{2}$/';
        return (bool)preg_match($pattern, $sku);
    }
}
