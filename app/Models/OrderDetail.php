<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $fillable = ['order_id','product_id','price','qty','color','size'];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')->select('id','name','category');
    }

    public function colorname()
    {
        return $this->hasOne(Color::class, 'id', 'color')->select('id','name');
    }

    public function sizecode()
    {
        return $this->hasOne(Size::class, 'id', 'size')->select('id','code');
    }
}
