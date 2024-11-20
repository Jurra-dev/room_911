<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Employee;
use App\Models\Attempt;
use Carbon\Carbon;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $newemp = new Attempt();
        $friendlyVariable = $newemp->getByEmployee('1000005');

        var_dump($friendlyVariable->toArray());
        
        $this->assertTrue(true);
    }
}
