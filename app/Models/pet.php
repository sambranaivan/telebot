<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pet extends Model
{
    use HasFactory;


    public function sprite()
    {
        return $this->belongsTo('App\Models\sprite');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


    public function sendFront()
    {
        $this->sprite->sendFront($this->user->chat_id);
    }
    public function sendback()
    {

        $this->sprite->sendback($this->user->chat_id);
    }
}
