<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'priority',
        'completed',
        'project_id',
    ];

    protected $casts = [
        'priority' => 'integer',
        'completed' => 'boolean',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeByProject($query, $projectId)
    {
        return $query->when(
            $projectId !== null,
            fn ($query) => $query->where('project_id', $projectId),
            fn ($query) => $query->whereNull('project_id')
        );
    }
}
