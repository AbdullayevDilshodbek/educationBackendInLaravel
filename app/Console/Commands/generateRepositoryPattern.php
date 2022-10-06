<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateRepositoryPattern extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Created repository pattern for the {name}';

    protected $name = '{name}';
    /**
     * Execute the console command.
     *
     * @return int
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


    public function handle()
    {
        $name = $this->argument('name');
        $interfaceName = $name . 'Interface';
        $interface = fopen("$interfaceName.php", 'w');
        $code = "<?php
            namespace App\Interfaces;

            interface $interfaceName
            {}
        ";
        fwrite($interface, $code);
        fclose($interface);
        return Command::SUCCESS;
    }
}
