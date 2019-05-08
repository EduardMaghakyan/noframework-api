<?php
declare(strict_types=1);


namespace DemoApi\Application\Exceptions;


use RuntimeException;

class ProductUnitPriceNotFoundException extends RuntimeException implements ProductApiException
{
}
