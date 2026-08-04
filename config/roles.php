<?php

/*
|--------------------------------------------------------------------------
| Roles & Permissions
|--------------------------------------------------------------------------
|
| Single source of truth for the application's permission catalog and the
| default grants for the built-in roles. The RolePermissionSeeder reads this
| file to populate the database, and User::hasPermission() falls back to the
| built-in grants when a role has not been seeded yet (e.g. during tests).
|
*/

return [

    /*
    | Permissions grouped by module. Order in each module is preserved in the
    | permission matrix UI. Keys are the permission names referenced by the
    | route middleware, values are the human-readable labels.
    */
    'permissions' => [
        'Membership' => [
            'members.view' => 'View members',
            'members.create' => 'Add members',
            'members.edit' => 'Edit members',
            'members.delete' => 'Delete members',
            'members.export' => 'Export members',
        ],
        'Finance' => [
            'finance.view' => 'View offerings',
            'finance.create' => 'Record offerings',
            'finance.edit' => 'Edit offerings',
            'finance.delete' => 'Delete offerings',
            'finance.export' => 'Export offerings',
            'finance.funds' => 'Manage funds',
            'finance.bulk' => 'Bulk CSV import',
        ],
        'Transfers' => [
            'transfers.view' => 'View transfers',
            'transfers.create' => 'Create transfers',
            'transfers.edit' => 'Approve / update transfers',
            'transfers.delete' => 'Delete transfers',
        ],
        'Events' => [
            'events.view' => 'View events',
            'events.create' => 'Create events',
            'events.edit' => 'Edit events',
            'events.delete' => 'Delete events',
            'events.attendance' => 'Record attendance',
        ],
        'Reports' => [
            'reports.view' => 'View reports',
        ],
        'Administration' => [
            'users.view' => 'View users',
            'users.create' => 'Create users',
            'users.edit' => 'Edit users',
            'users.delete' => 'Delete users',
            'roles.manage' => 'Manage roles & permissions',
            'audit.view' => 'View audit logs',
            'audit.export' => 'Export audit logs',
            'settings.manage' => 'Manage system settings',
        ],
    ],

    /*
    | Default permission grants for the built-in roles. Custom roles are only
    | granted permissions through the admin UI; they never receive these
    | defaults. Administrator is handled as a super-admin bypass.
    */
    'defaults' => [
        'Administrator' => [],
        'Pastor' => [
            'members.view',
            'members.create',
            'members.edit',
            'members.delete',
            'members.export',
            'transfers.view',
            'transfers.create',
            'transfers.edit',
            'transfers.delete',
            'events.view',
            'events.create',
            'events.edit',
            'events.delete',
            'events.attendance',
            'reports.view',
        ],
        'Finance Clerk' => [
            'finance.view',
            'finance.create',
            'finance.edit',
            'finance.delete',
            'finance.export',
            'finance.funds',
            'finance.bulk',
            'events.view',
        ],
        'Membership Clerk' => [
            'members.view',
            'members.create',
            'members.edit',
            'members.delete',
            'members.export',
            'transfers.view',
            'transfers.create',
            'transfers.edit',
            'transfers.delete',
            'events.view',
        ],
        'Member' => [
            'events.view',
            'events.create',
            'events.edit',
            'events.delete',
            'events.attendance',
        ],
    ],

];
