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

        // Crea 200 divisiones independientes y asigna un tipo aleatorio a cada una
        $independentDivisions = Division::factory(200)->create()->each(function ($division) use ($divisionTypes) {
            $division->update([
                'superior_division' => $divisionTypes[array_rand($divisionTypes)], // Ensure 'type' is populated
                'collaborators_count' => rand(1, 50)
            ]);
        });

        // Crea 300 subdivisiones y distribuye las entre las divisiones independientes
        Division::factory(300)->create()->each(function ($subdivision) use ($independentDivisions, $divisionTypes) {
            $subdivision->update([
                'parent_id' => $independentDivisions->random()->id,
                'superior_division' => $divisionTypes[array_rand($divisionTypes)], // Ensure 'type' is populated for subdivisions
                'collaborators_count' => rand(1, 50)
            ]);
        });
    }
}
