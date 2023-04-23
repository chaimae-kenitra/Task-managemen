@extends('layout')

@section('content')
    


    
        
        <div class="w3-bar w3-black">
          
            
            
          <div>
            <a class="w3-button w3-right" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
          <h1 class="w3-button w3-right"  id="addTaskButton">Add new </h1>
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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                
                    <tr>
                     
                        <td>{{ $task->projectname }}</td>
                        <td>{{ $task->todo }}</td>
            
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->type }}</td>
                        <td>{{ $task->status }}</td>
                        <td>{{ $task->deadline }}</td>
                        <td>{{ $task->assigned_date }}</td>
                        <td>
                           
                         <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">

                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                <a href="#" class="fa fa-eye iconDispalyhistory"  value="{{$task->id}}" id=''></a >
            </form>
         
        </td>
                            
                        
                    </tr>
                
            @endforeach
        
        </tbody>
    </table>

    <div class="modal" tabindex="-1" role="dialog" id="modalhistory">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">History</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover" id="tablehistory">
                    <thead>
                  <tbody id="tablehistory">   
                     </thead>
                 </table>
            </div>
            <div class="modal-footer">
              
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    
<script>
  $('.iconDispalyhistory').on('click', function() {
    var idtask = $(this).attr('value');
    $('#modalhistory').show();
    $.ajax({
      type: 'get',
      url: '{{url("getHistory")}}',
      data: {
        id: idtask
      },
      dataType: 'json',
      success: function(response) {
        if (response.statut == 200) {
  $('#tablehistory').find('tbody').html('');
  $.each(response.Datahistory, function(index, value) {
    $('#tablehistory').find('tbody').append('<tr><td value="' + response.id + '">' + value + '</td></tr>');
  });
}
      },
      error: function() {
        alert('Error occurred while fetching data!');
      }
    });
  });
  
  $('#modalhistory .close').on('click', function() {
    $('#modalhistory').hide();
  });
  
  $('#modalhistory [data-dismiss="modal"]').on('click', function() {
    $('#modalhistory').hide();
  });


   
    const addTaskButton = document.getElementById('addTaskButton');
    const tableBody = document.querySelector('tbody');

    addTaskButton.addEventListener('click', function() {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td><input type="text" name="projectname"></td>
            <td><input type="text" name="todo"></td>
            <td><select class="browser-default custom-select" name="employee" id="employee">
                @foreach ($emp as $employee)
                    <option value="{{ $employee->name }}">{{ $employee->name }}</option>
                 @endforeach
                  
             </select></td>
            <td><input type="text" name="type"></td>

            <td><select class="browser-default custom-select" name="status" id="status">
                @foreach ($statutTask as $item)
                    <option value="{{ $item }}">{{ $item }}</option> 
                 @endforeach
                  
             </select></td>


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
                    location.reload();
                },
                error: function(xhr) {
                    // Display error message
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection