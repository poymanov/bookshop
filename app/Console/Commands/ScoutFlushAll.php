<?php

namespace App\Console\Commands;

use App\Book;
use App\Author;
use Illuminate\Console\Command;

class ScoutFlushAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:flush-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush all model records from the index';

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
     * @return mixed
     */
    public function handle()
    {
        $classes = $this->getClassesList();

        foreach ($classes as $class) {
            $this->call('scout:flush', ['model' => $class]);
        }
    }

    /**
     * @return array
     */
    private function getClassesList()
    {
        return [
            Book::class,
            Author::class,
        ];
    }
}
