<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'website_id',
        'title',
        'description'
    ];
    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }
    public function emails()
    {
        return $this->hasMany(Email::class);
    }
    public function subscriber()
    {
        return $this->belongsToMany(Subscriber::class, 'emails', 'post_id', 'subscriber_id');
    }

}
