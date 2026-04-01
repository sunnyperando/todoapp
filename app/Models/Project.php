<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

        protected static function booted()
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->id();
            }
        });
    }

    // Status constants for easy reference
    const STATUS_PLANNING   = 'planning';
    const STATUS_ACTIVE     = 'active';
    const STATUS_ON_HOLD    = 'on_hold';
    const STATUS_COMPLETED  = 'completed';

    const STATUSES = [
        self::STATUS_PLANNING  => 'Planning',
        self::STATUS_ACTIVE    => 'Active',
        self::STATUS_ON_HOLD   => 'On Hold',
        self::STATUS_COMPLETED => 'Completed',
    ];

    protected $fillable = [
        'name',
        'description',
        'status',
        'due_date',
        'created_by',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    /**
     * The user who manages this project.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * All tasks belonging to this project.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Return a Bootstrap badge class based on project status.
     */
    public function statusBadgeClass(): string
    {
        return match($this->status) {
            self::STATUS_PLANNING  => 'bg-secondary',
            self::STATUS_ACTIVE    => 'bg-success',
            self::STATUS_ON_HOLD   => 'bg-warning text-dark',
            self::STATUS_COMPLETED => 'bg-primary',
            default                => 'bg-light text-dark',
        };
    }
}