<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Provider\RepositoriesProvider;

use KanbanBoard\Application\Provider\RepositoriesProvider\RepositoriesProvider;
use PHPUnit\Framework\TestCase;

class RepositoriesProviderTest extends TestCase
{
    /** @return array<array<string>, string> */
    public function repositoriesDataProvider(): array
    {
        return [
            [[], ''],
            [[], '|||||||||||||'],
            [[], '| |||| ||||      | |||'],
            [['test'], 'test'],
            [['test1', 'test2'], 'test1|test2'],
            [['test1'], 'test1|test1|test1|test1|test1|test1|test1|test1|test1|test1'],
            [['test1', 'test2'], 'test1||||test1|test2||||'],
        ];
    }

    /** @dataProvider repositoriesDataProvider */
    public function testProviderIsWorkingCorrectly(array $expectedResult, string $repositories): void
    {
        $provider = new RepositoriesProvider($repositories);

        $this->assertArrayEquals($expectedResult, $provider->provide());
    }

    // @codingStandardsIgnoreLine
    protected function assertArrayEquals(array $expected, array $actual): void
    {
        ksort($expected);
        ksort($actual);

        $this->assertEquals($expected, $actual);
    }
}
