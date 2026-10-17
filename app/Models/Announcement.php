<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Announcement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'target_type',
        'target_division_id',
        'priority',
        'is_published',
        'published_at',
        'expires_at',
        'created_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Announcement $announcement) {
            if (empty($announcement->slug)) {
                $announcement->slug = Str::slug($announcement->title) . '-' . Str::lower(Str::random(5));
            }

            if ($announcement->is_published && empty($announcement->published_at)) {
                $announcement->published_at = now();
            }

            if (empty($announcement->excerpt) && ! empty($announcement->body)) {
                $announcement->excerpt = Str::limit(strip_tags($announcement->body), 200);
            }
        });
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'target_division_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
