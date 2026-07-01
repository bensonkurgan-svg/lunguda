<?php

namespace Tests\Unit;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonLineageTest extends TestCase
{
    use RefreshDatabase;

    public function test_children_are_linked_through_the_mother(): void
    {
        $mother = Person::create(['name' => 'Ladi', 'status' => 'published']);
        $child = Person::create(['name' => 'Talatu', 'mother_id' => $mother->id, 'status' => 'published']);

        $this->assertTrue($mother->childrenByMother->contains($child));
        $this->assertEquals($mother->id, $child->mother->id);
    }
}
