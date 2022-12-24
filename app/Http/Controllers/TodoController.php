<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{

    public function index()
    {
        $todos = Todo::where('user_id', auth()->user()->id)
            ->where('is_completed', false)
            ->orderBy('created_at', 'desc')
            ->get();
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
        $todo = new Todo;
        $todo->task = $request->task;
        $todo->user_id = auth()->user()->id;
        $todo->save();
        // dd($todo);
        return redirect()->route('todo.index');
    }


    public function show(Todo $todo)
    {
        //
    }

    public function edit(Todo $todo)
    {
        if (auth()->user()->id == $todo->user_id) {
            return view('todo.edit', compact('todo'));
        } else {
            return redirect()->route('todo.index');
        }
        dd($todo);
    }

    public function update(Request $request, Todo $todo)
    {
        $todo->task = $request->task;
        $todo->save();
        return redirect()->route('todo.index');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect()->route('todo.index');
    }

    public function complete(Todo $todo)
    {
        $todo->is_completed = true;
        $todo->save();
        return redirect()->route('todo.index');
    }

    public function incomplete(Todo $todo)
    {
        $todo->is_completed = false;
        $todo->save();
        return redirect()->route('todo.index');
    }
}
