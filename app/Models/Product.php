<?php

namespace App\Models;

use App\Traits\WithUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory, WithUuid;
    protected $fillable = ['name', 'quantity', 'purchasing_price', 'selling_price'];
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
    public function readableTags()
    {
        $result = $this->tags->pluck('name')->implode(', ');
        return $result . (strlen($result) > 20 ? ' ...' : '');
    }
}
