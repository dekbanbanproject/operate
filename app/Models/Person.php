<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'hrd_person';
    protected $primaryKey = 'ID';

    // public function prefixs() {
    //     return $this->belongsTo(Prefix::class);
    // }
    
    // public function user() {
    //     return $this->hasOne(User::class, 'PERSON_ID', 'ID');
    // }
}
