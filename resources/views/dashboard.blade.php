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
                <div class="messages" onclick="openCertainDiv('create_task')">
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
                    <div>
                        <div class="tasknth">
                            <input type="text" name="task1" id="task1" placeholder="Enter task">
                            <label for="performers">Choose a performer:</label>
                            <select id="performers" name="performers">
                                @foreach($workers as $worker)
                                    <option value="{{ $worker->performerID }}">{{ $worker->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="btns" style="margin-top:5px;">
                        <button onclick="createTaskField()" style="background-color: #28a745;">Add</button>
                        <button onclick="sendTasks()">Assign Tasks</button>
                    </div>
                </div>
            @endif
        </div>
    </div>

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
            let taskss = [];
            document.querySelectorAll(".tasknth").forEach(it => {
                let task = it.querySelector("input").value;
                let performerID = it.querySelector("select").value;
                taskss.push({ task, performerID });
            });

            fetch(`{{ route('saveTasks') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify(taskss),
            })
            .then(response => response.json())
            .then(data => {
                alert(data['message']);
            })
            .catch(() => {
                alert('Error sending tasks');
            });
        }

        let count = 2;
        function createTaskField() {
            let newone = `
                <div class="tasknth">
                    <input type="text" name="task${count}" id="task${count}" placeholder="Enter task">
                    <label for="performers">Choose a performer:</label>
                    <select id="performers" name="performers">
                        @foreach($workers as $worker)
                            <option value="{{ $worker->performerID }}">{{ $worker->name }}</option>
                        @endforeach
                    </select>
                </div>
            `;
            document.getElementById("create_task2").insertAdjacentHTML('beforeend', newone);
            count++;
        }
    </script>
</x-app-layout>