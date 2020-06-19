<?php
namespace App\Domain\DTO;

use App\Domain\Models\Gateways\Gateway;


class GatewayDTO
{
    /** @var string */
    private $gatewayId;
    /** @var string */
    private $assistantUUID;
    /** @var string */
    private $firmwareVersion;

    public static function fromGateway(Gateway $gateway) : self
    {
        return new self(
            $gateway->id(),
            $gateway->assistantUuid(),
            $gateway->firmwareVersion()
        );
    }

    private function __construct(
        string $gatewayId,
        string $assistantUUID,
        string $firmwareVersion
    ) {
        $this->gatewayId = $gatewayId;
        $this->assistantUUID = $assistantUUID;
        $this->firmwareVersion = $firmwareVersion;
    }

    public function gatewayId(): string
    {
        return $this->gatewayId;
    }

    public function assistantUUID(): string
    {
        return $this->assistantUUID;
    }

    public function firmwareVersion(): string
    {
        return $this->firmwareVersion;
    }

    public function toArray(): array
    {
        return [
            'data' => [
                'id' => $this->gatewayId,
                'assistant_uuid' => $this->assistantUUID,
                'firmware_version' => $this->firmwareVersion,
            ]
        ];
    }
}
