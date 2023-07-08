<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'category_id',
        'period_id',
        'body',
        ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function period()
    {
        return $this->belongsTo(Period::class);
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    
    public function postImages()
    {
        return $this->hasMany(PostImage::class);
    }
    
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    
    public function getPaginateByLimit(int $limit_count = 10)
    {
        return $this->with('user')->orderBy('updated_at', 'DESC')->paginate($limit_count);
    }
    
    public function isFavorite()
    {
        return $this->favorites()->where('user_id', Auth::id())->exists();
    }
}
