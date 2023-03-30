<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task ;
use App\Models\Employee ;
use App\Models\EmployeeTask ;

class AdminController extends Controller
{
    public function index()
    {
        $tasks = Task::with('employees')->get();

        return view('admin', compact('tasks'));
    }
    public function store(Request $request)
    {
        $task = new Task();
        $task->projectname = $request->input('projectname');
        $task->todo = $request->input('todo');
        $task->status = $request->input('status');
        $task->deadline = $request->input('deadline');
        $task->save();
    
        $employee = Employee::firstOrCreate([
            'name' => $request->input('employee')
        ]);
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
}
