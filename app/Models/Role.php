<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // 👈 add this

class Role extends Model
{
    use HasFactory;

    // ✅ Allow mass assignment
    protected $fillable = [
        'name',
        'description',
    ];

    // ✅ Relationship: Role ↔ Users (many-to-many)
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}