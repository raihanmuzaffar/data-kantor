<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Employee extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'division_id',
        'employee_number',
        'full_name',
        'nickname',
        'email',
        'phone',
        'nik',
        'npwp',
        'gender',
        'birth_date',
        'birth_place',
        'position',
        'employment_status',
        'join_date',
        'end_date',
        'salary',
        'address',
        'city',
        'province',
        'emergency_contact_name',
        'emergency_contact_phone',
        'is_active',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'join_date' => 'date',
        'end_date' => 'date',
        'salary' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('ktp')->singleFile();
        $this->addMediaCollection('npwp')->singleFile();
        $this->addMediaCollection('contract')->singleFile();
        $this->addMediaCollection('documents')->useDisk('public');
    }
}
