<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subcategory;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * Get the child subcategories.
     */
    public function subcategories()
    {
        return $this->hasMany(Subcategories::class, 'id', 'category_id');
    }

    /**
     * Get the grandchild products through subcategories.
     */
    public function products()
    {
        return $this->hasManyThrough(
            Product::class,    //Final model
            Subcategory::class,  //Intermediate Model
            'id', // Foreign key on the Subcategory table...
            'subcategory_id', // Foreign key on the Product table...
            'id', // Local key on the category table...
            'category_id' // Local key on the Subcategory table...
        );
    }
}
