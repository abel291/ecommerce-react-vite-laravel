<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JsonDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $listJsonPath = Storage::allFiles('database');
        foreach ($listJsonPath as $key => $jsonName) {
            $databaseNameTable = Str::remove(['database/', '.json'], $jsonName);

            DB::table($databaseNameTable)->truncate();

            $data = Storage::json($jsonName);

            echo $databaseNameTable . " \n";

            $dataChunk = array_chunk($data, 1000);

            foreach ($dataChunk as $key => $chunk) {
                echo ($key + 1) . '-' . $databaseNameTable . " \n";
                DB::table($databaseNameTable)->insert($chunk);
            }
            echo " \n";
        }
    }
}
