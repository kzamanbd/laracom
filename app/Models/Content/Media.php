<?php

namespace App\Models\Content;

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
        if (! $this->path) {
            return 'https://placehold.co/400/png?text=No+Image';
        }

        return Storage::url($this->path);
    }
}
