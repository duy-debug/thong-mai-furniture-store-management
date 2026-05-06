<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $adminRole = Role::query()->where('code', 'admin')->firstOrFail();
            $staffRole = Role::query()->where('code', 'staff')->firstOrFail();
            $customerRole = Role::query()->where('code', 'customer')->firstOrFail();

            $admin = User::query()->withTrashed()->updateOrCreate(
                ['email' => 'admin@thongmai.local'],
                [
                    'name' => 'System Admin',
                    'phone' => '0900000001',
                    'birthday' => null,
                    'gender' => null,
                    'address_line_1' => null,
                    'address_line_2' => null,
                    'ward' => null,
                    'district' => null,
                    'province' => null,
                    'postal_code' => null,
                    'preferred_contact_method' => 'both',
                    'notes' => null,
                    'password' => Hash::make('Password@123'),
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );
            if ($admin->trashed()) {
                $admin->restore();
            }
            $admin->roles()->sync([$adminRole->id]);

            $staff = User::query()->withTrashed()->updateOrCreate(
                ['email' => 'staff@thongmai.local'],
                [
                    'name' => 'System Staff',
                    'phone' => '0900000002',
                    'birthday' => null,
                    'gender' => null,
                    'address_line_1' => null,
                    'address_line_2' => null,
                    'ward' => null,
                    'district' => null,
                    'province' => null,
                    'postal_code' => null,
                    'preferred_contact_method' => 'both',
                    'notes' => null,
                    'password' => Hash::make('Password@123'),
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );
            if ($staff->trashed()) {
                $staff->restore();
            }
            $staff->roles()->sync([$staffRole->id]);

            $customer = User::query()->withTrashed()->updateOrCreate(
                ['email' => 'customer@thongmai.local'],
                [
                    'name' => 'Demo Customer',
                    'phone' => '0900000003',
                    'birthday' => '1995-01-01',
                    'gender' => 'other',
                    'address_line_1' => '115 Nguyen Xien',
                    'address_line_2' => null,
                    'ward' => 'Bac Nha Trang',
                    'district' => 'Nha Trang',
                    'province' => 'Khanh Hoa',
                    'postal_code' => null,
                    'preferred_contact_method' => 'both',
                    'notes' => 'Seeded customer account.',
                    'password' => Hash::make('Password@123'),
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );
            if ($customer->trashed()) {
                $customer->restore();
            }
            $customer->roles()->sync([$customerRole->id]);
        });
    }
}
