<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];
    
    public function companies()
    {
        return $this->belongsTo('App\Company');
    }
}
