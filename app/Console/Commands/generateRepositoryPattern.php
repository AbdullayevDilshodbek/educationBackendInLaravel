<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class generateRepositoryPattern extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:repository-pattern';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Created repository pattern for the {item}';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
