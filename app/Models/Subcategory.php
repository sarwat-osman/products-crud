<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Product;

class Subcategory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subcategories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'category_id',
    ];

    /**
     * Get the parent category 
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    } 

    /**
     * Get the child products
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'id', 'subcategory_id');
    }
}
