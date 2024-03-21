<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Branch;
use App\Models\CustomerGroup;
use App\Models\ManufacturingGroup;
use App\Models\Permission;
use App\Models\ProductGroup;
use App\Models\ProductType;
use App\Models\ProductUnit;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $branch1 = Branch::create([
            'name'=>'Cửa hàng 001'
        ]);
        $branch2 = Branch::create([
            'name'=>'Cửa hàng 002'
        ]);

        $roleAdmin = Role::create(
          [
            "name" => "administrator",
            "display_name" => "Quản trị viên",
            "default_router" => "/",
            "editable" => 1,
          ]
        );
        $roleManager = Role::create(
          [
            "name" => "manager",
            "display_name" => "Quản lý cửa hàng",
            "default_router" => "/",
            "editable" => 0,
          ]
        );
        $roleWarehouse = Role::create(
          [
            "name" => "warehouse-dept",
            "display_name" => "Bộ phận Kho",
            "default_router" => "/",
            "editable" => 0
          ]
        );

        foreach (Permission::all() as $permission) {
            //            dd($roleAdmin->permissions()->attach($permission));
            $roleAdmin->permissions()->attach($permission);
            //
        }
        foreach (Permission::all() as $permission) {
            $roleManager->permissions()->attach($permission);
        }



        $role = $roleAdmin;
        $users = User::whereHas('roles', function ($q) use ($role) {
            return $q->where('role_id', $role->id);
        })->get();
        if ($users->count() == 0) {
            $users = User::create([
              'name' => "Quản trị viên",
              'email' => "admin@khoplus.com",
              'password' => bcrypt('admin'),
            ]);
            $users->roles()->attach($role);
            $users->branches()->attach($branch1);
            $users->branches()->attach($branch2);
        }
        $customerGroup = CustomerGroup::count();
        if ($customerGroup == 0) {
            CustomerGroup::create([
              'name' => "Thành viên",
              'discount' => 0,
            ]);
            CustomerGroup::create([
              'name' => "Khách hàng thân thiết",
              'discount' => 5,
            ]);
            CustomerGroup::create([
              'name' => "Khách hàng Vàng",
              'discount' => 7,
            ]);
            CustomerGroup::create([
              'name' => "Khách hàng Kim cương",
              'discount' => 7,
            ]);
        }
        $productTypes = ProductType::create(

          [
            'name' => 'Phân bón',
          ]
        );

        $productGroups = ProductGroup::create(

          [
            'name' => 'Phân bón lá',
          ]
        );
        ProductUnit::insert(
          [
            [
              'name' => 'Gói',
            ],
            [
              'name' => 'Thùng',
            ],
            [
              'name' => 'Chai',
            ],
          ]
        );

        ManufacturingGroup::create([
          'name' => 'Nhà Cung cấp tiềm năng',
          'active' => 1,
        ]);
    }
}
