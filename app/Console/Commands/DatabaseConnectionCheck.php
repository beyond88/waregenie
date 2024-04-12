<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DatabaseConnectionCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:check {--name=default : The name of the database connection}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the connection to the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $connectionName = $this->option('name');

        try {
            $connection = DB::connection($connectionName);
            $databaseName = $connection->getDatabaseName();
            $this->info("Successfully connected to database: $databaseName");
            return 0; // Exit code 0 indicates success
        } catch (Exception $e) {
            $this->error("Failed to connect to database: " . $e->getMessage());
            return 1; // Exit code 1 indicates failure
        }
    }
}
