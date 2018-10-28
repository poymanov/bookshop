<?php

namespace App\Console\Commands\Users;

use App\User;
use Hash;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new user with admin permissions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask('Name');
        $email = $this->ask('Email');
        $password = $this->secret('Password');
        $repeatPassword = $this->secret('Repeat password');

        if ($password !== $repeatPassword) {
            $this->error('Entered passwords not equal');

            return 1;
        }

        try {
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->admin = true;
            $user->save();
        } catch (\Illuminate\Database\QueryException $exception) {
            $this->error($exception->getMessage());
            return 1;
        }

        $this->info('Admin user was successful created');

        return 0;
    }
}
