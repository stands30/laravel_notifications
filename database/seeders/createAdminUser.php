<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class createAdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "Admin",
            "email" => "admin@notif.com",
            "user_role" => "admin",
            "password" => bcrypt("notifAdmin@2024")
        ]);

    }
}
