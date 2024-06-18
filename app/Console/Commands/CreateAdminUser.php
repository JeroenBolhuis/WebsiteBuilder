<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUser extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-user {username=Administrator} {email=admin@hetkoppel}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->argument('username');
        $email = $this->argument('email');

        $this->info('Creating user: ' . $username . ' with e-mail: ' . $email);

        $pwd = $this->secret('Password to use for ' . $email);

        try {
            if (User::where(['email' => $email])->exists()) {
                return $this->error('User with that email already exists!');
            }

            $user = User::updateOrCreate([
                'name' => $username,
                'email' => $email,
                'password' => Hash::make($pwd),
            ]);

            // Assign the administrator role to the user
            $user->syncPermissions(Permission::all());  

        } catch (Exception $error) {
            return $this->error("Error creating user: \r\n" . $error);
        }

        $this->info('User creation OK.');
    }
}
