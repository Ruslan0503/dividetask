<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\bioController;
use Illuminate\Support\Facades\Route;
use App\Models\Information;
use App\Models\MessageForContact;


Route::get('/', function () {
    $user = Auth::user();
    return view('home', compact('user'));
})->name('home');

Route::post('/saveTasks', [DashboardController::class, 'saveTasks'])->name("saveTasks");

Route::post('submittask/{idoftask}', [DashboardController::class , 'submittask'])->name("submittask");

Route::get('acceptdonetask/{id}', function($id){
    $donetask = DB::table("task_submittions")->where('id', $id)->first();
    //changing condition of the task to done
    DB::table("tasks")->where('id',$donetask->taskID)->update([
        'condition'=>'finished',
    ]);
    return redirect('/dashboard');
});

Route::get('rejecttask/{id}', function($id){
    $donetask = DB::table('task_submittions')->where('id', $id)->first();
    DB::table("tasks")->where('id',$donetask->taskID)->update([
        'condition'=>'on started',
    ]);
    DB::table('task_submittions')->where('id', $id)->delete();
    return redirect('/dashboard');
});

Route::get('/donetasks/{id}', function($id){
    $donetask = DB::table("task_submittions")
    ->where('id', $id)->first();
    return view("seedonetask", compact('donetask'));
});

Route::get('/taskacception/{id}', function($id){
    DB::table("tasks")->where('id', $id)->update([
        'condition'=>'active',
    ]);
    $task = DB::table('tasks')->where('id', $id)->first();
    return view('taskperforming',compact('task'));
});

Route::post('/savebio', [bioController::class, 'store'])->name('savebio');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/finding', [DashboardController::class, 'findingPage'])->name('finding');

Route::get('/acceptrequestcontact/{id}', [DashboardController::class, 'AcceptRequestContact'])->name("AcceptRequestContact");
Route::get('/rejectrequestcontact/{id}', [DashboardController::class, 'RejectRequestContact'])->name("RejectRequestContact");

Route::get('/show/{id}', function ($id) {
    $user = DB::table("users")->where("id",$id)->first();
    $info = DB::table("information")->where("user_id",$id)->first();
    return view('show', compact('user','info'));
});

Route::get('/requestofassigner/{performerid}', function($performerid){
    $assg = auth()->user();
    $per = DB::table('users')->where('id', $performerid)->first();
    $newmsg = MessageForContact::insert([
        'title'=>"@$assg->name want to hire you",
        'from'=>$assg->id,
        'to'=>$per->id,
    ]);
    if ($newmsg) {
        session()->flash('msg', 'Request is in process!');
    } else {
        session()->flash('msg', 'Something went wrong!');
    }
    return redirect()->route('finding');
});

Route::get('/requestofperformer/{assignerId}', function($assignerId){
    $per = auth()->user();
    $assg = DB::table('users')->where('id', $assignerId)->first();
    $newmsg = MessageForContact::insert([
        'title'=>"@$per->name applied to work",
        'from'=>$per->id,
        'to'=>$assg->id,
    ]);
    if ($newmsg) {
        session()->flash('msg', 'Request is in process!');
    } else {
        session()->flash('msg', 'Something went wrong!');
    }
    return redirect()->route('finding');    
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
