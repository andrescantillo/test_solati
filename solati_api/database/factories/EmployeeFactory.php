<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
     /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'document' => fake()->unique()->randomNumber(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'id_companies' => Company::all()->random()->id,
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'birthday' => fake()->date('Y-m-d'),
        ];
    }
}
