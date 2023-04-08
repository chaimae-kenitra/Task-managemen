<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task ;
use App\Models\Employee ;
use App\Models\EmployeeTask ;
use App\Http\Controllers\DB ;

class AdminController extends Controller
{
    public function index()
    {
        $tasks = Task::with('employees')->get();
        $emp = Employee::all();
        $tas =Task::all();
        return view('admin')->with('tasks',$tasks)->with('emp',$emp)->with('tas',$tas)
;        

        //return view('admin', compact('tasks'));
    }
    public function getEmployees(Request $request)
    {
        $employees = Employee::where('id', $request->id)->pluck('name', 'id');
        return response()->json($employees);
    }
    
    public function store(Request $request)
    {
    
  
   $employee = Employee::firstOrCreate([
    'name' => $request->employee
    ]);
  
   

        $task = new Task();
        $task->projectname = $request->input('projectname');
        $task->todo = $request->input('todo');
        $task->status = $request->input('status') ;
        $task->deadline = $request->input('deadline');
        $task->save();
        
    
       
        $employeeTask = new EmployeeTask();
        $employeeTask->employee_id = $employee->id;
        $employeeTask->task_id = $task->id;
        $employeeTask->assigned_date = $request->input('assigned_date');
        $employeeTask->save();
       
    
        return response()->json(['success' => true]);
    }
    
public function destroy($id)
{
    
        $task = Task::findOrFail($id);
        $task->employees()->detach(); // remove any employee-task assignments for this task
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }
    public function subEmp(Request $request)
    {
         
        $employees = Employee::firstOrCreate([
            'name' => $request->input('employee')
        ]);
        return response()->json([
            'employees' => $employees
        ]);
    }
   
  
}
