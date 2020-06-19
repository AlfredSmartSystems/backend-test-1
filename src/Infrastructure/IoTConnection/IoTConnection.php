<?php
namespace App\Infrastructure\IoTConnection;

interface IoTConnection
{
    public function sendCommand(string $command): ?string;
}