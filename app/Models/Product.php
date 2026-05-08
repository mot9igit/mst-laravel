<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'article',
        'title',
        'longtitle',
        'price',
        'category_id',
        'vendor_id',
        'slug',
        'description',
        'image',
        'thumbnail',
        'content',
        'published',
        'seo_title',
        'seo_description',
        'barcode',
        'bitrix_id',
        'source_loader',
        'in_stock',
        'weight_net',
        'weight_gross',
        'length',
        'width',
        'height',
        'number_of_seats',
        'volume',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
