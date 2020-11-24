<?php

namespace App\Models;

use App\Clients\BestBuy;
use App\Clients\ClientException;
use App\Events\NowInStock;
use App\UseCases\TrackStock;
use Facades\App\Clients\ClientFactory;
use App\Clients\Target;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Stock extends Model
{
    protected $table = 'stock';
    protected $casts = [
        'in_stock' => 'boolean'
    ];

    public function track()
    {
        dispatch(new TrackStock($this));
    }


    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
