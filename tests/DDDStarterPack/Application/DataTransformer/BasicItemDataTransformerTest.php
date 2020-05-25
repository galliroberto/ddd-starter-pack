<?php

declare(strict_types=1);

namespace Tests\DDDStarterPack\Application\DataTransformer;

use DDDStarterPack\Application\DataTransformer\BasicItemDataTransformer;
use PHPUnit\Framework\TestCase;
use Tests\Support\Model\Person;
use Tests\Support\Model\PersonId;

class BasicItemDataTransformerTest extends TestCase
{
    /**
     * @test
     */
    public function transform_item(): void
    {
        $dt = new PersonDataTransformer();
        $transformed = $dt->write(Person::crea(PersonId::create(), 'Mat', 34))->read();

        // Psalm gets angry - as it should be
        // $transformed= $dt->write(new \stdClass());

        self::assertArrayHasKey('name', $transformed);
        self::assertArrayHasKey('age', $transformed);
    }
}