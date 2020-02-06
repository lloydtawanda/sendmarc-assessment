<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Task Fighter</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body >

<nav class="navbar navbar-default" >
        <a class="navbar-brand"  href="#">Task Manager</a>
</nav>
<br/>

<div style="padding: 40px">
<div class="row" >
    <div class="col-1">
        <h1 >Tasks</h1>
    </div>

    <div class="col-3" style="padding-top: 20px">
        <div class="btn-toolbar">
            <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#createRecordModal" style="height: fit-content; width: 150px; bottom: 0 ;">NEW</button>
            <button type="button" class="btn btn-primary " style="height: fit-content; width: 150px; bottom: 0 ;" onclick="tickTasks()">TICK</button>
        </div>
  </div>
</div>

<br/>

<table class="table">
    <thead class="thead-dark">
    <tr>
        <th >Name</th>
        <th>Priority</th>
        <th>Due In (Days)</th>
        <th>Action</th>
    </tr>
    </thead>
    @foreach($tasks as $task)
        <tr>
            <td id="name-{{$task->id}}">{{$task->name}}</td>
            <td id="priority-{{$task->id}}">{{$task->priority}}</td>
            <td id="dueIn-{{$task->id}}">{{$task->dueIn}}</td>
            <td>
                <div class="btn-group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editRecordModal" onclick="editTask({{$task->id}})">CHANGE</button>
                    <button type="button" class="btn btn-danger" onclick="deleteTask({{$task->id}})">REMOVE</button>
                </div>
            </td>
        </tr>
    @endforeach
</table>

<!-- Modals -->

{{--Create Record Modal--}}
<div class="modal fade" id="createRecordModal" tabindex="-1" role="dialog" aria-labelledby="createRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRecordModal">New Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form >
                    @method('post')
                    <div class="form-group">
                        <label for="createRecordName">Name:</label>
                        <input type="text" class="form-control" id="createRecordName">
                    </div>
                    <div class="form-group">
                        <label for="createRecordPriority">Priority:</label>
                        <input type="number" class="form-control" id="createRecordPriority">
                    </div>
                    <div class="form-group">
                        <label for="createRecordDueIn">Due in (days):</label>
                        <input type="number" class="form-control" id="createRecordDueIn">
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveTask()">Save</button>
            </div>
        </div>
    </div>
</div>

{{--Edit / Update Record Modal--}}
<div class="modal fade" id="editRecordModal" tabindex="-1" role="dialog" aria-labelledby="editRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRecordModal">Edit Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form >
                    <div class="form-group">
                        <label for="editRecordName">Name:</label>
                        <input type="text" class="form-control" id="editRecordName">
                    </div>
                    <div class="form-group">
                        <label for="editRecordPriority">Priority:</label>
                        <input type="number" class="form-control" id="editRecordPriority">
                    </div>
                    <div class="form-group">
                        <label for="editRecordDueIn">Due in (days):</label>
                        <input type="number" class="form-control" id="editRecordDueIn">
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateTask()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">


    let selectedTask = {
        taskId : -1,
        get id(){
            return this.taskId;
        },
        set id(id){
            this.taskId = id;
        }
    };

    let editTask = function(id) {
        selectedTask.id = id;

        document.getElementById('editRecordName').value = document.getElementById('name-'+id).innerHTML;
        document.getElementById('editRecordPriority').value = document.getElementById('priority-'+id).innerHTML;
        document.getElementById('editRecordDueIn').value = document.getElementById('dueIn-'+id).innerHTML;

    }

let tickTasks = function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "{{ url('/list/tick') }}",
        type: 'GET',
        success: function (data, textStatus, xhr) {
           location.reload();
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
}

let updateTask = function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "{{ url('/tasks') }}"+"/"+selectedTask.id,
        type: 'PUT',
        dataType: 'json',
        data:  {
            id: selectedTask.id,
            name: $("#editRecordName").val(),
            priority: $("#editRecordPriority").val(),
            dueIn: $("#editRecordDueIn").val()
        },
        success: function (data, textStatus, xhr) {
            location.reload();
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
}

let saveTask = function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:  "{{ url('/tasks') }}",
        type: 'POST',
        data:  {
            name: $("#createRecordName").val(),
            priority: $("#createRecordPriority").val(),
            dueIn: $("#createRecordDueIn").val()
        },
        success: function(data){
            location.reload();
        },
        error: function(data) {
            alert('Failed to create new record');
        }
    });
}

let deleteTask = function (taskId) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ url('/tasks') }}" + "/" + parseInt(taskId),
            type: 'DELETE',
            success: function(result) {
                location.reload();
            },
            error: function (jqXHR, status, err) {
                alert(err);
            }
        });
}

</script>
</div>
</body>
</html>
