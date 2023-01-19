<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = new User();
        $user1->name = 'Mr.John';
        $user1->email = 'mrjohn@gmail.com';
        $user1->password = Hash::make('password');
        $user1->save();

        $user2 = new User();
        $user2->name = 'Mrs.Lee';
        $user2->email = 'mrslee@gmail.com';
        $user2->password = Hash::make('password');
        $user2->save();
    }
}
