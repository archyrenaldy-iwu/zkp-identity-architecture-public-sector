<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Roles;

class UpdatePermissionRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:update';

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

    protected $description = 'Update Permission Role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Roles::updatePermissionRole();

    }
}
