<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'body',
        'category_id',
        'added_by',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'added_by'); // Assuming 'added_by' is the foreign key
    }

    // Define the relationship with the Category model
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Define the relationship with the Comment model
    public function comments()
    {
        return $this->hasMany(Comment::class); // Assuming the comments are linked via 'post_id'
    }
}
