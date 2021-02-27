<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\UrlController;

class UrlCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'url:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Corre as urls cadastradas no banco preenchendo o conteudo status_code e body';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new UrlController)->get_data_from_url();
        return 0;
    }
}
