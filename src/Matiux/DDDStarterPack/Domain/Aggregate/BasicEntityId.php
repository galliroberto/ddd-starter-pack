<?php

namespace DDDStarterPack\Domain\Aggregate;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

abstract class BasicEntityId implements EntityId
{
    const UUID_PATTERN = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/';
    private $id;

    protected function __construct($anId = false)
    {
        $this->verifyInputId($anId);

        if (false === $anId) {

            $this->id = Uuid::uuid4()->toString();

        } else if (null === $anId) {

            $this->id = null;

        } else {

            $this->id = $anId;
        }
    }

    private function verifyInputId($anId)
    {
        if (is_object($anId)) {
            throw new InvalidArgumentException("Entity id input must be scalar type");
        }
    }

    public static function create($anId = false): EntityId
    {
        return new static($anId);
    }

    public static function isValidUuid(string $uuid): bool
    {
        if (preg_match(self::UUID_PATTERN, $uuid) === 1) {

            return true;
        }

        return false;
    }

    public function equals(EntityId $entityId): bool
    {
        return $this->id() === $entityId->id();
    }

    public function id(): ?string
    {
        return $this->id;
    }

    public function isNull(): bool
    {
        return is_null($this->id);
    }

    public function __toString(): string
    {
        if (!$this->id()) {
            return '';
        }

        return $this->id();
    }
}
