<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        \DB::table('role_has_permissions')->truncate();
        \DB::table('model_has_roles')->truncate();
        \DB::table('model_has_permissions')->truncate();
        \DB::table('roles')->truncate();
        \DB::table('permissions')->truncate();

        Schema::enableForeignKeyConstraints();

        // Create Role
        $roleSuperAdmin = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        // $roleUser       = Role::create(['name' => 'user', 'guard_name' => 'admin']);

        // Permission List In Array
        $permissions = [
            // dashboard
            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'dashboard',
                ],
            ],
            // User
            [
                'group_name' => 'user',
                'permissions' => [
                    'user.list',
                    'user.create',
                    'user.edit',
                    'user.delete',
                    'user.profile',
                    'user.profile.update',
                ],
            ],
            [
                'group_name' => 'category',
                'permissions' => [
                    'category.list',
                    'category.create',
                    'category.edit',
                    'category.delete',
                    'category.status',
                ],
            ],
            [
                'group_name' => 'sub_category',
                'permissions' => [
                    'sub_category.list',
                    'sub_category.create',
                    'sub_category.edit',
                    'sub_category.delete',
                    'sub_category.status',
                ],
            ],
            [
                'group_name' => 'branch',
                'permissions' => [
                    'branch.list',
                    'branch.create',
                    'branch.edit',
                    'branch.delete',
                    'branch.status',
                ],
            ],
            [
                'group_name' => 'unit',
                'permissions' => [
                    'unit.list',
                    'unit.create',
                    'unit.edit',
                    'unit.delete',
                    'unit.status',
                ],
            ],
            [
                'group_name' => 'brand',
                'permissions' => [
                    'brand.list',
                    'brand.create',
                    'brand.edit',
                    'brand.delete',
                    'brand.status',
                ],
            ],
            [
                'group_name' => 'color',
                'permissions' => [
                    'color.list',
                    'color.create',
                    'color.edit',
                    'color.delete',
                    'color.status',
                ],
            ],
            [
                'group_name' => 'size',
                'permissions' => [
                    'size.list',
                    'size.create',
                    'size.edit',
                    'size.delete',
                    'size.status',
                ],
            ],
            [
                'group_name' => 'product',
                'permissions' => [
                    'product.list',
                    'product.create',
                    'product.edit',
                    'product.delete',
                    'product.status',
                ],
            ],
            [
                'group_name' => 'expense',
                'permissions' => [
                    'expense.list',
                    'expense.create',
                    'expense.edit',
                    'expense.delete',
                    'expense.status',
                ],
            ],
            [
                'group_name' => 'expense-head',
                'permissions' => [
                    'expense-head.list',
                    'expense-head.create',
                    'expense-head.edit',
                    'expense-head.delete',
                    'expense-head.status',
                ],
            ],
            [
                'group_name' => 'fund',
                'permissions' => [
                    'fund.list',
                    'fund.create',
                    'fund.edit',
                    'fund.delete',
                    'fund.status',
                ],
            ],
            [
                'group_name' => 'bank',
                'permissions' => [
                    'bank.list',
                    'bank.create',
                    'bank.edit',
                    'bank.delete',
                    'bank.status',
                ],
            ],
            [
                'group_name' => 'bank-account',
                'permissions' => [
                    'bank-account.list',
                    'bank-account.create',
                    'bank-account.edit',
                    'bank-account.delete',
                    'bank-account.status',
                ],
            ],
            [
                'group_name' => 'bank_branch',
                'permissions' => [
                    'bank_branch.list',
                    'bank_branch.create',
                    'bank_branch.edit',
                    'bank_branch.delete',
                    'bank_branch.status',
                ],
            ],
            [
                'group_name' => 'sale',
                'permissions' => [
                    'sale.list',
                    'sale.create',
                    'sale.delete',
                    'sale.due.payment',
                ],
            ],
            [
                'group_name' => 'product-transfer',
                'permissions' => [
                    'product-transfer.list',
                    'product-transfer.create',
                    'product-transfer.edit',
                    'product-transfer.delete',
                    'product-transfer.status',
                    'transfer-list',
                    'recived-list',
                ],
            ],
            [
                'group_name' => 'customer-information',
                'permissions' => [
                    'customer-information.list',
                    'customer-information.create',
                    'customer-information.edit',
                    'customer-information.delete',
                    'customer-information.status',
                ],
            ],
            [
                'group_name' => 'supplier',
                'permissions' => [
                    'supplier.list',
                    'supplier.create',
                    'supplier.edit',
                    'supplier.delete',
                    'supplier.status',
                ],
            ],
            [
                'group_name' => 'purchase',
                'permissions' => [
                    'purchase.list',
                    'purchase.create',
                    'purchase.edit',
                    'purchase.delete',
                    'purchase.status',
                    'purchase.due.payment',
                ],
            ],
            [
                'group_name' => 'profile',
                'permissions' => [
                    'profile.view',
                    'profile.edit',
                ],
            ],
            // Role
            [
                'group_name' => 'role',
                'permissions' => [
                    'role.list',
                    'role.create',
                    'role.edit',
                    'role.delete',
                    'role.permissions',
                ],
            ],

            // settings
            [
                'group_name' => 'settings',
                'permissions' => [
                    'general.settings',
                    'slider.update',
                ],
            ],

        ];

        // Assign Permission
        foreach ($permissions as $i => $iValue) {
            $permissionGroup = $iValue['group_name'];
            foreach ($iValue['permissions'] as $j => $jValue) {
                $permission = Permission::create([
                    'guard_name' => 'web',
                    'name' => $iValue['permissions'][$j],
                    'group_name' => $permissionGroup,
                ]);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }
        }

        $user = User::find(1);
        $roleSuperAdmin = Role::find(1);
        $user->assignRole($roleSuperAdmin);
    }
}
