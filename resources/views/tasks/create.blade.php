@extends('layouts.app') {{-- Extend your main layout file --}}

@section('title', 'Create New Task')

@section('content')

    <h1>Add a New Task</h1>

    {{-- The form should POST to the 'tasks.store' route --}}
    {{-- Assuming you are using Route::resource('tasks', TaskController::class) --}}
    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf {{-- CSRF protection token is mandatory for all POST forms --}}

        <div class="form-group">
            <label for="title">Title:</label>
            {{-- Use old() to retain input data on validation errors --}}
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description (Optional):</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Create Task</button>
        <a href="{{ route('tasks.index') }}">Cancel</a>
    </form>

@endsection