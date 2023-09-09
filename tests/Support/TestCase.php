<?php

declare(strict_types=1);

namespace Tests\Support;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use WebTheory\UnitUtils\Concerns\AssertionsTrait;
use WebTheory\UnitUtils\Concerns\FakeGeneratorTrait;
use WebTheory\UnitUtils\Concerns\FormattedDataSetsTrait;
use WebTheory\UnitUtils\Concerns\SystemTrait;

abstract class TestCase extends PHPUnitTestCase
{
    use AssertionsTrait;
    use FakeGeneratorTrait;
    use FormattedDataSetsTrait;
    use SystemTrait;

    protected function setUp(): void
    {
        parent::setUp();

        $this->init();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    protected function init(): void
    {
        $this->initFaker();
    }

    protected function getSupportPath(string $path = '')
    {
        return __DIR__ . $path;
    }
}
