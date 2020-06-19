<?php
namespace App\Domain\Models\Gateways;

use App\Domain\Exceptions\GatewayNotFoundException;

interface GatewayRepository
{
    public function persist(Gateway $gateway): void;
    public function flush(): void;
    /**
     * @throws GatewayNotFoundException
     */
    public function byId(string $id): Gateway;
}
