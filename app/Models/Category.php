<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasImageTrait;
class Category extends Model
{
    use HasImageTrait;
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
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
