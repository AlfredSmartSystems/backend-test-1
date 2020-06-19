<?php
namespace App\Application\Services\Gateways;

use App\Application\Exceptions\GatewayAlreadyExistsException;
use App\Application\Services\RegisterGatewayCommand;
use App\Domain\DTO\GatewayDTO;
use App\Domain\Exceptions\GatewayNotFoundException;
use App\Domain\Models\Gateways\Gateway;
use App\Domain\Models\Gateways\GatewayRepository;
use App\Infrastructure\IoTConnection\InMemory\InMemoryIoTConnection;


class GatewayManagementService
{
    /** @var GatewayRepository */
    private $gatewayRepository;

    public function __construct(GatewayRepository $gatewayRepository)
    {
        $this->gatewayRepository = $gatewayRepository;
    }

    /**
     * @throws GatewayAlreadyExistsException
     */
    public function registerGateway(RegisterGatewayCommand $command): GatewayDTO
    {
        try {
            $this->gatewayRepository->byId($command->id());
            throw new GatewayAlreadyExistsException((string)$command->id());
        } catch (GatewayNotFoundException $exception) {
        }

        $gateway = Gateway::register($command);
        $this->updateGatewayLocalNetworkAddress($gateway);

        $this->gatewayRepository->persist($gateway);
        $this->gatewayRepository->flush();

        return GatewayDTO::fromGateway($gateway);
    }

    public function updateGatewayLocalNetworkAddress(Gateway $gateway): void
    {
        $iot = new InMemoryIoTConnection();
        $gateway->updateNetworkAddress($iot->sendCommand('address'));
    }

    public function unregisterGateway(string $gatewayId): void
    {

    }
}
