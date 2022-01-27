<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\Gender;
use App\Enums\FriendlinessLevel;
use App\Models\Kangaroo;

class KangarooListingTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    
    public function testListKangaroos()
    {
        factory(Kangaroo::class, 20)->create();

        $this->json('GET', '/api/kangaroos', [])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'name',
                        'birthday',
                        'weight',
                        'height',
                        'friendliness',
                    ],
                ], 
                'links' => [], 
                'meta' => [], 
            ]);
    }

    public function testFilterName()
    {
        $kangaroo = factory(Kangaroo::class, 20)->create()->random();

        $term = substr($kangaroo->name, 0, 8);

        $this->json('GET', "/api/kangaroos?filter[name]={$term}", [])
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $kangaroo->id]);
    }

    public function testShowKangaroo()
    {
        $kangaroo = factory(Kangaroo::class, 20)->create()->random();
        
        $this->json('GET', "/api/kangaroos/{$kangaroo->id}", [])
            ->assertStatus(200)
            ->assertJson([
                'data' => ['id' => $kangaroo->id], 
            ]);
    }
}
