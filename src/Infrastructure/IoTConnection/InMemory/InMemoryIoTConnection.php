<?php
namespace App\Infrastructure\IoTConnection\InMemory;

use App\Infrastructure\IoTConnection\IoTConnection;


class InMemoryIoTConnection implements IoTConnection
{
    public function sendCommand(string $command): ?string
    {
        if($command == 'address') {
            return '192.168.1.100';
        }

        return null;
    }
}
