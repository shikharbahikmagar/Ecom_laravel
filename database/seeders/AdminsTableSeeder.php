<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminsRecords = [
            ['id'=> 1, 'name'=> 'admin', 'type'=> 'admin', 'mobile'=> 980000000, 'email'=>'admin@admin.com',
            'password'=>'$2y$10$FQ1aN9cchCi4J/UGGST3YucgjqjSqXomC2YmV30okX0Fq7rzArowu', 'image'=>'', 'status'=> 1 ],

            ['id'=> 2, 'name'=> 'Rohan', 'type'=> 'subadmin', 'mobile'=> 980000000, 'email'=>'subadmin1@admin.com',
            'password'=>'$2y$10$FQ1aN9cchCi4J/UGGST3YucgjqjSqXomC2YmV30okX0Fq7rzArowu', 'image'=>'', 'status'=> 1 ],

            ['id'=> 3, 'name'=> 'Sahil', 'type'=> 'subadmin', 'mobile'=> 980000000, 'email'=>'subadmin2@admin.com',
            'password'=>'$2y$10$FQ1aN9cchCi4J/UGGST3YucgjqjSqXomC2YmV30okX0Fq7rzArowu', 'image'=>'', 'status'=> 1 ],

            ['id'=> 4, 'name'=> 'John', 'type'=> 'subadmin', 'mobile'=> 980000000, 'email'=>'subadmin3@admin.com',
            'password'=>'$2y$10$FQ1aN9cchCi4J/UGGST3YucgjqjSqXomC2YmV30okX0Fq7rzArowu', 'image'=>'', 'status'=> 1 ],
        ];

        DB::table('admins')->insert($adminsRecords);
    }
}
