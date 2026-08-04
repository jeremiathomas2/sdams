<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'Administrator']);
    }

    public function test_roles_page_is_displayed_for_admin(): void
    {
        $response = $this->actingAs($this->admin)->get('/users-roles');

        $response->assertStatus(200);
        $response->assertSee('Roles & Permissions', false);
    }

    public function test_roles_page_is_blocked_for_member(): void
    {
        $member = User::factory()->create(['role' => 'Member']);

        $response = $this->actingAs($member)->get('/users-roles');

        $response->assertStatus(403);
    }

    public function test_admin_can_create_role(): void
    {
        $response = $this->actingAs($this->admin)->post('/users-roles', [
            'name' => 'Youth Leader',
            'description' => 'Leads youth activities',
        ]);

        $response->assertRedirect('/users-roles');
        $this->assertDatabaseHas('roles', ['name' => 'Youth Leader', 'description' => 'Leads youth activities']);
    }

    public function test_duplicate_role_name_is_rejected(): void
    {
        Role::create(['name' => 'Treasurer']);

        $response = $this->actingAs($this->admin)->post('/users-roles', ['name' => 'Treasurer']);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('roles', 1);
    }

    public function test_admin_can_update_role_description(): void
    {
        $role = Role::create(['name' => 'Treasurer', 'description' => 'Old description']);

        $response = $this->actingAs($this->admin)->put("/users-roles/{$role->id}", [
            'name' => 'Treasurer',
            'description' => 'Manages church funds',
        ]);

        $response->assertRedirect('/users-roles');
        $this->assertDatabaseHas('roles', ['id' => $role->id, 'description' => 'Manages church funds']);
    }

    public function test_role_with_users_cannot_be_renamed(): void
    {
        $role = Role::create(['name' => 'Deacon']);
        User::factory()->create(['role' => 'Deacon']);

        $response = $this->actingAs($this->admin)->put("/users-roles/{$role->id}", [
            'name' => 'Deacon Board',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseHas('roles', ['id' => $role->id, 'name' => 'Deacon']);
    }

    public function test_administrator_role_cannot_be_deleted(): void
    {
        $adminRole = Role::create(['name' => 'Administrator']);

        $response = $this->actingAs($this->admin)->delete("/users-roles/{$adminRole->id}");

        $response->assertRedirect('/users-roles');
        $this->assertDatabaseHas('roles', ['id' => $adminRole->id]);
    }

    public function test_empty_custom_role_can_be_deleted(): void
    {
        $role = Role::create(['name' => 'Temp Role']);

        $response = $this->actingAs($this->admin)->delete("/users-roles/{$role->id}");

        $response->assertRedirect('/users-roles');
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }

    public function test_role_with_users_cannot_be_deleted(): void
    {
        $role = Role::create(['name' => 'Deacon']);
        User::factory()->create(['role' => 'Deacon']);

        $response = $this->actingAs($this->admin)->delete("/users-roles/{$role->id}");

        $response->assertRedirect('/users-roles');
        $this->assertDatabaseHas('roles', ['id' => $role->id]);
    }

    public function test_permissions_can_be_granted_and_revoked(): void
    {
        $role = Role::create(['name' => 'Usher']);
        $p1 = Permission::create(['name' => 'members.view', 'label' => 'View members', 'module' => 'Membership']);
        $p2 = Permission::create(['name' => 'members.edit', 'label' => 'Edit members', 'module' => 'Membership']);
        $p3 = Permission::create(['name' => 'finance.view', 'label' => 'View offerings', 'module' => 'Finance']);

        $response = $this->actingAs($this->admin)->put("/users-roles/{$role->id}/permissions", [
            'permissions' => [$p1->id, $p2->id],
        ]);

        $response->assertRedirect('/users-roles');
        $this->assertDatabaseHas('permission_role', ['role_id' => $role->id, 'permission_id' => $p1->id]);
        $this->assertDatabaseHas('permission_role', ['role_id' => $role->id, 'permission_id' => $p2->id]);
        $this->assertDatabaseMissing('permission_role', ['role_id' => $role->id, 'permission_id' => $p3->id]);

        $this->actingAs($this->admin)->put("/users-roles/{$role->id}/permissions", [
            'permissions' => [$p3->id],
        ]);

        $this->assertDatabaseMissing('permission_role', ['role_id' => $role->id, 'permission_id' => $p1->id]);
        $this->assertDatabaseHas('permission_role', ['role_id' => $role->id, 'permission_id' => $p3->id]);
    }

    public function test_custom_role_user_gains_access_to_granted_route(): void
    {
        $role = Role::create(['name' => 'Fleet Manager']);
        $perm = Permission::create(['name' => 'finance.view', 'label' => 'View offerings', 'module' => 'Finance']);
        $role->permissions()->attach($perm->id);

        $user = User::factory()->create(['role' => 'Fleet Manager']);

        $response = $this->actingAs($user)->get('/offerings');

        $response->assertStatus(200);
    }

    public function test_custom_role_user_is_blocked_from_route_without_permission(): void
    {
        Role::create(['name' => 'Fleet Manager']);

        $user = User::factory()->create(['role' => 'Fleet Manager']);

        $response = $this->actingAs($user)->get('/offerings');

        $response->assertStatus(403);
    }
}
