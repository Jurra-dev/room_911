<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class AttemptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('attempt');
    }

    public function showAttempts($id)
    {
        return view('listattempts', compact("id"));
    }

    public function getAttempts(Request $request)
    {

        $employee_id = (int)$request->input('employee_id');
        $tmp = new Attempt();

        $attemptlist = $tmp->getByEmployee($employee_id);
        
        return response()->json([
            'attemptlist' => $attemptlist,
            'employee_id' => $employee_id
        ]);
        
    }

    public function attemptAccess(Request $request)
    {
        $employeeId = $request->input('employee_id');

        if (empty($employeeId)){
            return response()->json(['message' => 'Access denied']);
        }

        $temporalEmp = new Employee();
        $temporalEmp = $temporalEmp->get($employeeId); //Searches for the employee in the DB and returns it.

        $attempt = new Attempt();
        $attempt->create($employeeId); //Registers a new Access attempt using the ID provided

        if ($temporalEmp && $temporalEmp->hasPermission()) //checks if the given Employee has access to Room_911
        {
            $temporalEmp->regSuccessfulAttempt();
            return response()->json(['message' => 'Access granted']);
        }
        else
        {
            return response()->json(['message' => 'Access denied']);
        }
    }
}
