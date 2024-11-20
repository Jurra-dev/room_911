<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    
    protected $fillable = [
        'firstname',
        'lastname',
        'password',
        'department',
        'totalaccess',
        'type',
        'permission'
    ];


    protected $hidden = [
        'password',
    ];

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function hasAccess()
    {
        return $this->type === 'admin_room_911';
    }

    public function hasPermission()
    {
        return $this->permission === 'true';
    }

    public function create($firstname, $lastname, $department_id, $type, $password, $permission)
    {
        $newemp = new Employee();
        $newemp->firstname = $firstname;
        $newemp->lastname = $lastname;
        $newemp->department_id = $department_id;
        $newemp->totalaccess = 0;
        $newemp->type = $type;
        $newemp->password = $password;
        $newemp->permission = $permission;

        $newemp->save();
        return $newemp->id;

    }

    public function getAll()
    {
        return self::all();
    }

    public function get($id)
    {
        return self::find($id);
    }

    public function getFiltered($id = null, $name = null, $department_id = null, $startdate = null, $enddate = null)
    {
        $query = self::query(); // Start a new query for the Employee model

        if (!empty($id)) {
            $query->where('id', $id);
        }

        if (!empty($name)) {
            $query->where(function ($q) use ($name) {
                $q->where('firstname', 'like', "%{$name}%")
                  ->orWhere('lastname', 'like', "%{$name}%");
            });
        }

        if (!empty($department_id)) {
            $query->where('department_id', $department_id);
        }

        if (!empty($startdate) || !empty($enddate)) {
        $query->join('attempts', function ($join) use ($startdate, $enddate) {
            $join->on('employees.id', '=', 'attempts.employee_id');

            if (!empty($startdate)) {
                $join->where('attempts.time', '>=', Carbon::parse($startdate));
            }

            if (!empty($enddate)) {
                $join->where('attempts.time', '<=', Carbon::parse($enddate));
            }
        });
    }

        //var_dump($query->toSql());
        $query->distinct('employees.id');
        
        return $query->get(['employees.*']); // Execute the query and return the results
    }

    public function updateById($id, $firstname = null, $lastname = null, $department_id = null, $totalaccess = null, $type = null, $permission = null, $password = null)
    {
        $to_edit = $this->get($id);

        if (!empty($firstname))
        {
            $to_edit->firstname = $firstname;
        }

        if (!empty($lastname))
        {
            $to_edit->lastname = $lastname;
        }

        if (!empty($department_id))
        {
            $to_edit->department_id = $department_id;
        }

        if (!empty($totalaccess))
        {
            $to_edit->totalaccess = $totalaccess;
        }

        if (!empty($type))
        {
            $to_edit->type = $type;
        }

        if (!empty($password))
        {
            $to_edit->password = $password;
        }

        if (!empty($permission))
        {
            $to_edit->permission = $permission;
        }

        $to_edit->save();
    }

    public function updateFields($firstname = null, $lastname = null, $department_id = null, $totalaccess = null, $permission = null, $password = null)
    {

        if (!empty($firstname))
        {
            $this->firstname = $firstname;
        }

        if (!empty($lastname))
        {
            $this->lastname = $lastname;
        }

        if (!empty($department_id))
        {
            $this->department_id = $department_id;
        }

        if (!empty($totalaccess))
        {
            $this->totalaccess = $totalaccess;
        }

        if (!empty($permission))
        {
            $this->$permission = $permission;
        }

        if (!empty($password))
        {
            $this->password = $password;
        }

        $this->save();
    }

    public function regSuccessfulAttempt()
    {
        $this->increment('totalaccess');
    }

    public function deleteById($id)
    {
        $employee = $this->get($id);

        $employee->delete();
    }
}

