<?php

namespace App\Console\Commands;

use App\Models\User;
use Hash;
use Illuminate\Console\Command;

class ChangeUserPassword extends Command
{
    protected $signature = 'user:change-password {email?}';

    protected $description = 'Change the password of a user';

    public function handle(): int
    {
        $email = $this->argument('email');

        if (! $email) {
            $email = $this->ask('Enter the email of the user');
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error('User not found with the provided email.');

            return 1;
        }

        $password = $this->secret('Enter the new password');
        $confirmPassword = $this->secret('Confirm the new password');

        if (! is_string($password)) {
            $this->error('Password not valid.');

            return 1;
        }

        if ($password !== $confirmPassword) {
            $this->error('Passwords do not match.');

            return 1;
        }

        $user->password = Hash::make($password);
        $user->save();

        $this->info('Password changed successfully for user: '.$user->email);

        return 0;
    }
}
