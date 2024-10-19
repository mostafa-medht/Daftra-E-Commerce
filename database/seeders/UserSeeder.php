<?php

namespace Database\Seeders;

use App\Enums\ProfileData\GenderEnum;
use App\Enums\ProfileData\ProfileTypeEnum;
use App\Enums\User\UserStatusEnum;
use App\Models\User;
use App\Models\Wallet;
use Database\Factories\AddressFactory;
use Database\Factories\ProfileFactory;
use Database\Factories\UserIdentifierFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
