<?php

namespace Database\Factories;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
    protected $model = Vendor::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'methode' => $this->faker->randomElement(['Pembelian Langsung', 'Public Tender', 'Penunjukan langsung']),
            'state' => $this->faker->randomElement(['Local', 'Impor', 'Internal']),
        ];
    }
}
