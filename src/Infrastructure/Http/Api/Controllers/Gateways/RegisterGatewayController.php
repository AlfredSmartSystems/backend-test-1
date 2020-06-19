<?php
namespace App\Infrastructure\Http\Api\Controllers\Gateways;

use App\Application\Exceptions\GatewayAlreadyExistsException;
use App\Application\Exceptions\InvalidPayloadException;
use App\Application\Services\Gateways\GatewayManagementService;
use App\Application\Services\RegisterGatewayCommand;
use App\Infrastructure\Persistence\InMemory\Gateways\InMemoryGatewayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class RegisterGatewayController extends AbstractController
{
    /** @var GatewayManagementService */
    private $service;

    public function __construct()
    {
        $this->service = new GatewayManagementService(
            new InMemoryGatewayRepository()
        );
    }

    /**
     * Received Payload
     * {
     *      "data":{
     *          "id":"abc-123",
     *          "assistant_uuid": "abc-123-def-456",
     *          "firmware_version": "v1.2.5",
     *       },
     *  }
     *
     * @return JsonResponse HTTP_CREATED
     *
     * {
     *    "data": {
     *       "id": "string",
     *       "assistant_uuid": "string",
     *       "firmware_version": "string",
     *    }
     * }
     *
     * @Route("gateways/register", name="register_gateway", methods={"POST"})
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $command = RegisterGatewayCommand::fromPayload($request->getContent());

            $gatewayDTO = $this->service->registerGateway($command);

            $responsePayload = $gatewayDTO->toArray();

            if ($gatewayDTO->firmwareVersion() === 'v1.1.1') {
                /** Fix for Gateways v1.1.1 */
                $responsePayload['assistant_uuid'] = '000'.$responsePayload['assistant_uuid'];
            }

            return $this->json($responsePayload, JsonResponse::HTTP_CREATED);

        } catch (GatewayAlreadyExistsException $gatewayAlreadyExistsException) {
            return $this->json(['detail' => 'Gateway already registered'], $gatewayAlreadyExistsException->getCode());
        } catch (InvalidPayloadException $exception) {
            return $this->json(['detail' => $exception->getMessage()], $exception->getCode());
        } catch (\DomainException $exception) {
            return $this->json(['detail' => $exception->getMessage()], $exception->getCode());
        } catch (\Exception $unhandledException) {
            return $this->json(['detail' => 'Internal server error'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
