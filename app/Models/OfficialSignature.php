<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialSignature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'designation',
        'tag_key',
        'signature_path',
        'type',
        'status',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get formatted tag string, e.g. {{principal_signature}}
     */
    public function getTagAttribute(): string
    {
        return '{{' . $this->tag_key . '}}';
    }
}
