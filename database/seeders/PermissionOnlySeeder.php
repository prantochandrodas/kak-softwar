<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionOnlySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            [
                'group_name' => 'currency',
                'permissions' => [
                    'currency.list',
                    'currency.create',
                    'currency.edit',
                    'currency.status',
                    'currency.delete',

                ],
            ],

            // অন্য group চাইলে এখানেই যোগ করবে
        ];

        foreach ($permissions as $group) {
            foreach ($group['permissions'] as $permissionName) {

                Permission::firstOrCreate(
                    [
                        'name' => $permissionName,
                        'guard_name' => 'web',
                    ],
                    [
                        'group_name' => $group['group_name'],
                    ]
                );
            }
        }
    }
}
