<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\PurchaseTransaction;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory(20)->has(PurchaseTransaction::factory(3))->create();
    }
}
