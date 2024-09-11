<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'no',
        'product_type',
        'parent_id',
        'shop_id',
        'description',
        'price',
        'cost_price',
        'discount',
        'currency',
        'visible',
        'alcohol_pct',
        'created_at',
        'updated_at'
    ];


    public function ratings() : HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function getAverageRating()
    {
        return $this->ratings()->avg('rating');
    }


    // public function findChildren()
    // {
    //     if (is_null($this->parent_id)) {
    //         throw new Exception('parent_id is null. No children to find.');
    //     } else {
    //         self::where('parent_id', $this->parent_id)->get();
    //     }
    // }

}
