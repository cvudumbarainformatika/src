<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'laporan' => 'array',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'kodecabang', 'kodecabang');
    }
}
