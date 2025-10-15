<?php

namespace Database\Factories;

use App\Models\RekamMedis; 
use App\Models\Pasien; 
use App\Models\PendaftaranLayanan; 
use App\Models\Admin; 
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RekamMedis>
 */
class RekamMedisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_pasien' => Pasien::inRandomOrder()->first()->id ?? 1,
            'id_pendaftaran' => PendaftaranLayanan::inRandomOrder()->first()->id ?? 1, 
            'id_admin' => Admin::inRandomOrder()->first()->id ?? 1, 
            'tgl_rm' => Carbon::now()->subDays(fake()->numberBetween(0, 30)),
            'anamnesa' => fake()->sentence(),
            'diagnosa' => fake()->word(),
            'terapi' => fake()->sentence(),
            'keterangan' => fake()->sentence(),
        ];
    }
}
