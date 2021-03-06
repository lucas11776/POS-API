<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Image image
 * @property Collection images
 * @property string category_id
 * @property string name
 * @property string url
 * @property float price
 * @property float discount
 * @property integer in_stock
 * @property string barcode
 * @property string description
 * @property ServicesCategory category
 */
class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'name', 'url', 'price', 'discount', 'in_stock', 'barcode', 'description'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'category', 'image', 'images'
    ];

    use SoftDeletes;

    /**
     * Get product category.
     *
     * @return HasOne
     */
    public function category(): HasOne
    {
        return $this->hasOne(ProductsCategory::class, 'id', 'category_id');
    }

    /**
     * Get product image
     *
     * @return MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Get product images preview.
     *
     * @return MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
