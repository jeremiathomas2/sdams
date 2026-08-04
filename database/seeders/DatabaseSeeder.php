<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Super Admin
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@church.org',
            'password' => 'admin123',
            'role' => 'Administrator',
        ]);

        // Finance Clerk
        User::factory()->create([
            'name' => 'Finance Clerk',
            'email' => 'finance@church.org',
            'password' => 'finance123',
            'role' => 'Finance Clerk',
        ]);

        // Membership Clerk
        User::factory()->create([
            'name' => 'Membership Clerk',
            'email' => 'clerk@church.org',
            'password' => 'clerk123',
            'role' => 'Membership Clerk',
        ]);

        // Pastor
        User::factory()->create([
            'name' => 'Pastor Sanga',
            'email' => 'pastor@church.org',
            'password' => 'pastor123',
            'role' => 'Pastor',
        ]);

        // Some random users
        User::factory(10)->create(['role' => 'Member']);

        $this->call([
            RolePermissionSeeder::class,
            MemberSeeder::class,
        ]);

        // Link Member-role user accounts to random member records so their
        // membership numbers (Member IDs) appear across the user module.
        $members = \App\Models\Member::orderBy('id')->pluck('id');
        User::where('role', 'Member')->get()
            ->each(function (User $user) use ($members) {
                if ($members->isEmpty()) {
                    return;
                }

                $user->update(['member_id' => $members->shift()]);
            });
    }
}
