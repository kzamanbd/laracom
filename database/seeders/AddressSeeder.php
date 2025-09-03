<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $customers->each(function (Customer $c) {
            $billing = Address::factory()->create([
                'addressable_type' => Customer::class,
                'addressable_id' => $c->id,
                'type' => 'billing',
                'is_default' => true,
            ]);
            $shipping = Address::factory()->create([
                'addressable_type' => Customer::class,
                'addressable_id' => $c->id,
                'type' => 'shipping',
                'is_default' => true,
            ]);
            $c->default_billing_address_id = $billing->id;
            $c->default_shipping_address_id = $shipping->id;
            $c->save();
        });
    }
}
