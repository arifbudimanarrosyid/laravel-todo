<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{

    public function index()
    {
        // get all todos
        // $todos = Todo::all();

        // get all todos for current user where is_completed is false
        // Query Builder Way
        // $todos = DB::table('todos')
        //     ->where('user_id', auth()->user()->id)
        //     ->where('is_completed', false)
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        // Eloquent Way - Readable
        $todos = Todo::where('user_id', auth()->user()->id)
            ->where('is_completed', false)
            ->orderBy('created_at', 'desc')
            ->get();

        // get all todos for current user where is_completed is true
        $todosCompleted = Todo::where('user_id', auth()->user()->id)
            ->where('is_completed', true)
            ->orderBy('created_at', 'desc')
            ->get();

        // dd($todos);
        return view('todo.index', compact('todos', 'todosCompleted'));
    }


    public function create()
    {
        return view('todo.create');
    }

    public function store(Request $request, Todo $todo)
    {
        $request->validate([
            'task' => 'required|max:255',
        ]);

        // Practical
        // $todo = new Todo;
        // $todo->task = $request->task;
        // $todo->user_id = auth()->user()->id;
        // $todo->save();

        // Query Builder way
        // DB::table('todos')->insert([
        //     'task' => $request->task,
        //     'user_id' => auth()->user()->id,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // Eloquent Way - Readable
        $todo = Todo::create([
            'task' => $request->task,
            'user_id' => auth()->user()->id,
        ]);

        // dd($todo);
        return redirect()->route('todo.index')->with('success', 'Todo created successfully!');
    }


    // public function show(Todo $todo)
    // {
    //     if (auth()->user()->id == $todo->user_id) {
    //         dd($todo);
    //         return view('todo.show', compact('todo'));
    //     } else {
    //         return redirect()->route('todo.index');
    //     }
    // }

    public function edit(Todo $todo)
    {
        // if auth id is equal to todo user id then show edit page
        // else return 403 not authorized
        // else redirect to todo index page

        if (auth()->user()->id == $todo->user_id) {
            // dd($todo);
            return view('todo.edit', compact('todo'));
        } else {
            // abort(403);
            // abort(403, 'Not authorized');
            return redirect()->route('todo.index');
        }
    }

    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'task' => 'required|max:255',
        ]);

        // Practical
        // $todo->task = $request->task;
        // $todo->save();

        // Eloquent Way - Readable
        $todo->update([
            'task' => $request->task,
        ]);
        return redirect()->route('todo.index')->with('success', 'Todo updated successfully!');
    }

    public function destroy(Todo $todo)
    {
        if (auth()->user()->id == $todo->user_id) {
            $todo->delete();
            return redirect()->route('todo.index')->with('success', 'Todo deleted successfully!');
        } else {
            return redirect()->route('todo.index');
        }
    }

    public function complete(Todo $todo)
    {
        $todo->is_completed = true;
        $todo->save();
        // dd($todo);
        return redirect()->route('todo.index')->with('success', 'Completed successfully!');
    }

    public function incomplete(Todo $todo)
    {
        $todo->is_completed = false;
        $todo->save();
        // dd($todo);
        return redirect()->route('todo.index')->with('success', 'Undo complete successfully!');
    }

    public function destroyCompleted()
    {
        // get all todos for current user where is_completed is true
        $todosCompleted = Todo::where('user_id', auth()->user()->id)
            ->where('is_completed', true)
            ->get();
        foreach ($todosCompleted as $todo) {
            $todo->delete();
        }
        // dd($todosCompleted);

        return redirect()->route('todo.index')->with('success', 'All completed todos deleted successfully!');
    }
}
