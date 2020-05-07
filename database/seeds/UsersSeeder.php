<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 30)->create();
        factory(User::class)->create([
            'name' => 'admin',
            'email' => 'admin@admin.test',
            'password' => '$2y$10$kES//2e8EtXrdKX6Gv1NNe4pqPvCYDs0o5kQeB8hUznLAQb2J74b2', //123qwe
            'admin' => true,
        ]);
    }
}
