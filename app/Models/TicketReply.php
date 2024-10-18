<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    public function ticket(){
    	return $this->belongsTo(Ticket::class);
    }
    public function user(){
    	return $this->belongsTo(User::class);
    }
}
