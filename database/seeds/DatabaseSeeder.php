<?php

use App\Category;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // disabled database check foreign key permanently
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // trunc database tables
        User::truncate();
        Product::truncate();
        Category::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        // set number of factory call
        $userQuantity = 200;
        $categoryQuantity = 30;
        $productQuantity = 1000;
        $transacrionQuantity = 1000;

        // seeding models
        factory(User::class, $userQuantity)->create();
        factory(Category::class, $categoryQuantity)->create();
        factory(Product::class, $productQuantity)->create()->each(
            function ($product) {
                $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');
                $product->categories()->attach($categories);
            });
        factory(Transaction::class, $transacrionQuantity)->create();
    }
}
