<?php
namespace App\Application\Services;

use App\Application\Exceptions\InvalidPayloadException;


class RegisterGatewayCommand
{
    /** @var string */
    private $id;
    /** @var string */
    private $assistantUuid;
    /** @var string */
    private $firmwareVersion;

    /**
     * @throws InvalidPayloadException
     */
    public static function fromPayload(string $rawPayload): self
    {
        $payload = self::validatePayload($rawPayload);

        return new self(
            $payload->data->id,
            $payload->data->assistant_uuid,
            $payload->data->firmware_version
        );
    }

    private function __construct(
        string $gatewayId,
        string $assistantUuid,
        ?string $firmwareVersion
    ) {
        $this->id = $gatewayId;
        $this->assistantUuid = $assistantUuid;
        $this->firmwareVersion = $firmwareVersion;
    }

    /**
     * @throws InvalidPayloadException
     */
    private static function validatePayload(string $rawPayload): \stdClass
    {
        $payload = json_decode($rawPayload);

        if (!$payload) {
            throw new InvalidPayloadException('Empty Payload');
        }

        if (!isset($payload->data)) {
            throw new InvalidPayloadException('Missing data key');
        }

        if (!isset($payload->data->id)) {
            throw new InvalidPayloadException('Missing data - id');
        }

        if (!isset($payload->data->assistant_uuid)) {
            throw new InvalidPayloadException('Missing data - assistant_uuid');
        }

        if (!isset($payload->data->firmware_version)) {
            throw new InvalidPayloadException('Missing data - firmware_version');
        }

        return $payload;
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
}
