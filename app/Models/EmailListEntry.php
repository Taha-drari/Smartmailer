<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailListEntry extends Model
{
    protected $fillable = ['email_list_id', 'email', 'is_valid'];

    public function emailList()
    {
        return $this->belongsTo(EmailList::class);
    }
}