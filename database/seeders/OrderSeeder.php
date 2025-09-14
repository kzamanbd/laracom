<?php

namespace Database\Seeders;

use App\Models\Catalog\Product;
use App\Models\Core\Address;
use App\Models\Core\Customer;
use App\Models\Orders\Order;
use App\Models\Orders\OrderItem;
use App\Models\Payment\PaymentTransaction;
use App\Models\Shipping\Shipping;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $allProducts = Product::all();
        Order::factory()->count(600)->make()->each(function (Order $o) use ($customers, $allProducts) {
            $customer = $customers->random();
            $o->customer_id = $customer->id;
            $o->user_id = $customer->user_id;
            $o->subtotal = 0;
            $o->discount_total = 0;
            $o->tax_total = 0;
            $o->shipping_total = fake()->randomFloat(2, 0, 25);
            $o->save();
            $billing = Address::factory()->create([
                'addressable_type' => Order::class,
                'addressable_id' => $o->id,
                'type' => 'billing',
                'name' => $customer->first_name.' '.$customer->last_name,
            ]);
            $shipping = Address::factory()->create([
                'addressable_type' => Order::class,
                'addressable_id' => $o->id,
                'type' => 'shipping',
                'name' => $customer->first_name.' '.$customer->last_name,
            ]);
            $o->billing_address_id = $billing->id;
            $o->shipping_address_id = $shipping->id;
            $o->save();
            $itemsCount = fake()->numberBetween(1, 5);
            $items = collect();
            $subtotal = 0;
            $taxTotal = 0;
            for ($i = 0; $i < $itemsCount; $i++) {
                $product = $allProducts->random();
                $qty = fake()->numberBetween(1, 3);
                $unit = (float) $product->price;
                $lineSubtotal = $unit * $qty;
                $rate = (float) optional($product->tax)->rate ?? 0.0;
                $lineTax = round($lineSubtotal * $rate, 2);
                $item = OrderItem::factory()->create([
                    'order_id' => $o->id,
                    'product_id' => $product->id,
                    'sku' => $product->sku,
                    'name' => $product->name,
                    'quantity' => $qty,
                    'unit_price' => $unit,
                    'discount_total' => 0,
                    'tax_total' => $lineTax,
                    'total' => $lineSubtotal + $lineTax,
                    'meta' => ['currency' => $o->currency],
                ]);
                $items->push($item);
                $subtotal += $lineSubtotal;
                $taxTotal += $lineTax;
            }
            $o->subtotal = round($subtotal, 2);
            $o->tax_total = round($taxTotal, 2);
            $o->total = round($o->subtotal - $o->discount_total + $o->tax_total + $o->shipping_total, 2);
            if (in_array($o->status, ['paid', 'processing', 'completed'])) {
                $o->payment_status = 'paid';
            }
            $o->save();
            if ($o->payment_status === 'paid') {
                PaymentTransaction::factory()->create([
                    'order_id' => $o->id,
                    'amount' => $o->total,
                    'currency' => $o->currency,
                    'status' => 'succeeded',
                    'processed_at' => $o->placed_at,
                ]);
            }
            if (fake()->boolean(75)) {
                $ship = Shipping::factory()->create([
                    'order_id' => $o->id,
                    'status' => fake()->randomElement(['label_printed', 'shipped', 'in_transit', 'delivered']),
                ]);
                if ($ship->status === 'delivered') {
                    $ship->delivered_at = fake()->dateTimeBetween($o->placed_at, 'now');
                    $ship->save();
                }
            }
        });
    }
}
