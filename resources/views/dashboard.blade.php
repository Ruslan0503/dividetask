<x-app-layout>

    <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            body, html {
                height: 100%;
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
            }

            .container {
                display: flex;
                height: 100vh;
                overflow: hidden;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .left {
                flex: 1;
                padding: 20px;
                background-color: #ffffff;
                border-right: 5px solid #e0e0e0;
                display: flex;
                flex-direction: column;
                gap: 20px;
            }

            .right {
                flex: 3;
                padding: 20px;
                background-color: #f1f1f1;
                display: flex;
                flex-direction: column;
                gap: 20px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            input[type="text"],
            textarea {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            input[type="submit"] {
                background-color: #4CAF50;
                color: white;
                border: none;
                padding: 10px 15px;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            input[type="submit"]:hover {
                background-color: #45a049;
            }

            .messages {
                background-color: #e7f3fe;
                border: 1px solid #b8daff;
                padding: 15px;
                border-radius: 10px;
                text-align: center;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .messages:hover {
                background-color: #d1ecf1;
            }

            h3 {
                margin-bottom: 10px;
            }

            .tasknth {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .btns {
                display: flex;
                gap: 20px;
            }

            button {
                padding: 10px 15px;
                border: none;
                border-radius: 5px;
                color: white;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            /* button:nth-of-type(1) {
                background-color: #28a745;
            } */

            button:nth-of-type(2) {
                background-color: #007bff;
            }

            button:hover {
                opacity: 0.8;
            }

            /* Responsive Styles */
            @media (max-width: 768px) {
                .container {
                    flex-direction: column;
                }

                .left, .right {
                    flex: none;
                    width: 100%;
                }
            }
        </style>
    </head>

    <div class="container">
        <div class="left">
            <form action="{{ route('savebio') }}" method="post">
                @csrf
                <div class="form-group">
                    <input type="text" name="title" id="title" placeholder="Occupation" value="{{ old('title', $info ? $info->title : '') }}">
                </div>
                <div class="form-group">
                    <textarea id="bio" name="bio" rows="6" placeholder="About yourself">{{ old('bio', $info ? $info->description : '') }}</textarea>
                </div>
                <input type="submit" value="Save">
            </form>

            <div class="messages" onclick="openCertainDiv('msgContacts')">
                <a href="#">Contact Messages</a>
            </div>
            <div class="messages" onclick="openCertainDiv('taskmsgs')">
                <a href="#">Task Messages</a>
            </div>
            @if($user->role == 'assignment')
                <div class="messages" onclick="openCertainDiv('createtask')">
                    <a href="#">Create Task</a>
                </div>
            @endif
        </div>

        <div class="right">
            <div class="msgContacts" id="msgContacts" style="display:none;">
                <h3>Messages</h3>
                @foreach($msgsContact as $msg)
                    <div style="display:flex; justify-content: space-between; padding: 10px; background-color: #fff; border-radius: 5px; margin-bottom: 10px;">
                        <h3>{{$msg->title}}</h3>
                        <div>
                            <a href="/rejectrequestcontact/{{ $msg->id }}" style="color: red;">Cancel</a>
                            <a href="/acceptrequestcontact/{{ $msg->id }}" style="color: green;">Accept</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="taskmsgs" id="taskmsgs" style="display:none;">
                @if($user->role == 'performer')
                    @foreach($taskss as $task)
                        <p>@ {{$task->name}}: {{$task->TaskText}} <a href="/taskacception/{{$task->id}}" style="color:blue;">Submit Task</a></p>
                    @endforeach
                @elseif($user->role == 'assignment')
                    @foreach($submittedtasks as $t)
                        <p>{{ $t->TaskText }} <a href="/donetasks/{{$t->id}}" style="color:blue;">See</a></p>
                    @endforeach
                @endif
            </div>

            @if($user->role == 'assignment')
                <div class="createtask" id="createtask" style="display: none;">
                    <h3>Create Tasks Here</h3>
                    <form id="taskForm" action="{{ route('saveTasks') }}" method="POST">
    @csrf
    <div id="taskFields">
        <div class="tasknth">
            <input type="text" name="tasks[0][task]" placeholder="Enter task" required>
            <label for="performers">Choose a performer:</label>
            <select name="tasks[0][performerID]" required>
                @foreach($workers as $worker)
                    <option value="{{ $worker->performerID }}">{{ $worker->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="btns">
        <button type="button" onclick="addTaskField()" style="background-color:green; ">Add Task</button>
        <button type="submit">Assign Tasks</button>
    </div>
</form>

            @endif
        </div>
    </div>
    @if (session('msg'))
    <script>
        alert("{{ session('msg') }}");
    </script>
@endif

    <script>
        window.onload = function() {
            var successMessage = "{{ session('msg') }}";
            if (successMessage) {
                alert(successMessage);
            }
        }

        function closeAllDiv() {
            document.getElementById("msgContacts").style.display = "none";
            document.getElementById("taskmsgs").style.display = "none";
            try{
                document.getElementById("createtask").style.display = "none";
            }catch{
                
            }
        }

        function openCertainDiv(name) {
            closeAllDiv();
            document.getElementById(name).style.display = "block";
        }

        function sendTasks() {
            console.log(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            console.log("Fetch URL:", "{{ route('saveTasks') }}");

                let taskss = [];
                document.querySelectorAll(".tasknth").forEach(it => {
                    let task = it.querySelector("input").value.trim();
                    let performerID = it.querySelector("select").value;

                    // Bo'sh topshiriqni e'tiborsiz qoldirish
                    if (task && performerID) {
                        taskss.push({ task, performerID });
                    }
                });

                // Agar hech qanday topshiriq bo'lmasa, xato ko'rsatiladi
                if (taskss.length === 0) {
                    alert('Please add at least one task with a performer.');
                    return;
                }

                fetch("{{ route('saveTasks') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify(taskss),
                })
                .then(response => {
                    return response.json();
                })
                .then(data => {
                    console.log("Server Response:", data);
                    alert(data['message']);
                })
                .catch((error)=>{
                    alert('error');
                })
                


        }


        let taskIndex = 1;

function addTaskField() {
    const taskFields = document.getElementById("taskFields");

    const newTaskField = `
        <div class="tasknth">
            <input type="text" name="tasks[${taskIndex}][task]" placeholder="Enter task" required>
            <label for="performers">Choose a performer:</label>
            <select name="tasks[${taskIndex}][performerID]" required>
                @foreach($workers as $worker)
                    <option value="{{ $worker->performerID }}">{{ $worker->name }}</option>
                @endforeach
            </select>
        </div>
    `;

    taskFields.insertAdjacentHTML('beforeend', newTaskField);
    taskIndex++;
}

    </script>
</x-app-layout>
