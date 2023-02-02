<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\admin;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            [
               'firstname'=>'Bikman',
               'lastname'=>'Djuma',
               'email'=>'indexzero900@gmail.com',
               'phone'=>'0787943106',
               'image'=>'user.png',
               'username'=>'admin@gmail.com',
               'password'=> bcrypt('admin123@'),
            ],
        ];
    
        foreach ($admin as $key => $user) {
            admin::create($user);
        }
    }
}
