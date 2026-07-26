<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneratedInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'invoice_template_id',
        'invoice_title',
        'file_path',
        'file_type',
        'generated_by',
        'sent_to_student',
        'sent_at',
    ];

    protected $casts = [
        'sent_to_student' => 'boolean',
        'sent_at'         => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function template()
    {
        return $this->belongsTo(InvoiceTemplate::class, 'invoice_template_id');
    }

    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
