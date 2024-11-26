<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Subscription;
use App\Models\SubscriptionDuration;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create admins

        // admin 1  has  super_admin role
        $admin1 = Admin::create([
            'name' => 'admin',
            'first_name' => 'admin',
            'last_name' => 'admin',
            'mobile' => null,
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456789'),
            //'token'=>  mt_rand(111111,999999),
            //'token_verified_at' => Carbon::now(),
        ]);

        // admin 2 has admin role
        $admin2 = Admin::create([
            'name' => 'joe_james',
            'first_name' => 'joe',
            'last_name' => 'james',
            'mobile' => null,
            'email' => null,
            'password' => Hash::make('123456789'),

        ]);

        // admin 3 do not have any admin role
        $admin3 = Admin::create([
            'name' => 'sara137',
            'first_name' => 'sara',
            'last_name' => 'redField',
            'mobile' => null,
            'email' => null,
            'password' => Hash::make('123456789'),
        ]);

        $super_admin = Role::create(['guard_name' => 'admin', 'name' => 'super_admin']);
        $role_admin = Role::create(['guard_name' => 'admin', 'name' => 'admin']);
        $admin1->assignRole($super_admin);
        $admin2->assignRole($role_admin);


        $users = [

            [
                'name' => 'naeem_sol',
                'first_name' => 'naeem',
                'last_name' => 'soltany',
                'mobile' => '09917230927',
                'password' => Hash::make('123456789'),
                'email' => 'mason.hows11@gmail.com',
                'email_verified_at' => now(),
            ],

            [
                'name' => 'mason_hows11',
                'first_name' => 'mason',
                'last_name' => 'hows',
                'mobile' => '09179817599',
                'password' => Hash::make('123456789'),
                'email' => 'mason.hows12@gmail.com',
                'email_verified_at' => now(),
            ],

        ];


        foreach ($users as $user) {
            User::create($user);
        }


        // seed subscription once
        // seed subscription duration once


        $unlimited_start = Subscription::create([
            'title' => 'ستاره نامحدود',
            'description' => 'سرویس ستاره نامحدود',
        ]);

        $multi_city = Subscription::create([
            'title' => 'چند شهری نامحدود',
            'description' => 'سرویس شهری نامحدود',
        ]);

        $update_every_ten = Subscription::create([
            'title' => 'بروز رسانی نامحدود ده دقیقه یکبار',
            'description' => 'سرویس بروز رسانی نامحدود ده دقیقه یکبار',
        ]);

        $update_every_one = Subscription::create([
            'title' => 'بروز رسانی نامحدود یک دقیقه یکبار',
            'description' => 'سرویس بروز رسانی نامحدود یک دقیقه یکبار',
        ]);

        DB::table('subscription_durations')->insert([
            [
                'subscription_id' => $unlimited_start->id,
                'price' => 390000,
                'duration' => 'یک ماهه',
                'discount' => null,
            ],
            [
                'subscription_id' => $unlimited_start->id,
                'price' => 490000,
                'duration' => 'سه ماهه',
                'discount' => null,
            ],
            [
                'subscription_id' => $unlimited_start->id,
                'price' => 590000,
                'duration' => 'شیش ماهه',
                'discount' => null,
            ],
            [
                'subscription_id' => $unlimited_start->id,
                'price' => 690000,
                'duration' => 'دوازده ماهه',
                'discount' => null,
            ]
        ]);


        DB::table('subscription_durations')->insert([
            [
                'subscription_id' => $multi_city->id,
                'price' => 390000,
                'duration' => 'یک ماهه',
                'discount' => null,
            ],
            [
                'subscription_id' => $multi_city->id,
                'price' => 490000,
                'duration' => 'سه ماهه',
                'discount' => null,
            ],
            [
                'subscription_id' => $multi_city->id,
                'price' => 590000,
                'duration' => 'شیش ماهه',
                'discount' => null,
            ],
            [
                'subscription_id' => $multi_city->id,
                'price' => 690000,
                'duration' => 'دوازده ماهه',
                'discount' => null,
            ]
        ]);

        DB::table('subscription_durations')->insert([
            [
                'subscription_id' => $update_every_ten->id,
                'price' => 390000,
                'duration' => 'یک ماهه',
                'discount' => null,
            ],
            [
                'subscription_id' => $update_every_ten->id,
                'price' => 490000,
                'duration' => 'سه ماهه',
                'discount' => null,
            ],
            [
                'subscription_id' => $update_every_ten->id,
                'price' => 590000,
                'duration' => 'شیش ماهه',
                'discount' => null,
            ],
            [
                'subscription_id' => $update_every_ten->id,
                'price' => 690000,
                'duration' => 'دوازده ماهه',
                'discount' => null,
            ]
        ]);

        DB::table('subscription_durations')->insert([
            [
                'subscription_id' => $update_every_one->id,
                'price' => 390000,
                'duration' => 'یک ماهه',
                'discount' => null,
            ],
            [
                'subscription_id' => $update_every_one->id,
                'price' => 490000,
                'duration' => 'سه ماهه',
                'discount' => null,
            ],
            [
                'subscription_id' => $update_every_one->id,
                'price' => 590000,
                'duration' => 'شیش ماهه',
                'discount' => null,
            ],
            [
                'subscription_id' => $update_every_one->id,
                'price' => 690000,
                'duration' => 'دوازده ماهه',
                'discount' => null,
            ]
        ]);


    }
}
