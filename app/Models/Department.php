<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'name',
        'tpye'
    ];


    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function getAll()
    {
        return self::all();    
    }

}
