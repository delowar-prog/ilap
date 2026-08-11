<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneratedLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'letter_template_id',
        'letter_head_id',
        'letter_title',
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
        return $this->belongsTo(LetterTemplate::class, 'letter_template_id');
    }

    public function letterHead()
    {
        return $this->belongsTo(DropdownOption::class, 'letter_head_id');
    }

    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
