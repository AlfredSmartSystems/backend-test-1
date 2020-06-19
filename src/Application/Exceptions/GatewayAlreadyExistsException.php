<?php
namespace App\Application\Exceptions;

use Throwable;

class GatewayAlreadyExistsException extends \RuntimeException
{
    public function __construct(string $message, int $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
