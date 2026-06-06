<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermisionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerRole = Role::create([
            "name" => "owner"
        ]);
        //جبنا كل القيم في الenum  و ضفناها ع الجدول
        $permissions = PermissionsEnum::cases();
        foreach ($permissions as $permission) {
            Permission::create([
                "name" => $permission->value,
            ]);
        }
        //هون اسندنا كل الصلاحيات لليوزر اللي اسمه owner
        $ownerRole->permissions()->attach(Permission::all());
    }
}
