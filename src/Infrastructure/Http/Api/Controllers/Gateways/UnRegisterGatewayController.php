<?php
namespace App\Infrastructure\Http\Api\Controllers\Gateways;

use App\Application\Exceptions\GatewayAlreadyExistsException;
use App\Application\Exceptions\InvalidPayloadException;
use App\Application\Services\Gateways\GatewayManagementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class UnRegisterGatewayController extends AbstractController
{
    /** @var GatewayManagementService */
    private $service;

    public function __construct(GatewayManagementService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("gateways/register/{gatewayId}", name="unregister_gateway", methods={"DELETE"})
     */
    public function register(Request $request, string $gatewayId): JsonResponse
    {
        try {
            $this->service->unregisterGateway($gatewayId);

            return $this->json([], JsonResponse::HTTP_OK);

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
