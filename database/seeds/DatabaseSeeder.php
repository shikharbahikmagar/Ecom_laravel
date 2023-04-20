<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(BannersTableSeeder::class);
        // $this->call(BrandsTableSeeder::class);
        // $this->call(ProductsImagesTableSeeder::class);
        // $this->call(ProductsAttributesTableSeeder::class);
        // $this->call(ProductsTableSeeder::class);
        // $this->call(CategoryTableSeeder::class);
        $this->call(SectionsTableSeeder::class);
        // $this->call(AdminsTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
    }
}
