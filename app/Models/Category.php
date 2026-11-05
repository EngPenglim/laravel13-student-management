<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
        'shelf_location',
        'floor_no',
    ];

    /**
     * Relationship: One Category has many Books.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'category_id', 'category_id');
    }
}
