<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('home');
    }

    public function getEmployees(Request $request)
    {

        $employeeId = $request->input('employee_id');
        $employeeName = $request->input('name');
        $employeeDepartmentId = $request->input('department_id');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $employees = new Employee();
        $employees = $employees->getFiltered($employeeId, $employeeName, $employeeDepartmentId, $startDate, $endDate);

        return response()->json([
            'employees' => $employees->toArray()
        ]);
    }

    public function changeType(Request $request)
    {
        $employee_id = (int)$request->input('id_to_modify');
        $employee_type = $request->input(('actual_type'));
        $tmp = new Employee();

        if ($employee_type == 'admin_room_911')
        {
            $tmp->updateById($employee_id, null, null, null, null, 'regular');
        }
        else
        {
            $tmp->updateById($employee_id, null, null, null, null, 'admin_room_911');
        }

        

        return response()->json([
            'employee_id' => $employee_id,
            'employee_type' => $employee_type
        ]);
        
    }

    public function showCreate()
    {
        return view('createemployee');
    }

    public function showEdit($id)
    {
        // $employee_id = $request->input('id');
        return view('editemployee', compact("id"));
    }

    public function createEmployee(Request $request)
    {
        $employeeFirstName = $request->input('firstName');
        $employeeLastName = $request->input('lastName');
        $employeeDepartmentId = $request->input('department_id');
        $employeeType = $request->input('type');
        $employeePassword = $request->input('password');

        $tmp = new Employee();
        $tmp->create($employeeFirstName, $employeeLastName, $employeeDepartmentId, $employeeType, $employeePassword);

        return response()->json(['message' => 'Employee successfully created']);

    }

    public function editEmployee(Request $request)
    {
        $employee_id = $request->input('employee_id');
        $employeeFirstName = $request->input('firstName');
        $employeeLastName = $request->input('lastName');
        $employeeDepartmentId = $request->input('department_id');
        $employeeType = $request->input('type');

        $tmp = new Employee();
        $tmp->updateById($employee_id, $employeeFirstName, $employeeLastName, $employeeDepartmentId, null, $employeeType);

        return response()->json(['message' => 'Employee successfully updated']);

    }

    public function deleteEmployee($id)
    {

        $employee_id = $id;

        $tmp = new Employee();
        $tmp->deleteById($employee_id);

        return response()->json([
            'message' => 'Employee successfully deleted',
            'employee_id' => $employee_id
    ]);
    }
        
}
