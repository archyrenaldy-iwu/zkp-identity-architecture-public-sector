<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:assign';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected $description = 'Create a new permission and assign it to roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $permissionName = $this->ask('Masukan nama permission (permission.name):');
        $permissionDescription = $this->ask('Masukan deskripsi permission (permission.description):');
        $permissionParent = $this->ask('Masukan parent permission (permission.parent_id):');
        $roles = Role::all();
        $selectedRoles = [];

        foreach ($roles as $role) {
            if ($this->confirm("Apakah punya akses terhadap role {$role->description}?", false)) {
                $selectedRoles[] = $role;
            }
        }

        DB::transaction(function () use ($permissionName, $permissionDescription, $selectedRoles, $permissionParent) {
            // Create the permission
            $permission = Permission::create([
                'name' => $permissionName,
                'guard_name' => 'web',
                'description' => $permissionDescription,
                'parent_id' => $permissionParent,
            ]);

            // Assign permission to selected roles
            foreach ($selectedRoles as $role) {
                $role->givePermissionTo($permission);
            }
        });

        $this->info('Permission created and assigned to selected roles successfully.');
    }
}
