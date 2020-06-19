<?php
namespace App\Domain\Exceptions;

use Throwable;

class GatewayNotFoundException extends \DomainException
{
    public function __construct(string $message, int $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
