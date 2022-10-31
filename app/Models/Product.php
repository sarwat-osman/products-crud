<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Subcategory;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'subcategory_id',
        'price',
        'thumbnail',
    ];

    /**
     * Get the parent subcategory.
     */
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');
    }

    /**
     * Get the grandfather category through subcategories.
     */
    public function category()
    {
        return $this->hasOneThrough(
            Category::class,    //Final model
            Subcategory::class,  //Intermediate Model
            'category_id', // Foreign key on the Subcategory table...
            'id', // Foreign key on the Category table...
            'subcategory_id', // Local key on the product table...
            'id' // Local key on the Subcategory table...
        );
    }
}
