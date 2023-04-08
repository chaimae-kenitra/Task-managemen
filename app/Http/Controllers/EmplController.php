<?php

namespace App\Http\Controllers;

use App\Models\Employee;

use Illuminate\Http\Request;

class EmplController extends Controller
{
    public function index(Request $request)
    {
          
        $employees = Employee::all();
     
      return view('empl',["employees" => $employees]);
    }    
    public function subEmp(Request $request)
    {
         
        $employees = Employee::all();
     
      return view('empl',["employees" => $employees]);
    }
}
