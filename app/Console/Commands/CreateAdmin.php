<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create';

    protected $description = 'Create an administrator account';

    public function handle()
    {
        $email = 'admin@example.com';

        if (User::where('email', $email)->exists()) {
            $this->info('Admin account already exists.');
            return self::SUCCESS;
        }

        $password = env('ADMIN_PASSWORD');

        if (!$password) {
            $this->error('ADMIN_PASSWORD is not configured.');
            return self::FAILURE;
        }

        User::create([
            'name' => 'Administrator',
            'email' => $email,
            'role' => 'admin',
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $this->info('Admin account created successfully.');

        return self::SUCCESS;
    }
}