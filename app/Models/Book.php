<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $primaryKey = 'book_id';

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'published_date',
        'status',
        'copies',
        'description',
        'category_id',
    ];

    protected function casts(): array
    {
        return [
            'published_date' => 'date',
            'copies' => 'integer',
        ];
    }

    /**
     * Relationship: A Book belongs to a Category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /**
     * Accessor: Formatted age / years since publication.
     */
    public function getPublishedAgeAttribute(): string
    {
        if ($this->published_date) {
            $years = Carbon::parse($this->published_date)->diffInYears(now());
            return $years . ' years ago';
        }
        return 'N/A';
    }
}
