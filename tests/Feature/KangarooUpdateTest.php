<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\Gender;
use App\Enums\FriendlinessLevel;
use App\Models\Kangaroo;

class KangarooUpdateTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    
    /**
     * @dataProvider validPayload
     */
    public function testUpdateKangaroo($createData)
    {
        [
            'kangaroo' => $kangaroo, 
            'payload' => $payload
        ] = $createData();

        $this->json('PATCH', "/api/kangaroos/{$kangaroo->id}", $payload)
            ->assertStatus(200);

        $this->assertDatabaseHas('kangaroos', ['id' => $kangaroo->id] + $payload);
    }

    public function validPayload(): array
    {
        $this->setUp();

        return [
            'update_with_the_same_info' => [
                function () {
                    $kangaroo = factory(Kangaroo::class)->create();
                    
                    return [
                        'kangaroo' => $kangaroo, 
                        'payload' => collect($kangaroo->toArray())->except(['id', 'created_at', 'updated_at'])
                            ->toArray(), 
                    ];
                },
            ], 
            'update_single_field' => [
                function () {
                    $kangaroo = factory(Kangaroo::class)->create();
                    
                    return [
                        'kangaroo' => $kangaroo, 
                        'payload' => ['color' => 'red'], 
                    ];
                },
            ], 
        ];
    }
}
