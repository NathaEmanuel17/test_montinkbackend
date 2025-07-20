<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 30; $i++) {
            $product = Product::factory()->create();

            for ($v = 1; $v <= rand(1, 3); $v++) {
                $variation = $product->variations()->create([
                    'name' => 'Variação ' . $v,
                ]);

                $variation->stock()->create([
                    'quantity' => rand(1, 100),
                ]);
            }

            for ($j = 1; $j <= 3; $j++) {
                $originalPath = 'products/celular.jpg';
                $newPath = "products/produto_{$i}_{$j}.jpg";

                if (Storage::disk('public')->exists($originalPath)) {
                    Storage::disk('public')->copy($originalPath, $newPath);

                    $product->images()->create([
                        'path' => $newPath,
                    ]);
                }
            }
        }
    }
}
