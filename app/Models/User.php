<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function films()
    {
        return $this->hasMany("App\Models\Movie", "user");
    }
}
