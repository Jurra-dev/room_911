<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model

{

    public $timestamps = false;

    protected $fillable = [
        'employee_id',
        'time',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function create($employee_id)
    {
        $newatt = new Attempt();
        $newatt->employee_id = $employee_id;
        $newatt->time = Carbon::now();
        $newatt->save();

        return $newatt->id;
    }

    public function getByEmployee($employee_id)
    {
        return self::where('employee_id', $employee_id)->get();
    }
}
