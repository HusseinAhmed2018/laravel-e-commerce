<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:install {--clear} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function clear()
    {
        Artisan::call('cache:clear');
        $this->info(Artisan::output());

        Artisan::call('config:clear');
        $this->info(Artisan::output());

        Artisan::call('view:clear');
        $this->info(Artisan::output());

        Artisan::call('optimize:clear');
        $this->info(Artisan::output());

        //composer dump
        shell_exec('composer dump');
    }


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (!app()->environment('production') or $this->option('force') ) {
            if ($this->option('clear')) {
                $this->clear();
            }

            // drop tables and migrate
            Artisan::call('migrate:refresh', ['--force' => true]);
            $this->info(Artisan::output());

            // seed data
            Artisan::call('db:seed', ['--force' => true, '--no-interaction' => true]);
            $this->info(Artisan::output());
        }
        else
        {
            $this->error("Can't run in production . add --force");
        }
    }
}

