<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllDepartments()
    {
        $departments = new Department();
        $departments = $departments->getAll();

        return response()->json([
            'departments' => $departments->toArray()
        ]);
    }

}
