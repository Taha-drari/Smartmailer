<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailList extends Model
{
    protected $fillable = ['user_id', 'name'];

    public function entries()
    {
        return $this->hasMany(EmailListEntry::class);
    }
}
