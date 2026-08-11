<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'letter_head_id',
        'subject',
        'content_body',
        'header_image',
        'footer_image',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function letterHead()
    {
        return $this->belongsTo(DropdownOption::class, 'letter_head_id');
    }

    public function generatedInvoices()
    {
        return $this->hasMany(GeneratedInvoice::class);
    }
}
