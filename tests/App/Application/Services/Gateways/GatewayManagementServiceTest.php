<?php
namespace App\Tests\Application\Services\Gateways;

use App\Application\Services\Gateways\GatewayManagementService;
use App\Application\Services\RegisterGatewayCommand;
use App\Domain\DTO\GatewayDTO;
use App\Infrastructure\Persistence\InMemory\Gateways\InMemoryGatewayRepository;
use PHPUnit\Framework\TestCase;

class GatewayManagementServiceTest extends TestCase
{
    /** @var InMemoryGatewayRepository */
    private $gatewayRepository;

    /** @var GatewayManagementService */
    private $service;

    public function setUp(): void
    {
        $this->gatewayRepository = new InMemoryGatewayRepository();

        $this->service = new GatewayManagementService($this->gatewayRepository);
    }

    public function test_registering_a_gateway_should_return_a_dto_object()
    {
        $dto = $this->service->registerGateway(
            RegisterGatewayCommand::fromPayload(json_encode([
                'data' => [
                    'id' => 'abc-123',
                    'assistant_uuid' => 'xtx-787',
                    'firmware_version' => 'v2.1',
                ]
            ]))
        );

        $this->assertInstanceOf(GatewayDTO::class, $dto);
    }
}