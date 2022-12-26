@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            @if (Route::has('todo.create'))
            <a href="/todo/create" class="btn btn-primary mb-3">Create</a>
            @endif

            <div class="card">
                <div class="card-header">{{ __('Todo') }}</div>
                <div class="card-body">
                    @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @unless (Route::has('todo.create', ))
                    <form method="POST" action="{{ route('todo.store') }}">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="formGroupExampleInput">Task</label>
                            <input type="text" name="task"
                                class="focus form-control @error('task') is-invalid @enderror"
                                id="formGroupExampleInput" placeholder="Task name" value="{{ old('task') }}" autofocus>
                            @error('task')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Create</button>
                    </form>
                    @endunless


                    <table class="table @unless (Route::has('todo.create')) mt-5 @endunless">
                        <thead>
                            <tr>
                                {{-- <th scope="col">#</th> --}}
                                <th>On Going Task</th>
                                {{-- <th>Info</th> --}}
                                <th>Created</th>
                                <th width="150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($todos as $todo)
                            <tr>
                                <td>{{ $todo->task }}</td>
                                <td>{{ \Carbon\Carbon::parse($todo->created_at)->diffForHumans() }}</td>
                                <td>
                                    <div class="d-flex gap-2">

                                        <a class="btn btn-info" href="{{ route('todo.edit', $todo) }}">Edit</a>
                                        <form action="{{ route('todo.complete', $todo) }}" method="Post">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success">Complete</button>
                                        </form>
                                        <form action="{{ route('todo.destroy', $todo) }}" method="Post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                {{-- <th scope="col">#</th> --}}
                                <th>Completed Task</th>
                                {{-- <th>Info</th> --}}
                                <th>Created</th>
                                <th width="150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($todosCompleted as $todo)
                            <tr>
                                <td>{{ $todo->task }}</td>
                                <td>{{ \Carbon\Carbon::parse($todo->created_at)->diffForHumans() }}</td>
                                <td>
                                    <div class="d-flex gap-2">

                                        <a class="btn btn-info" href="{{ route('todo.edit', $todo) }}">Edit</a>
                                        <form action="{{ route('todo.incomplete', $todo) }}" method="Post">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success">Undo</button>
                                        </form>
                                        <form action="{{ route('todo.destroy', $todo) }}" method="Post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <form action="{{ route('todo.deleteallcompleted') }}" method="Post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Delete All Completed Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
