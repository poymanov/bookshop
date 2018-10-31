<?php

namespace App\Console\Commands;

use App\Book;
use App\Author;
use Illuminate\Console\Command;

class ScoutImportAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:import-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all models into the search index';

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
            $this->call('scout:import', ['model' => $class]);
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
