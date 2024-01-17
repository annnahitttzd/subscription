<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $fillable = [
        'id',
        'name',
        'url',
    ];

    use HasFactory;
    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }
    public function post()
    {
        return $this->hasMany(Post::class, 'website_id', 'id');
    }
}
