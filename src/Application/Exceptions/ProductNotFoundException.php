<?php
declare(strict_types=1);


namespace DemoApi\Application\Exceptions;


use RuntimeException;

class ProductNotFoundException extends RuntimeException implements ProductApiException
{

}
