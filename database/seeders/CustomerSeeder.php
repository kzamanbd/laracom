<?php

namespace Database\Seeders;

use App\Models\Core\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customerUsers = User::where('role', 'customer')->get();
        if ($customerUsers->isEmpty()) {
            $customerUsers = User::factory()->count(250)->customer()->create();
        }
        Customer::factory()
            ->count($customerUsers->count())
            ->make()
            ->each(function ($customer, $i) use ($customerUsers) {
                $user = $customerUsers[$i];
                $customer->user_id = $user->id;
                $customer->email = $user->email;
                $customer->save();
            });
    }
}
