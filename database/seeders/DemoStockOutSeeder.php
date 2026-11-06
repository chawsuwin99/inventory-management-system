<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class DemoStockOutSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $user = User::orderBy('id')->first();

            if (!$user) {
                throw new RuntimeException(
                    'A user account is required.'
                );
            }

            $stockOuts = [
                ['sku' => 'DEMO-OFF-001', 'quantity' => 5],
                ['sku' => 'DEMO-OFF-002', 'quantity' => 10],
                ['sku' => 'DEMO-COM-001', 'quantity' => 2],
                ['sku' => 'DEMO-FUR-001', 'quantity' => 1],
                ['sku' => 'DEMO-ELE-001', 'quantity' => 1],
                ['sku' => 'DEMO-CLE-001', 'quantity' => 3],
            ];

            foreach ($stockOuts as $data) {

                $product = Product::where('sku', $data['sku'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $note = 'Demo stock out - ' . $data['sku'];

                $existing = StockTransaction::where(
                    'product_id',
                    $product->id
                )->where('note', $note)->first();

                if ($existing) {
                    continue;
                }

                if ($product->quantity < $data['quantity']) {
                    throw new RuntimeException(
                        'Insufficient stock for ' . $data['sku']
                    );
                }

                $product->decrement(
                    'quantity',
                    $data['quantity']
                );

                StockTransaction::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'type' => 'out',
                    'quantity' => $data['quantity'],
                    'unit_price' => $product->selling_price,
                    'note' => $note,
                    'transaction_date' => now()->subDays(2),
                ]);
            }
        });

        $this->command->info(
            'Demo Stock OUT transactions created successfully.'
        );
    }
}
