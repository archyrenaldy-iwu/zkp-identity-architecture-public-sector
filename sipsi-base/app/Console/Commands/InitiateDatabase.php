<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InitiateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deploy';

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

    protected $description = 'Initiate App';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // // Run migrations
        // $this->info('Running migrations...');
        // Artisan::call('migrate:fresh', [
        //     '--force' => true,
        // ]);
        // $this->info('Migrations completed!');

        // // Run seeders
        // $this->info('Running seeders...');
        // Artisan::call('db:seed', [
        //     '--force' => true,
        // ]);
        // $this->info('Seeders completed!');

        // $this->info('Update permission...');
        // Artisan::call('permission:update');
        // $this->info('Permission completed!');

        // return Command::SUCCESS;
    }
}
