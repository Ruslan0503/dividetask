<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Information;

class DashboardController extends Controller
{
    public function submittask(Request $request, $idoftask){
        $task = DB::table("tasks")->where('id', $idoftask)->first();
        if (!$task) {
            echo "task was not found" . "<br>";
            echo $idoftask . "<br>";
            //return redirect()->route('dashboard')->with('error', 'Task not found');
        }

        // Validate the incoming request data
        $request->validate([
            'description' => 'required|string',
            'file' => 'required|file|mimes:jpg,jpeg,png,mp4,avi,doc,docx,xlsx,pdf|max:40000000',  // Allow file types and max size
        ]);

        // Check if file is actually uploaded
        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            echo "failing in validation";
            //return redirect()->route('dashboard')->with('error', 'No valid file uploaded');
        }

        // try {
            // Handle file upload
            $file = $request->file('file');
            $filePath = $file->store('media', 'public');  // Store file in 'media' directory in the public disk
            $fileType = $file->getMimeType();  // Get the MIME type of the uploaded file

            // Insert into the task_submission table
            $t = DB::table("task_submittions")->insert([
                'to' => $task->assignerID,  // Who the task is assigned to
                'taskID' => $task->id,      // The task ID
                'description' => $request->description,
                'file_path' => $filePath,
                'file_type' => $fileType,
                // 'created_at' => now(),
                // 'updated_at' => now(),
            ]);

            // Check if the insert was successful
            if ($t) {
                //echo "Worked so far";
                return redirect()->route('dashboard')->with('msg', 'Task submitted successfully!');
            } else {
                //echo "worked so far but unseccessfully";
                return redirect()->route('dashboard')->with('msg', 'Error in task submission');
            }

        // } catch (\Exception $e) {
        //     echo "error in try";
        //     // Log the error
        //     //\Log::error('Task submission failed: ' . $e->getMessage());
        //     //return redirect()->route('dashboard')->with('error', 'An error occurred while submitting the task');
        // }
    }

     public function saveTasks(Request $request) {
        $assigner = auth()->user();
        $tasks = $request->input('tasks'); // Forma orqali yuborilgan massivni olish
    
        foreach ($tasks as $task) {
            DB::table("tasks")->insert([
                'TaskText'   => $task['task'],
                'assignerID' => $assigner->id,
                'performerID'=> $task['performerID'],
                'condition'  => 'on started',
            ]);
        }
    
        return redirect()->back()->with('msg', 'Tasks assigned successfully!');
    }
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function RejectRequestContact($id){
        DB::table("message_for_contacts")->where('id',$id)->delete();
        return redirect("/dashboard");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AcceptRequestContact($id){
        $msgContact = DB::table("message_for_contacts")->where('id',$id)->first();
        $id1 = $msgContact->from;
        $id2 = $msgContact->to;
        $assigner;
        $performer;
        // Get the role of the user with id = $id1
        $role = DB::table("users")->where('id', $id1)->value('role');

        // Condition to assign performer and assigner based on the role of the user
        if ($role == 'performer') {
            // Get the data for performer and assigner
            $performer = DB::table("users")->where('id', $id1)->first();
            $assigner = DB::table("users")->where('id', $id2)->first();
        } else {
            // Get the data for performer and assigner
            $performer = DB::table("users")->where('id', $id2)->first();
            $assigner = DB::table("users")->where('id', $id1)->first();
        }

        DB::table("workers")->insert([
            'assignerID'=>$assigner->id,
            'performerID'=>$performer->id,
        ]);
        DB::table("message_for_contacts")->where('id',$id)->delete();
        return redirect("/dashboard");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function findingPage(){
        $employees = DB::table("users")->where('role', 'performer')->get();
        $employers = DB::table("users")->where('role', 'assignment')->get();
        $user = auth()->user();
        return view("findingpeople", compact('employees', 'employers','user'));        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            // If not authenticated, redirect to login page
            return redirect()->route('login');
        }
   
        // Fetch the user's information (if it exists)
        $info = DB::table('information')->where('user_id', $user->id)->first();
        $msgsContact = DB::table('message_for_contacts')->where('to', $user->id)->get();
        // Debugging: Log the result to check if the data is being retrieved
        // Log::info('User Info:', ['info' => $info]);
        if($user->role =='assignment'){
            $workers = DB::table("workers")
            ->join('users','workers.performerID', '=', 'users.id')
            ->where('workers.assignerID',$user->id)
            ->select('users.name','workers.*')
            ->get();
            $submittedtasks = DB::table("task_submittions")
            ->join('tasks', 'task_submittions.taskId', '=', 'tasks.id')
            ->where('tasks.condition', 'active')
            ->where('task_submittions.to', $user->id)
            ->select('tasks.TaskText','task_submittions.id')
            ->get();
            return view('dashboard', compact('info','msgsContact','user','workers','submittedtasks'));    
        }else{
            $workers = [];
            $submittedtasks = [];
            $taskss = DB::table("tasks")
            ->join('users','tasks.assignerID','=','users.id')
            ->where('performerID',$user->id)
            ->where('condition', ['on started','active'])
            ->select('users.name','tasks.*')
            ->get();
            return view('dashboard', compact('info','msgsContact','user','taskss','workers','submittedtasks'));
        }
        // Pass the information to the dashboard view
        return view('dashboard', compact('info','msgsContact','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

// @if(Auth::check() && Auth::user()->role == 'performer')
//                     <li class="nav-item">
//                         <a class="nav-link" href="/finding"><button class="nav-link" style="background:none; border:none; padding:0;">Find your employer</button></a>
//                     </li>    
//                     @endif
