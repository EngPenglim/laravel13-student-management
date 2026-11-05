<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'student_id';

    protected $fillable = [
        'student_name',
        'email',
        'gender',
        'dob',
        'enrollment',
        'enrollment_date',
        'description',
        'department_id',
    ];

    protected function casts(): array
    {
        return [
            'enrollment_date' => 'date',
            'dob' => 'date',
        ];
    }

    /**
     * Relationship: A Student belongs to a Department.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'dept_id');
    }

    /**
     * Alias for dept_id to ensure compatibility with both column naming styles.
     */
    protected function deptId(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->department_id,
            set: fn ($value) => ['department_id' => $value],
        );
    }

    /**
     * Calculate years enrolled based on enrollment_date or custom enrollment value.
     */
    public function getYearsEnrolledAttribute(): string
    {
        if (!empty($this->enrollment)) {
            return $this->enrollment;
        }

        if ($this->enrollment_date) {
            $days = Carbon::parse($this->enrollment_date)->diffInDays(now());
            $years = $days / 365.25;
            return number_format($years, 2) . ' years';
        }

        return '0 years';
    }
}
