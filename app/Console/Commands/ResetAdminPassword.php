<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:reset-password';

    protected $description = 'Reset administrator password';

    public function handle()
    {
        $email = 'admin@example.com';

        $user = User::where('email', $email)
            ->where('role', 'admin')
            ->first();

        if (!$user) {
            $this->error('Admin account not found.');
            return self::FAILURE;
        }

        $password = env('ADMIN_PASSWORD');

        if (!$password) {
            $this->error('ADMIN_PASSWORD is not configured.');
            return self::FAILURE;
        }

        $user->password = Hash::make($password);
        $user->save();

        $this->info('Admin password updated successfully.');

        return self::SUCCESS;
    }
}