<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    // Priority constants
    const PRIORITY_LOW    = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH   = 'high';

    const PRIORITIES = [
        self::PRIORITY_LOW    => 'Low',
        self::PRIORITY_MEDIUM => 'Medium',
        self::PRIORITY_HIGH   => 'High',
    ];

    // Status constants
    const STATUS_TODO        = 'todo';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_REVIEW      = 'review';
    const STATUS_DONE        = 'done';

    const STATUSES = [
        self::STATUS_TODO        => 'To Do',
        self::STATUS_IN_PROGRESS => 'In Progress',
        self::STATUS_REVIEW      => 'Review',
        self::STATUS_DONE        => 'Done',
    ];

    protected $fillable = [
        'project_id',
        'assigned_to',
        'created_by',
        'title',
        'description',
        'priority',
        'status',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    /**
     * The project this task belongs to.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * The user this task is assigned to.
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * The user who created this task.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Progress notes posted on this task (added in Part 6).
     */
    public function statusUpdates()
    {
        return $this->hasMany(\App\Models\StatusUpdate::class);
    }

    /**
     * Return a Bootstrap badge class based on task status.
     */
    public function statusBadgeClass(): string
    {
        return match($this->status) {
            self::STATUS_TODO        => 'bg-secondary',
            self::STATUS_IN_PROGRESS => 'bg-primary',
            self::STATUS_REVIEW      => 'bg-warning text-dark',
            self::STATUS_DONE        => 'bg-success',
            default                  => 'bg-light text-dark',
        };
    }

    /**
     * Return a Bootstrap badge class based on task priority.
     */
    public function priorityBadgeClass(): string
    {
        return match($this->priority) {
            self::PRIORITY_LOW    => 'bg-success',
            self::PRIORITY_MEDIUM => 'bg-warning text-dark',
            self::PRIORITY_HIGH   => 'bg-danger',
            default               => 'bg-secondary',
        };
    }
}