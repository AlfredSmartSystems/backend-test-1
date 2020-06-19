<?php
namespace App\Domain\Models\Gateways;

use App\Application\Services\RegisterGatewayCommand;

class Gateway
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $assistantUuid;
    /**
     * @var string
     */
    private $firmwareVersion;
    /**
     * @var string
     */
    private $localIPAddress;

    public static function register(RegisterGatewayCommand $command) : self
    {
        return new self(
            $command->id(),
            $command->assistantUuid(),
            $command->firmwareVersion()
        );
    }

    private function __construct(
        string $id,
        string $assistantUuid,
        string $firmwareVersion
    ) {
        $this->id = $id;
        $this->assistantUuid = $assistantUuid;
        $this->firmwareVersion = $firmwareVersion;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function assistantUuid(): string
    {
        return $this->assistantUuid;
    }

    public function firmwareVersion(): string
    {
        return $this->firmwareVersion;
    }

    public function updateNetworkAddress(string $ip): void
    {
        $this->localIPAddress = $ip;
    }
}
