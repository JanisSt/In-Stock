<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class TrackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'track';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Track all product stock';

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

        Product::all()
            ->tap(fn($products)=>$this->output->progressStart($products->count()))
            ->each(function ($product) {
            $product->track();

            $this->output->progressAdvance();
        });
        $this->output->progressFinish();

        $data = Product::leftJoin('stock','stock.product_id', '=','products.id')
            ->get(['name','price', 'url', 'in_stock']);

        $this->table(
            array_map('ucwords',$this->keys()),
            $data
        );
    }

    protected function keys():array{
        return ['Name', 'Price', 'Url', 'In Stock'];

    }
}
