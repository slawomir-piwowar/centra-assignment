<?php
declare(strict_types=1);

namespace Tests\Unit\Domain;

use InvalidArgumentException;
use KanbanBoard\Domain\Progress;
use PHPUnit\Framework\TestCase;

class ProgressTest extends TestCase
{
    public function invalidValuesProvider(): array
    {
        return [
            'both values negative' => [-1, -1],
            'completed negative' => [-1, 0],
            'remaining negative' => [0, -1],
        ];
    }

    /**
     * @dataProvider invalidValuesProvider
     */
    public function testItThrowsAnExceptionWhenInvalidValuesAreUsed(int $completed, int $remaining): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Progress($completed, $remaining);
    }

    public function validValuesProvider(): array
    {
        return [
            '#1' => [50, 50, 50],
            '#2' => [17, 10, 50],
            '#3' => [0, 0, 50],
            '#4' => [100, 50, 0],
            '#5' => [0, 0, 0],
        ];
    }

    /**
     * @dataProvider validValuesProvider
     */
    public function testPercentageIsCalculatingCorrectly(int $expectedResult, int $completed, int $remaining): void
    {
        $progress = new Progress($completed, $remaining);

        $this->assertEquals($expectedResult, $progress->getPercent());
    }
}
