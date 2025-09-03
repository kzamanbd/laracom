<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    protected $casts = [
        'variants' => 'array',
        'meta' => 'array',
    ];

    protected $hidden = ['disk', 'path', 'model_type', 'model_id', 'created_at', 'meta', 'variants'];

    protected $appends = ['file_path'];

    /**
     * Get the parent model (product or category).
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }


    public function getFilePathAttribute()
    {
        return Storage::url($this->path);
    }
}
