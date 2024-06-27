<?php

namespace App\Models;

use App\Traits\WithUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model {
    use HasFactory, WithUuid;
    protected $fillable = [
        'status',
        'success_rows',
        'failed_rows',
        'time_elapsed',
        'link_to_failed_rows_file',
        'file',
    ];
}
