<?php
namespace App\Tests\Infrastructure\Http\Api\Controllers;

use App\Domain\Models\Gateways\GatewayRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\HttpClientKernel;


class RegisterGatewayServiceTest extends WebTestCase
{
    /** @var HttpClientKernel */
    private $client;
    /** @var GatewayRepository */
    private $gatewayRepository;


    protected function setUp(): void
    {
        $this->client = static::createClient();

        $this->gatewayRepository = self::$container->get(GatewayRepository::class);
    }

    public function test_creating_a_gateway_should_return_a_created_response_code()
    {
        $this->client->request('POST', '/gateways/register', [], [],
            ['content-type' => 'application/json'],
            json_encode([
                'data' => [
                    'id' => 'abc-123',
                    'assistant_uuid' => 'xtx-787',
                    'firmware_version' => 'v2.1',
                ]
            ])
        );

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }

    public function test_creating_a_gateway_should_return_created_gateway_basic_data()
    {
        $this->client->request('POST', '/gateways/register', [], [],
            ['content-type' => 'application/json'],
            json_encode([
                'data' => [
                    'id' => 'abc-123',
                    'assistant_uuid' => 'xtx-787',
                    'firmware_version' => 'v2.1',
                ]
            ])
        );

        $this->assertEquals('{"data":{"id":"abc-123","assistant_uuid":"xtx-787","firmware_version":"v2.1"}}',
            $this->client->getResponse()->getContent()
        );
    }
}
