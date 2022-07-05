<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Contact;
use App\Models\User;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $user = User::factory()->count(5)->create();

        $user->each(function ($user) {
            $companies = $user->companies()->saveMany(
                    Company::factory()->count(rand(2, 5))->make()
            );

            $companies->each(function ($company) use($user) {
                $company->contacts()->saveMany(
                        Contact::factory()->count(rand(5, 10))
                        ->make()
                        ->map(function ($contact) use($user){
                            $contact->user_id = $user->id;
                            return $contact;
                        })
                );
            });
        });
    }

}
