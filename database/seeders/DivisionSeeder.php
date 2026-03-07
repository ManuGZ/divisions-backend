<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisionTypes = [
            "Division Principal",
            "Division Secundaria",
            "Logisticas",
            "Seguridad",
            "Recursos Humanos",
            "Finanzas",
            "Tecnología",
            "Marketing",
            "Operaciones"
        ];

        // Create 200 independent divisions with random types and collaborators count
        $independentDivisions = Division::factory(200)->create()->each(function ($division) use ($divisionTypes) {
            $division->update([
                'superior_division' => $divisionTypes[array_rand($divisionTypes)], // Ensure 'type' is populated
                'collaborators_count' => rand(1, 50)
            ]);
        });

        // Create 300 subdivisions and distribute them among the independent divisions
        Division::factory(300)->create()->each(function ($subdivision) use ($independentDivisions, $divisionTypes) {
            $subdivision->update([
                'parent_id' => $independentDivisions->random()->id,
                'superior_division' => $divisionTypes[array_rand($divisionTypes)], // Ensure 'type' is populated for subdivisions
                'collaborators_count' => rand(1, 50)
            ]);
        });
    }
}
