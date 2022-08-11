<?php

namespace Database\Seeders;
use App\Models\User\UserBalance;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User\User::factory()->create([
             'document_number' => '76530044000195',
             'is_company' => true,
         ]);

        UserBalance::create([
            'user_id' => $user->id,
            'value' => 0
        ]);

       $user =  \App\Models\User\User::factory()->create([
            'document_number' => '05594027084',
            'is_company' => false,
        ]);

        UserBalance::create([
            'user_id' => $user->id,
            'value' => 1000.00
        ]);
    }
}
