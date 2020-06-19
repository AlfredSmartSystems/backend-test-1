<?php
namespace App\Infrastructure\Persistence\InMemory\Gateways;

use App\Domain\Exceptions\GatewayNotFoundException;
use App\Domain\Models\Gateways\Gateway;
use App\Domain\Models\Gateways\GatewayRepository;


class InMemoryGatewayRepository implements GatewayRepository
{
    private $db = [];

    public function persist(Gateway $gateway): void
    {
        $this->db[$gateway->id()] = $gateway;
    }

    public function flush(): void
    {

    }

    public function byId(string $id): Gateway
    {
        if (isset($this->db[$id])) {
            return $this->db[$id];
        }

        throw new GatewayNotFoundException($id);
    }
}
