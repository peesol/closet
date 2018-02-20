<?php

namespace Closet\Console\Commands;

use Closet\Models\Product;
use Illuminate\Console\Command;

class IndexProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexing all products';

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
        Product::addAllToIndex();
    }
}
