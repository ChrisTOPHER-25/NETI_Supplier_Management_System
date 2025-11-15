<?php

namespace Database\Seeders;

use App\Models\BomDepartment;
use App\Models\BomMaterialCategory;
use App\Models\SupplierAddress;
use App\Models\SupplierContactNumber;
use App\Models\SupplierContactPerson;
use App\Models\SupplierPersonPosition;
use App\Models\SupplierTag;
use App\Models\Tag;
use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Psy\Readline\Hoa\Console;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->CreateSuperadmin();
        $this->CreateAdmins();
        $this->CreateDepartments();
        $this->CreateMaterialCategories();
        $this->CreateSuppliers();
        $this->CreateSupplierTags();
    }

    private function CreateSuperadmin()
    {
        try {
            User::factory()->create([
                'name' => 'Superadmin',
                'email' => 'superadmin@neti.com',
                'password' => 'asdASD123',
                'user_type' => 'superadmin',
            ]);
        } catch (Exception $ex) {
        }
    }

    private function CreateAdmins()
    {
        try {
            for ($i = 1; $i <= 5; $i++) {
                User::factory()->create([
                    'name' => 'Admin ' . $i,
                    'email' => 'admin' . $i . '@neti.com',
                    'password' => 'asdASD123',
                    'user_type' => 'admin',
                ]);
            }
        } catch (Exception $ex) {
        }
    }

    private function CreateDepartments()
    {
        try {
            $departments = ['IT Department', 'Cafeteria', 'Accounting'];
            foreach ($departments as $department) {
                BomDepartment::factory()->create([
                    'name' => $department,
                ]);
            }
        } catch (Exception $ex) {
        }
    }

    private function CreateMaterialCategories()
    {
        try {
            $categories = [
                'laptops' => 'IT Department',
                'keyboards' => 'IT Department',
                'mouse' => 'IT Department',
                'meat' => 'Cafeteria',
                'vegetables' => 'Cafeteria',
                'beverage' => 'Cafeteria',
            ];
            foreach ($categories as $category => $department) {
                if ($department == 'IT Department') {
                    $unit = 'pcs';
                    $uses_brand = true;
                    $IT_department_id = BomDepartment::where('name', $department)->firstOrFail()->id;
                    $accounting_dept_id = BomDepartment::where('name', 'Accounting')->firstOrFail()->id;
                    BomMaterialCategory::factory()->create([
                        'name' => $category,
                        'department_id' => $IT_department_id,
                        'unit' => $unit,
                        'uses_brand' => $uses_brand,
                    ]);
                    BomMaterialCategory::factory()->create([
                        'name' => $category,
                        'department_id' => $accounting_dept_id,
                        'unit' => $unit,
                        'uses_brand' => $uses_brand,
                    ]);
                    Tag::factory()->create([
                        'name' => $category,
                    ]);
                } else if ($department == 'Cafeteria') {
                    $unit = null;
                    $uses_brand = false;
                    $department_id = BomDepartment::where('name', 'Cafeteria')->firstOrFail()->id;
                    if ($category == 'meat' || $category == 'vegetables') {
                        $unit = 'kg';
                        $uses_brand = false;
                        BomMaterialCategory::factory()->create([
                            'name' => $category,
                            'department_id' => $department_id,
                            'unit' => $unit,
                            'uses_brand' => $uses_brand,
                        ]);
                    } else if ($category == 'beverage') {
                        $unit = 'L';
                        $uses_brand = true;
                        BomMaterialCategory::factory()->create([
                            'name' => $category,
                            'department_id' => $department_id,
                            'unit' => $unit,
                            'uses_brand' => $uses_brand,
                        ]);
                    }
                    Tag::factory()->create([
                        'name' => $category,
                    ]);
                }
            }
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    private function CreateSuppliers()
    {
        try {
            for ($i = 1; $i <= 5; $i++) {
                // Create Supplier
                $supplier = User::factory()->create([
                    'name' => 'Supplier ' . $i,
                    'email' => 'supplier' . $i . '@neti.com',
                    'password' => 'asdASD123',
                    'user_type' => 'user',
                ]);
                // Create Supplier Address
                $address = SupplierAddress::factory()->create([
                    'address' => 'Canlubang, Calamba, Laguna',
                    'user_id' => $supplier->id,
                ]);
                // Create Supplier Contact Person
                $contactPerson1 = SupplierContactPerson::factory()->create([
                    'name' => 'Person 1',
                    'level' => 'primary',
                    'user_id' => $supplier->id,
                ]);
                $contactPerson2 = SupplierContactPerson::factory()->create([
                    'name' => 'Person 2',
                    'level' => 'secondary',
                    'user_id' => $supplier->id,
                ]);
                // Create Supplier Person Position
                $contactPersonPosition1 = SupplierPersonPosition::factory()->create([
                    'position' => 'Position 1',
                    'contact_person_id' => $contactPerson1->id,
                ]);
                $contactPersonPosition2 = SupplierPersonPosition::factory()->create([
                    'position' => 'Position 2',
                    'contact_person_id' => $contactPerson2->id,
                ]);
                // Create Supplier Contact Numbers
                $contactNumber1 = SupplierContactNumber::factory()->create([
                    'contact' => '09210204625',
                    'contact_person_id' => $contactPerson1->id,
                ]);
                $contactNumber2 = SupplierContactNumber::factory()->create([
                    'contact' => '09210204625',
                    'contact_person_id' => $contactPerson2->id,
                ]);
            }
        } catch (Exception $ex) {
        }
    }

    private function CreateSupplierTags()
    {
        try {
            foreach (User::where('user_type', 'user')->get() as $supplier) {
                SupplierTag::factory()->create([
                    'tag_id' => 1,
                    'user_id' => $supplier->id,
                ]);
            }
        } catch (Exception $ex) {
        }
    }
}
