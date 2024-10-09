<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'added_by',
        'post_id',
    ];

    // Define the relationship with the User model
    public function post()
    {
        return $this->belongsTo(Post::class); // Assuming 'post_id' is the foreign key
    }

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'added_by'); // Assuming 'added_by' is the foreign key
    }
}
