<?php

namespace App\Models;

use App\Traits\WithUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
    use HasFactory, WithUuid;
    protected $fillable = ['name'];

    public function services()
    {
        return $this->morphedByMany(Service::class, 'taggable');
    }
    public function products()
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }

}
