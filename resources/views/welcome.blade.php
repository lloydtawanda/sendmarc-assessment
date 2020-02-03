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
            <td>{{$task->name}}</td>
            <td>{{$task->priority}}</td>
            <td>{{$task->dueIn}}</td>
            <td>
                <div class="btn-group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editRecordModal" onclick="selectedTask.id ='{{$task->id}}';">CHANGE</button>
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
            alert(id)
            this.taskId = id;
        }
    };

let tickTasks = function () {
    alert('Tasks details are being updated.');
    $.get("{{ url('/list/tick') }}", function(data, status){

        if(status == 'success'){
            location.reload();
        }else{
            alert('Failed to update task details.');
        }

    });
}

let updateTask = function (taskId) {
    $.ajax({
        url: "{{ url('/tasks') }}",
        type: 'POST',
        dataType: 'json',
        data:  {
            id: taskId,
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
    $.post("{{ url('/tasks') }}",
        {
            name: $("#createRecordName").val(),
            priority: $("#createRecordPriority").val(),
            dueIn: $("#createRecordDueIn").val()
        },
        function(data,status){
            if(status == 'success'){
                location.reload();
            }else{
                alert('Failed to create task');
            }
        });
}

let deleteTask = function (taskId) {
        $.ajax({
            url: "{{ url('/tasks') }}" + "/" + parseInt(taskId),
            type: 'DELETE',
            success: function(result) {
                alert(JSON.stringify(result));
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
