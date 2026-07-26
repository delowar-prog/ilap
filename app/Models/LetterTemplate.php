<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LetterTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'subject',
        'content_body',
        'header_image',
        'footer_image',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function generatedLetters()
    {
        return $this->hasMany(GeneratedLetter::class);
    }
}
