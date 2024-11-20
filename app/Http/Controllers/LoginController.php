<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\PseudoTypes\True_;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $employeeId = $request->input('employee_id');
        $password = $request->input(('password'));

        if (empty($employeeId)){
            return response()->json(['message' => 'Access denied']);
        }

        $temporalEmp = new Employee();
        $temporalEmp = $temporalEmp->get($employeeId); //Searches for the employee in the DB and returns it.

        $empPassword = $temporalEmp->password;



        if ($temporalEmp && $temporalEmp->hasAccess() && $empPassword == $password) //checks if the given Employee has access to Room_911
        {
            return response()->json([
                'message' => 'Access granted',
                'permission' => true
            ]);
        }
        else
        {
            return response()->json([
                'message' => 'Access denied',
                'permission' => false
        ]);
        }
    }
}
