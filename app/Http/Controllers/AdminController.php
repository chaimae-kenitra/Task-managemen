<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task ;
use App\Models\Employee ;
use App\Models\EmployeeTask ;
use App\Models\Department;
use Illuminate\Routing\Controllers\Middleware;
use DB ;
use Carbon\Carbon;


class AdminController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //$tasks = Task::with('employees')->get();
        $tasks = DB::table('tasks')
        ->join('employee_task','employee_task.task_id','=','tasks.id')
        ->join('employees','employees.id','=','employee_task.employee_id')
        ->select('tasks.*','employees.name','employee_task.assigned_date')
        ->where('tasks.operation','=','dis')
        ->get();
        
        $emp = Employee::all();
       
       
       
        $statutTask = ['Open','Delivred','To Do','To Test','Colosed','Cancled'];
      
        return view('admin')
        ->with('tasks',$tasks)
        ->with('emp',$emp)
        ->with('statutTask',$statutTask);
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
        $task->type = $request->input('type');
        $task->operation = 'Dis'; 
        $task->status = $request->input('status') ;
        
        $task->deadline = $request->input('deadline');
        $task->history =' #'.'work on it '.$request->employee.' date created task '.Carbon::now();
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
    
        //$task = Task::findOrFail($id);
        //$task->employees()->detach(); // remove any employee-task assignments for this task
        //$task->delete();
        $task =Task::whereId($id)->update([
         'operation'=>'D'
        ]);
        return redirect()->back();
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

    public function getHistory(Request $request)
    {
        
        $history = Task::where('id','=',$request->id)->select('history')->get();
        $arrayhistory = [];
        foreach($history as $item)
        {
            array_push($arrayhistory,$item->history);
        }
        $arrayhistory = implode('#', $arrayhistory);
        $explodeArray = explode('#',$arrayhistory);
        $explodeArray = array_filter($explodeArray);
         return response()->json([
            'statut'=> 200,
            'Datahistory'=>$explodeArray,
         ]);
    }
   
  

}
