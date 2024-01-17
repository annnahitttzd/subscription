<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

    class Email extends Model
    {
        use HasFactory;
     protected $fillable =[
         'id',
         'subscriber_id',
         'post_id',
         'sent_status'
     ];
     public function post()
     {
         return $this->belongsTo(Post::class, 'id', 'post_id');
     }
        public function subscriber()
        {
            return $this->belongsTo(Subscriber::class, 'subscriber_id');
        }
    }
