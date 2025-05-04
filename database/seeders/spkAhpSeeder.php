<?php

namespace Database\Seeders;

use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class spkAhpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     // Seed Laptops
    //     $laptops = [
    //         [
    //             'model' => 'VivoBook X412DA',
    //             'brand' => 'ASUS',
    //             'price' => 7500000,
    //             'cpu' => 'Ryzen 5 3500U',
    //             'ram' => '8GB',
    //             'storage' => '512GB SSD',
    //             'battery_life' => '7 hours',
    //             'weight' => 1.5,
    //             'os' => 'Windows 11',
    //         ],
    //         [
    //             'model' => 'IdeaPad Slim 5',
    //             'brand' => 'Lenovo',
    //             'price' => 9000000,
    //             'cpu' => 'Intel i5 1135G7',
    //             'ram' => '8GB',
    //             'storage' => '512GB SSD',
    //             'battery_life' => '10 hours',
    //             'weight' => 1.4,
    //             'os' => 'Windows 11',
    //         ],
    //         [
    //             'model' => 'MacBook Air M1',
    //             'brand' => 'Apple',
    //             'price' => 14500000,
    //             'cpu' => 'Apple M1',
    //             'ram' => '8GB',
    //             'storage' => '256GB SSD',
    //             'battery_life' => '15 hours',
    //             'weight' => 1.29,
    //             'os' => 'macOS',
    //         ],
    //     ];

    //     foreach ($laptops as $data) {
    //         Laptop::create($data);
    //     }

    //     // Seed Criteria
    //     $criteria = [
    //         ['name' => 'Harga', 'description' => 'Biaya pembelian laptop'],
    //         ['name' => 'Performa', 'description' => 'CPU, RAM, penyimpanan'],
    //         ['name' => 'Daya Tahan Baterai', 'description' => 'Lama pemakaian tanpa charge'],
    //         ['name' => 'Portabilitas', 'description' => 'Ukuran dan berat laptop'],
    //         ['name' => 'Ketersediaan OS', 'description' => 'Kompatibilitas sistem operasi'],
    //     ];

    //     foreach ($criteria as $item) {
    //         Criterion::create($item);
    //     }

    //     // Seed Alternatives
    //     $allLaptops = Laptop::all();
    //     foreach ($allLaptops as $laptop) {
    //         Alternative::create([
    //             'name' => $laptop->brand . ' ' . $laptop->model,
    //             'description' => $laptop->cpu . ', ' . $laptop->ram . ', ' . $laptop->storage,
    //             'laptop_id' => $laptop->id,
    //         ]);
    //     }

    //     // Seed Pairwise Comparisons (dummy values for demonstration)
    //     $criteriaList = Criterion::all();
    //     foreach ($criteriaList as $i => $c1) {
    //         foreach ($criteriaList as $j => $c2) {
    //             if ($i < $j) {
    //                 DB::table('criteria_comparisons')->insert([
    //                     'criteria_id_1' => $c1->id,
    //                     'criteria_id_2' => $c2->id,
    //                     'value' => rand(1, 9),
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ]);
    //             }
    //         }
    //     }

    //     $alternatives = Alternative::all();
    //     foreach ($criteriaList as $criterion) {
    //         foreach ($alternatives as $i => $alt1) {
    //             foreach ($alternatives as $j => $alt2) {
    //                 if ($i < $j) {
    //                     DB::table('alternative_comparisons')->insert([
    //                         'criterion_id' => $criterion->id,
    //                         'alt_id_1' => $alt1->id,
    //                         'alt_id_2' => $alt2->id,
    //                         'value' => rand(1, 9),
    //                         'created_at' => now(),
    //                         'updated_at' => now(),
    //                     ]);
    //                 }
    //             }
    //         }
    //     }

    //     // Simple Normalization of Criteria Comparison Matrix (example)
    //     $matrix = [];
    //     $n = count($criteriaList);
    //     foreach ($criteriaList as $i => $c1) {
    //         foreach ($criteriaList as $j => $c2) {
    //             if ($i == $j) {
    //                 $matrix[$i][$j] = 1;
    //             } elseif ($i < $j) {
    //                 $value = DB::table('users')('criteria_comparisons')
    //                     ->where('criteria_id_1', $c1->id)
    //                     ->where('criteria_id_2', $c2->id)
    //                     ->value('value');
    //                 $matrix[$i][$j] = $value;
    //                 $matrix[$j][$i] = 1 / $value;
    //             }
    //         }
    //     }

    //     $columnSums = [];
    //     for ($j = 0; $j < $n; $j++) {
    //         $sum = 0;
    //         for ($i = 0; $i < $n; $i++) {
    //             $sum += $matrix[$i][$j] ?? 0;
    //         }
    //         $columnSums[$j] = $sum;
    //     }

    //     $normalized = [];
    //     $weights = [];
    //     for ($i = 0; $i < $n; $i++) {
    //         $rowSum = 0;
    //         for ($j = 0; $j < $n; $j++) {
    //             $normalized[$i][$j] = ($matrix[$i][$j] ?? 0) / ($columnSums[$j] ?: 1);
    //             $rowSum += $normalized[$i][$j];
    //         }
    //         $weights[$criteriaList[$i]->id] = $rowSum / $n;
    //     }

    //     // Save Weights to Criteria Table
    //     foreach ($weights as $id => $weight) {
    //         DB::table('criteria')
    //             ->where('id', $id)
    //             ->update(['weight' => round($weight, 4)]);
    //     }
    // }
}
