<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:task-list|task-create|task-edit|task-delete', ['only' => ['index','show']]);
         $this->middleware('permission:task-create', ['only' => ['create','store']]);
         $this->middleware('permission:task-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:task-delete', ['only' => ['destroy']]);
    }
    
    public function index(): View
    {
        $tasks = Task::get();
        return view('tasks.index',compact('tasks'));
    }
    
   
    public function create(): View
    {
        return view('tasks.create');
    }
    
   
    public function store(Request $request): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
            'status'=>'required'
        ]);
    
        Task::create($request->all());
    
        return redirect()->route('tasks.index')
                        ->with('success','task created successfully.');
    }
    
   
    public function show(Task $task): View
    {
        return view('tasks.show',compact('task'));
    }
    
    
    public function edit(Task $task): View
    {
        return view('tasks.edit',compact('task'));
    }
    
   
    public function update(Request $request, Task $task): RedirectResponse
    {
         request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
    
        $task->update($request->all());
    
        return redirect()->route('tasks.index')
                        ->with('success','task updated successfully');
    }
    
   
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();
    
        return redirect()->route('tasks.index')
                        ->with('success','task deleted successfully');
    }
}
