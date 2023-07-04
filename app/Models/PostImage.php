<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;
    
    protected $table = 'post_images';
    
    protected $fillable = [
        'img_url',
        'post_id',
    ];
    
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
