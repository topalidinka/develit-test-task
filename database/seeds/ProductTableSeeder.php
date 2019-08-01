<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $flowers = [
            [
                'title'       => 'Roses',
                'price'       => 10,
                'description' => 'Beautiful roses',
            ],
            [
                'title'       => 'Violets',
                'price'       => 12.50,
                'description' => 'Beautiful violets',
            ],
            [
                'title'       => 'Daisies',
                'price'       => 9.75,
                'description' => 'Beautiful daisies',
            ],
        ];
       
        foreach ($flowers as $flower) {
            $product = new Product();
            $product->fill($flower);
            $product->save();
        }
    }
}
