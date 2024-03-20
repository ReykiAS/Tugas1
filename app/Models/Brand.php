<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
