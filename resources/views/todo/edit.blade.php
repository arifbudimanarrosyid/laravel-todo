@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">{{ __('Edit Todo') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('todo.update', $todo) }}">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="formGroupExampleInput">Task</label>
                            <input type="text" name="task" class="form-control @error('task') is-invalid @enderror"
                                id="formGroupExampleInput" placeholder="Task name" value="{{ old('task',$todo->task) }}"
                                autofocus>
                            @error('task')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Save</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
