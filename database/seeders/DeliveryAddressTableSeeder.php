<?php

namespace Database\Seeders;
use App\DeliveryAddress;
use Illuminate\Database\Seeder;

class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryRecords = [
            ['id'=>1, 'user_id'=>1, 'name'=>'Shikhar Thapa', 'address'=>'pokhara', 'city'=>'pokhara', 
            'state'=>'gandaki', 'country'=>'nepal', 'pincode'=>33700, 'mobile'=>'98648888', 'status'=>1],
            ['id'=>2, 'user_id'=>1, 'name'=>'Shikhar Thapa', 'address'=>'pokhara', 'city'=>'pokhara', 
            'state'=>'gandaki', 'country'=>'nepal', 'pincode'=>33700, 'mobile'=>'98648888', 'status'=>1],
        ];
        DeliveryAddress::insert($deliveryRecords);
    }
}
