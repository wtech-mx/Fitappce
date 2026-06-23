<?php

namespace Tests\Unit;

use App\Http\Controllers\Admin\WorkoutController;
use PHPUnit\Framework\Attributes\Test;
use ReflectionMethod;
use Tests\TestCase;

class WorkoutDurationCalculatorTest extends TestCase
{
    #[Test]
    public function it_calculates_an_individual_exercise_with_average_reps(): void
    {
        $duration = $this->calculate([
            ['exercise_id' => 1, 'block_type' => 'Individual', 'sets' => '4', 'reps' => '10-12', 'rest' => '10 seg'],
        ]);

        $this->assertSame('30 min', $duration);
    }

    #[Test]
    public function it_counts_group_rest_only_once_for_a_biset(): void
    {
        $duration = $this->calculate([
            ['exercise_id' => 1, 'block_type' => 'Biserie', 'block_group' => 'B1', 'sets' => '4', 'reps' => '10-12', 'rest' => '10 seg'],
            ['exercise_id' => 2, 'block_type' => 'Biserie', 'block_group' => 'B1', 'sets' => '4', 'reps' => '10-12', 'rest' => null],
        ]);

        $this->assertSame('1 h 00 min', $duration);
    }

    private function calculate(array $exercises): ?string
    {
        $controller = app(WorkoutController::class);
        $method = new ReflectionMethod($controller, 'estimatedTime');
        $method->setAccessible(true);

        return $method->invoke($controller, $exercises);
    }
}
