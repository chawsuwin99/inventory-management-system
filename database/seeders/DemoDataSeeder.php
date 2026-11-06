<?php
namespace Database\Seeders;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            // 1. Categories
            $categories = [
                'Office Supplies' => 'Office and stationery products',
                'Computer Accessories' => 'Computer and IT accessories',
                'Furniture' => 'Office furniture and equipment',
                'Electronics' => 'Electronic devices and equipment',
                'Cleaning Supplies' => 'Cleaning and maintenance products',
            ];

            foreach ($categories as $name => $description) {
                Category::firstOrCreate(
                    ['name' => $name],
                    [
                        'description' => $description,
                        'status' => true,
                    ]
                );
            }

            // 2. Suppliers
            $suppliers = [
                [
                    'name' => 'Global Tech Supplier',
                    'company_name' => 'Global Tech Co., Ltd.',
                    'phone' => '09123456780',
                    'email' => 'globaltech@example.com',
                    'address' => 'Yangon, Myanmar',
                ],
                [
                    'name' => 'Office World',
                    'company_name' => 'Office World Trading',
                    'phone' => '09234567801',
                    'email' => 'officeworld@example.com',
                    'address' => 'Mandalay, Myanmar',
                ],
                [
                    'name' => 'Smart Electronics',
                    'company_name' => 'Smart Electronics Co.',
                    'phone' => '09345678012',
                    'email' => 'smart@example.com',
                    'address' => 'Naypyidaw, Myanmar',
                ],
                [
                    'name' => 'Modern Furniture',
                    'company_name' => 'Modern Furniture Trading',
                    'phone' => '09456780123',
                    'email' => 'furniture@example.com',
                    'address' => 'Taunggyi, Myanmar',
                ],
            ];

            foreach ($suppliers as $supplier) {
                Supplier::firstOrCreate(
                    ['email' => $supplier['email']],
                    $supplier + [
                        'description' => 'Demo supplier',
                        'status' => true,
                    ]
                );
            }

            // 3. Use an existing user for demo transactions.
            // Never create or modify an Admin account.
            $user = User::where('email', 'demo@example.com')->first();

             if (!$user || !$user->isAdmin()) {
                throw new \RuntimeException(
            'Please create the Demo Admin account before seeding demo data.'
           );
           }

            // 4. Products
            $products = [
                [
                    'category' => 'Office Supplies',
                    'name' => 'A4 Copy Paper',
                    'sku' => 'DEMO-OFF-001',
                    'description' => 'A4 size office copy paper',
                    'purchase_price' => 12000,
                    'selling_price' => 15000,
                    'quantity' => 100,
                    'min_stock_level' => 20,
                    'unit' => 'ream',
                ],
                [
                    'category' => 'Office Supplies',
                    'name' => 'Blue Ballpoint Pen',
                    'sku' => 'DEMO-OFF-002',
                    'description' => 'Blue ink ballpoint pen',
                    'purchase_price' => 500,
                    'selling_price' => 800,
                    'quantity' => 200,
                    'min_stock_level' => 30,
                    'unit' => 'pcs',
                ],
                [
                    'category' => 'Office Supplies',
                    'name' => 'Stapler',
                    'sku' => 'DEMO-OFF-003',
                    'description' => 'Standard office stapler',
                    'purchase_price' => 3500,
                    'selling_price' => 5000,
                    'quantity' => 3,
                    'min_stock_level' => 5,
                    'unit' => 'pcs',
                ],
                [
                    'category' => 'Computer Accessories',
                    'name' => 'USB Keyboard',
                    'sku' => 'DEMO-COM-001',
                    'description' => 'USB wired computer keyboard',
                    'purchase_price' => 18000,
                    'selling_price' => 23000,
                    'quantity' => 25,
                    'min_stock_level' => 5,
                    'unit' => 'pcs',
                ],
                [
                    'category' => 'Computer Accessories',
                    'name' => 'Wireless Headset',
                    'sku' => 'DEMO-COM-002',
                    'description' => 'Wireless stereo headset',
                    'purchase_price' => 35000,
                    'selling_price' => 45000,
                    'quantity' => 2,
                    'min_stock_level' => 5,
                    'unit' => 'pcs',
                ],
                [
                    'category' => 'Furniture',
                    'name' => 'Office Chair',
                    'sku' => 'DEMO-FUR-001',
                    'description' => 'Ergonomic office chair',
                    'purchase_price' => 85000,
                    'selling_price' => 110000,
                    'quantity' => 12,
                    'min_stock_level' => 3,
                    'unit' => 'pcs',
                ],
                [
                    'category' => 'Furniture',
                    'name' => 'Office Desk',
                    'sku' => 'DEMO-FUR-002',
                    'description' => 'Modern office desk',
                    'purchase_price' => 150000,
                    'selling_price' => 190000,
                    'quantity' => 8,
                    'min_stock_level' => 2,
                    'unit' => 'pcs',
                ],
                [
                    'category' => 'Electronics',
                    'name' => 'LED Monitor 24 inch',
                    'sku' => 'DEMO-ELE-001',
                    'description' => '24 inch LED computer monitor',
                    'purchase_price' => 220000,
                    'selling_price' => 260000,
                    'quantity' => 15,
                    'min_stock_level' => 4,
                    'unit' => 'pcs',
                ],
                [
                    'category' => 'Electronics',
                    'name' => 'UPS 650VA',
                    'sku' => 'DEMO-ELE-002',
                    'description' => '650VA backup power supply',
                    'purchase_price' => 95000,
                    'selling_price' => 120000,
                    'quantity' => 4,
                    'min_stock_level' => 5,
                    'unit' => 'pcs',
                ],
                [
                    'category' => 'Cleaning Supplies',
                    'name' => 'Floor Cleaner',
                    'sku' => 'DEMO-CLE-001',
                    'description' => 'Multipurpose floor cleaning liquid',
                    'purchase_price' => 4500,
                    'selling_price' => 6000,
                    'quantity' => 40,
                    'min_stock_level' => 10,
                    'unit' => 'bottle',
                ],
            ];

            foreach ($products as $data) {
                $category = Category::where(
                    'name',
                    $data['category']
                )->firstOrFail();

                Product::firstOrCreate(
                    ['sku' => $data['sku']],
                    [
                        'category_id' => $category->id,
                        'name' => $data['name'],
                        'description' => $data['description'],
                        'purchase_price' => $data['purchase_price'],
                        'selling_price' => $data['selling_price'],
                        'quantity' => $data['quantity'],
                        'min_stock_level' => $data['min_stock_level'],
                        'unit' => $data['unit'],
                        'status' => true,
                    ]
                );
            }

            // 5. Create transaction history only for new demo products.
            // These records explain the initial demo stock.
            foreach ($products as $data) {
                $product = Product::where(
                    'sku',
                    $data['sku']
                )->firstOrFail();

                $note = 'Demo initial stock - ' . $data['sku'];

                StockTransaction::firstOrCreate(
                    [
                        'product_id' => $product->id,
                        'note' => $note,
                    ],
                    [
                        'user_id' => $user->id,
                        'type' => 'in',
                        'quantity' => $data['quantity'],
                        'unit_price' => $data['purchase_price'],
                        'transaction_date' => now()->subDays(7),
                    ]
                );
            }
        });

        $this->command->info('Demo sample data seeded successfully.');
    }
}
