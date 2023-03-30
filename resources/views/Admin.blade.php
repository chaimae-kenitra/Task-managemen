<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

    <div class="container">
        <h1 class=" text-center mt-5">Admin Page </h1>
        <button id="addTaskButton">Add Task</button>
       
        
       
      </div>
    <div class="table-responsive">
        
        <table class="table table-striped table-bordered">
        <thead>
            <tr>
                
                <th>Project Name</th>
                <th>To-Do</th>
              
                <th>Employee </th>
                <th>Type</th>
                <th>Status</th>
                <th>Deadline</th>
                <th>Assigned Date</th>
                <th>Action</th>>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                @foreach ($task->employees as $employee)
                    <tr>
                     
                        <td>{{ $task->projectname }}</td>
                        <td>{{ $task->todo }}</td>
            
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->type }}</td>
                        <td>{{ $task->status }}</td>
                        <td>{{ $task->deadline }}</td>
                        <td>{{ $employee->pivot->assigned_date }}</td>
                        <td>
                           <a href="#" class="edit-btn" data-task-id="{{ $task->id }}"><i class="fas fa-edit"></i></a>
                         <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
            </form>
         
        </td>
                            
                        
                    </tr>
                @endforeach
            @endforeach
        
        </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const addTaskButton = document.getElementById('addTaskButton');
    const tableBody = document.querySelector('tbody');

    addTaskButton.addEventListener('click', function() {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td><input type="text" name="projectname"></td>
            <td><input type="text" name="todo"></td>
            <td><input type="text" name="employee"></td>
            <td><input type="text" name="type"></td>
            <td><input type="text" name="status"></td>
            <td><input type="date" name="deadline"></td>
            <td><input type="date" name="assigned_date"></td>
            <td>
                <button class="saveButton">save</button>
            </td>
        `;
        tableBody.appendChild(newRow);

        const saveButton = newRow.querySelector('.saveButton');
        saveButton.addEventListener('click', function() {
            const projectname = newRow.querySelector('[name=projectname]').value;
            const todo = newRow.querySelector('[name=todo]').value;
            const employee = newRow.querySelector('[name=employee]').value;
            const type = newRow.querySelector('[name=type]').value;
            const status = newRow.querySelector('[name=status]').value;
            const deadline = newRow.querySelector('[name=deadline]').value;
            const assigned_date = newRow.querySelector('[name=assigned_date]').value;

            $.ajax({
                url: "{{ route('tasks.store') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "projectname": projectname,
                    "todo": todo,
                    "employee": employee,
                    "type": type,
                    "status": status,
                    "deadline": deadline,
                    "assigned_date": assigned_date
                },
                success: function(response) {
                    // Display success message
                    console.log(response);
                },
                error: function(xhr) {
                    // Display error message
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>

  
 
</body>
</html>