<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $roles = [
                'guest' => [
                    'name' => 'Guest',
                    'description' => 'Default public visitor role.',
                    'is_system' => true,
                    'sort_order' => 0,
                ],
                'customer' => [
                    'name' => 'Customer',
                    'description' => 'Registered customer role.',
                    'is_system' => true,
                    'sort_order' => 10,
                ],
                'staff' => [
                    'name' => 'Staff',
                    'description' => 'Internal staff role with dynamic permissions.',
                    'is_system' => true,
                    'sort_order' => 20,
                ],
                'admin' => [
                    'name' => 'Admin',
                    'description' => 'System administrator role.',
                    'is_system' => true,
                    'sort_order' => 30,
                ],
            ];

            $roleModels = [];
            foreach ($roles as $code => $attributes) {
                $roleModels[$code] = Role::query()->withTrashed()->updateOrCreate(
                    ['code' => $code],
                    array_merge($attributes, ['code' => $code])
                );
                if ($roleModels[$code]->trashed()) {
                    $roleModels[$code]->restore();
                }
            }

            $permissions = [
                ['code' => 'product.view', 'name' => 'View products', 'module' => 'product'],
                ['code' => 'product.create', 'name' => 'Create products', 'module' => 'product'],
                ['code' => 'product.update', 'name' => 'Update products', 'module' => 'product'],
                ['code' => 'product.delete', 'name' => 'Delete products', 'module' => 'product'],
                ['code' => 'product.manage_image', 'name' => 'Manage product images', 'module' => 'product'],
                ['code' => 'product.update_stock', 'name' => 'Update product stock', 'module' => 'product'],

                ['code' => 'category.view', 'name' => 'View categories', 'module' => 'category'],
                ['code' => 'category.create', 'name' => 'Create categories', 'module' => 'category'],
                ['code' => 'category.update', 'name' => 'Update categories', 'module' => 'category'],
                ['code' => 'category.delete', 'name' => 'Delete categories', 'module' => 'category'],

                ['code' => 'cart.view', 'name' => 'View carts', 'module' => 'cart'],
                ['code' => 'cart.add', 'name' => 'Add items to cart', 'module' => 'cart'],
                ['code' => 'cart.update', 'name' => 'Update cart items', 'module' => 'cart'],
                ['code' => 'cart.clear', 'name' => 'Clear cart', 'module' => 'cart'],

                ['code' => 'order.view', 'name' => 'View orders', 'module' => 'order'],
                ['code' => 'order.detail', 'name' => 'View order detail', 'module' => 'order'],
                ['code' => 'order.own_view', 'name' => 'View own orders', 'module' => 'order'],
                ['code' => 'order.own_detail', 'name' => 'View own order detail', 'module' => 'order'],
                ['code' => 'order.create', 'name' => 'Create orders', 'module' => 'order'],
                ['code' => 'order.update_status', 'name' => 'Update order status', 'module' => 'order'],
                ['code' => 'order.cancel', 'name' => 'Cancel orders', 'module' => 'order'],
                ['code' => 'customer.view', 'name' => 'View customers', 'module' => 'customer'],
                ['code' => 'customer.detail', 'name' => 'View customer detail', 'module' => 'customer'],
                ['code' => 'customer.lock', 'name' => 'Lock customer accounts', 'module' => 'customer'],

                ['code' => 'profile.update', 'name' => 'Update profile', 'module' => 'profile'],

                ['code' => 'user.view', 'name' => 'View users', 'module' => 'user'],
                ['code' => 'user.create', 'name' => 'Create users', 'module' => 'user'],
                ['code' => 'user.update', 'name' => 'Update users', 'module' => 'user'],
                ['code' => 'user.lock', 'name' => 'Lock users', 'module' => 'user'],

                ['code' => 'role.view', 'name' => 'View roles', 'module' => 'role'],
                ['code' => 'role.create', 'name' => 'Create roles', 'module' => 'role'],
                ['code' => 'role.update', 'name' => 'Update roles', 'module' => 'role'],
                ['code' => 'role.delete', 'name' => 'Delete roles', 'module' => 'role'],

                ['code' => 'permission.view', 'name' => 'View permissions', 'module' => 'permission'],
                ['code' => 'permission.assign', 'name' => 'Assign permissions', 'module' => 'permission'],

                ['code' => 'design_request.create', 'name' => 'Create design requests', 'module' => 'design_request'],
                ['code' => 'design_request.view', 'name' => 'View design requests', 'module' => 'design_request'],
                ['code' => 'design_request.detail', 'name' => 'View design request detail', 'module' => 'design_request'],
                ['code' => 'design_request.own_view', 'name' => 'View own design requests', 'module' => 'design_request'],
                ['code' => 'design_request.own_detail', 'name' => 'View own design request detail', 'module' => 'design_request'],
                ['code' => 'design_request.update_status', 'name' => 'Update design request status', 'module' => 'design_request'],
                ['code' => 'design_request.export', 'name' => 'Export design reports', 'module' => 'design_request'],

                ['code' => 'report.view', 'name' => 'View reports', 'module' => 'report'],
                ['code' => 'report.export', 'name' => 'Export reports', 'module' => 'report'],

                ['code' => 'activity_log.view', 'name' => 'View activity logs', 'module' => 'activity_log'],
            ];

            $permissionModels = [];
            foreach ($permissions as $permission) {
                $permissionModels[$permission['code']] = Permission::query()->withTrashed()->updateOrCreate(
                    ['code' => $permission['code']],
                    $permission
                );
                if ($permissionModels[$permission['code']]->trashed()) {
                    $permissionModels[$permission['code']]->restore();
                }
            }

            $adminRole = $roleModels['admin'];
            $customerRole = $roleModels['customer'];

            $adminRole->permissions()->sync(array_map(
                fn (Permission $permission) => $permission->id,
                $permissionModels
            ));

            $customerRole->permissions()->sync([
                $permissionModels['cart.view']->id,
                $permissionModels['cart.add']->id,
                $permissionModels['cart.update']->id,
                $permissionModels['cart.clear']->id,
                $permissionModels['order.create']->id,
                $permissionModels['order.own_view']->id,
                $permissionModels['order.own_detail']->id,
                $permissionModels['order.cancel']->id,
                $permissionModels['design_request.create']->id,
                $permissionModels['design_request.own_view']->id,
                $permissionModels['design_request.own_detail']->id,
                $permissionModels['profile.update']->id,
            ]);
        });
    }
}
