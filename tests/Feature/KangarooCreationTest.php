<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\Gender;
use App\Enums\FriendlinessLevel;
use App\Models\Kangaroo;

class KangarooCreationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @dataProvider validCreatePayloads
     */
    public function testCreateKangarooRecord(\Closure $payload)
    {
        $payload = $payload();

        $this->json('POST', '/api/kangaroos', $payload)
            ->assertStatus(201);

        $this->assertDatabaseHas('kangaroos', $payload);
    }

    public function testDecimalPlaceShouldBeCutOffToTwo()
    {
        $payload = [
            'name' => $this->faker->unique()->name,
            'nickname' => $this->faker->name,
            'weight' => $this->faker->numerify('##.#####'),
            'height' => $this->faker->numerify('##.####'),
            'gender' => collect(Gender::all())->random(),
            'color' => $this->faker->colorName,
            'friendliness' => collect(FriendlinessLevel::all())->random(),
            'birthday' => now()->subYears(3)->format('Y-m-d'),
        ];

        $this->json('POST', '/api/kangaroos', $payload)
            ->assertStatus(201);

        $this->assertDatabaseHas('kangaroos', [
            'weight' => bcdiv((string) $payload['weight'], '1', 2), 
            'height' => bcdiv((string) $payload['height'], '1', 2), 
        ] + $payload);
    }

    /** 
     * @dataProvider invalidCreatePayloads
     */
    public function testCreateInvalidData(\Closure $payload)
    {
        $payload = $payload();

        $this->json('POST', '/api/kangaroos', $payload)
            ->assertStatus(422);
    }

    public function validCreatePayloads(): array
    {
        $this->setUpFaker();

        return [
            'with_all_fields' => [
                function () {
                    return [
                        'name' => $this->faker->unique()->name,
                        'nickname' => $this->faker->name,
                        'weight' => $this->faker->numerify('##.##'),
                        'height' => $this->faker->numerify('##.##'),
                        'gender' => collect(Gender::all())->random(),
                        'color' => $this->faker->colorName,
                        'friendliness' => collect(FriendlinessLevel::all())->random(),
                        'birthday' => now()->subYears(3)->format('Y-m-d'),
                    ];
                },
            ], 
            'partial_fields' => [
                function () {
                    return [
                        'name' => $this->faker->unique()->name,
                        // 'nickname' => $this->faker->name,
                        'weight' => $this->faker->numerify('##.##'),
                        'height' => $this->faker->numerify('##.##'),
                        'gender' => collect(Gender::all())->random(),
                        // 'color' => $this->faker->colorName,
                        // 'friendliness' => collect(FriendlinessLevel::all())->random(),
                        'birthday' => now()->subYears(3)->format('Y-m-d'),
                    ];
                },
            ], 
            'with_null_value_fields' => [
                function () {
                    return [
                        'name' => $this->faker->unique()->name,
                        'nickname' => null,
                        'weight' => $this->faker->numerify('##.##'),
                        'height' => $this->faker->numerify('##.##'),
                        'gender' => collect(Gender::all())->random(),
                        'color' => null,
                        'friendliness' => null,
                        'birthday' => now()->subYears(3)->format('Y-m-d'),
                    ];
                },
            ], 
        ];
    }

    public function invalidCreatePayloads(): array
    {
        $this->setUpFaker();

        return [
            'with_missing_required_field' => [
                function () {
                    return [
                        // 'name' => $this->faker->unique()->name,
                        'nickname' => $this->faker->name,
                        'weight' => $this->faker->numerify('##.##'),
                        'height' => $this->faker->numerify('##.##'),
                        'gender' => collect(Gender::all())->random(),
                        'color' => $this->faker->colorName,
                        'friendliness' => collect(FriendlinessLevel::all())->random(),
                        'birthday' => now()->subYears(3)->format('Y-m-d'),
                    ];
                },
            ], 
            'name_already_exist' => [
                function () {
                    $name = 'existing name';

                    factory(Kangaroo::class)->create(['name' => $name]);

                    return [
                        'name' => $name,
                        'nickname' => $this->faker->name,
                        'weight' => $this->faker->numerify('##.##'),
                        'height' => $this->faker->numerify('##.##'),
                        'gender' => collect(Gender::all())->random(),
                        'color' => $this->faker->colorName,
                        'friendliness' => collect(FriendlinessLevel::all())->random(),
                        'birthday' => now()->subYears(3)->format('Y-m-d'),
                    ];
                },
            ], 
            'negative_height' => [
                function () {
                    return [
                        'name' => $this->faker->unique()->name,
                        'nickname' => $this->faker->name,
                        'weight' => -1.2,
                        'height' => $this->faker->numerify('##.##'),
                        'gender' => collect(Gender::all())->random(),
                        'color' => $this->faker->colorName,
                        'friendliness' => collect(FriendlinessLevel::all())->random(),
                        'birthday' => now()->subYears(3)->format('Y-m-d'),
                    ];
                },
            ], 
            'negative_height' => [
                function () {
                    return [
                        'name' => $this->faker->unique()->name,
                        'nickname' => $this->faker->name,
                        'weight' => $this->faker->numerify('##.##'),
                        'height' => -1.2,
                        'gender' => collect(Gender::all())->random(),
                        'color' => $this->faker->colorName,
                        'friendliness' => collect(FriendlinessLevel::all())->random(),
                        'birthday' => now()->subYears(3)->format('Y-m-d'),
                    ];
                },
            ], 
            'future_birthday' => [
                function () {
                    return [
                        'name' => $this->faker->unique()->name,
                        'nickname' => $this->faker->name,
                        'weight' => $this->faker->numerify('##.##'),
                        'height' => $this->faker->numerify('##.##'),
                        'gender' => collect(Gender::all())->random(),
                        'color' => $this->faker->colorName,
                        'friendliness' => collect(FriendlinessLevel::all())->random(),
                        'birthday' => now()->addDay()->format('Y-m-d'),
                    ];
                },
            ], 
            'invalid_gender' => [
                function () {
                    return [
                        'name' => $this->faker->unique()->name,
                        'nickname' => $this->faker->name,
                        'weight' => $this->faker->numerify('##.##'),
                        'height' => $this->faker->numerify('##.##'),
                        'gender' => 'unrecorded',
                        'color' => $this->faker->colorName,
                        'friendliness' => collect(FriendlinessLevel::all())->random(),
                        'birthday' => now()->format('Y-m-d'),
                    ];
                },
            ], 
            'invalid_friendliness' => [
                function () {
                    return [
                        'name' => $this->faker->unique()->name,
                        'nickname' => $this->faker->name,
                        'weight' => $this->faker->numerify('##.##'),
                        'height' => $this->faker->numerify('##.##'),
                        'gender' => collect(Gender::all())->random(),
                        'color' => $this->faker->colorName,
                        'friendliness' => 'not on choices',
                        'birthday' => now()->format('Y-m-d'),
                    ];
                },
            ], 
            
        ];
    }
}
