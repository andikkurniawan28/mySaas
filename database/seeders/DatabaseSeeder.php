<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use App\Models\Product;
use App\Models\ProfitLoss;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->dummyRole();

        User::insert([
            [
                'name' => 'Andik Kurniawan',
                'email' => 'andikkurniawan789456@gmail.com',
                'password' => bcrypt('qc_789456'),
                'role_id' => 1,
                'is_active' => 1,
                'organization' => 'PT Optima Teknologi Industri',
                'whatsapp' => '6285733465399',
            ],
            [
                'name' => 'Rizky Pratama',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin123'),
                'role_id' => 2,
                'is_active' => 1,
                'organization' => 'PT Optima Teknologi Industri',
                'whatsapp' => '628123456789',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'password' => bcrypt('tenant123'),
                'role_id' => 3,
                'is_active' => 1,
                'organization' => 'CV Demo Sejahtera',
                'whatsapp' => '628987654321',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'password' => bcrypt('tenant456'),
                'role_id' => 3,
                'is_active' => 1,
                'organization' => 'CV Sejahtera Jaya',
                'whatsapp' => '6281122334455',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'password' => bcrypt('tenant789'),
                'role_id' => 3,
                'is_active' => 1,
                'organization' => 'CV Maju Bersama',
                'whatsapp' => '6289988776655',
            ],
        ]);

        $this->dummyProduct();
        $this->dummyProfitLoss();
    }

    public static function dummyRole()
    {
        Role::insert([
            ['name' => 'Director'],
            ['name' => 'Admin'],
            ['name' => 'Tenant'],
            ['name' => 'Prospect'],
        ]);
        $akses = Role::semua_akses();
        $updateData = [];
        foreach ($akses as $a) {
            $updateData[$a['id']] = 1;
        }
        Role::where('id', 1)->update($updateData);
    }

    public static function dummyProfitLoss()
    {
        $startDate = Carbon::create(2025, 1, 1);
        $endDate   = Carbon::now();

        $data = [];

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $revenue = rand(1000000, 5000000); // 1jt - 5jt
            $expense = rand(500000, 4000000);  // 500rb - 4jt
            $profitloss = $revenue - $expense;

            $data[] = [
                'user_id'    => rand(3,5),
                'date'       => $date->format('Y-m-d'),
                'revenue'    => $revenue,
                'expense'    => $expense,
                'profitloss' => $profitloss,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        ProfitLoss::insert($data);
    }

    public static function dummyProduct()
    {
        Product::insert([
            [
                'name' => 'Profit & Loss Dashboard',
                'description' => 'Visualize your company’s financial performance with clear insights into revenue, expenses, and overall profitability.'
            ],
            [
                'name' => 'Multi-Outlet Sales Dashboard',
                'description' => 'Track and compare sales performance across multiple outlets to identify top-performing locations and optimize strategies.'
            ],
            [
                'name' => 'Regional Sales Dashboard',
                'description' => 'Analyze sales distribution by region to understand market trends, customer demand, and regional growth opportunities.'
            ],
            [
                'name' => 'Accounts Payable & Receivable Dashboard',
                'description' => 'Monitor payables and receivables in real-time to manage cash flow efficiently and keep financial records accurate.'
            ],
        ]);

        foreach(Product::all() as $product)
        {
            $columnName = "access_to_product_{$product->id}";
            if (!Schema::hasColumn('users', $columnName)) {
                Schema::table('users', function (Blueprint $table) use ($columnName) {
                    $table->boolean($columnName)->default(false);
                });
            }
        }
    }
}
