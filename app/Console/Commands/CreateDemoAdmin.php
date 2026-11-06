<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateDemoAdmin extends Command
{
    protected $signature = 'demo-admin:create';

    protected $description = 'Create a separate demo administrator account';

    public function handle()
    {
        $email = 'demo@example.com';

        // Do not modify an existing account.
        $existingUser = User::where('email', $email)->first();

        if ($existingUser) {
            if (!$existingUser->isAdmin()) {
                $this->error('Demo email already exists with a non-admin role.');
                return self::FAILURE;
            }

            $this->info('Demo Admin account already exists.');
            return self::SUCCESS;
        }

        $password = env('DEMO_ADMIN_PASSWORD');

        if (!$password) {
            $this->error('DEMO_ADMIN_PASSWORD is not configured.');
            return self::FAILURE;
        }

        User::create([
            'name' => 'Demo Administrator',
            'email' => $email,
            'role' => 'admin',
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $this->info('Demo Admin account created successfully.');

        return self::SUCCESS;
    }
}