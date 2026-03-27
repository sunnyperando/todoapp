<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusUpdate extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'user_id', 'content'];

    /**
     * The task this update belongs to.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * The user who posted this update.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}