<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
          crossorigin="anonymous">

    <style>
        .task-item:hover {
            transform: translateY(-2px);
            transition: all 0.2s ease;
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="card shadow-sm rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h3 class="mb-0"><i class="bi bi-check2-square me-2"></i> TODO App</h3>
            <div>
                <a href="{{ route('tasks.index') }}" class="btn btn-light btn-sm me-2">All</a>
                <a href="{{ route('tasks.index', ['status' => 'active']) }}" class="btn btn-outline-light btn-sm me-2">Active</a>
                <a href="{{ route('tasks.index', ['status' => 'completed']) }}" class="btn btn-outline-light btn-sm">Completed</a>
            </div>
        </div>

        <div class="card-body bg-light">
            <form method="POST" action="{{ route('tasks.create') }}" class="mb-4">
                @csrf

                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <input type="text" 
                            name="title" 
                            class="form-control @error('title') is-invalid @enderror" 
                            placeholder="Task title"
                            value="{{ old('title') }}" 
                            maxlength="50" 
                            required>
                        @error('title')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <input type="text" 
                            name="description" 
                            class="form-control @error('description') is-invalid @enderror" 
                            placeholder="Description (optional)" 
                            value="{{ old('description') }}">
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary">Add Task</button>
                    </div>
                </div>
            </form>
            @foreach ($tasks as $task)
                <div class="card mb-3 border-0 shadow-sm task-item 
                    @if($task->is_completed) bg-success-subtle 
                    @else bg-warning-subtle @endif">

                    <div class="card-body">
                        @if(request('edit') == $task->id)
                            <form method="POST" action="{{ route('tasks.update', $task) }}">
                                @csrf
                                @method('PATCH')
                                <div class="row g-2 align-items-center">
                                    <div class="col-md-4">
                                        <input type="text" 
                                            name="title" 
                                            value="{{ old('title', $task->title) }}" 
                                            class="form-control @error('title') is-invalid @enderror"
                                            maxlength="50" required>
                                        @error('title')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" 
                                            name="description" 
                                            value="{{ old('description', $task->description) }}" 
                                            class="form-control @error('description') is-invalid @enderror">
                                        @error('description')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 d-grid">
                                        <button type="submit" class="btn btn-success btn-sm">Update</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="card-title mb-1 fw-bold 
                                        @if($task->is_completed) text-decoration-line-through text-muted @endif">
                                        {{ $task->title }}
                                    </h5>
                                    @if($task->description)
                                        <p class="card-text small mb-0 text-secondary">{{ $task->description }}</p>
                                    @endif
                                </div>

                                <div class="text-end">
                                    <form method="POST" action="{{ route('tasks.toggle', $task) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                            class="btn btn-sm 
                                            @if($task->is_completed) btn-outline-warning 
                                            @else btn-outline-success @endif">
                                            {{ $task->is_completed ? 'Mark Incomplete' : 'Mark Complete' }}
                                        </button>
                                    </form>

                                    <a href="{{ route('tasks.index', ['edit' => $task->id]) }}" 
                                        class="btn btn-sm btn-outline-info ms-1">Edit</a>

                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger ms-1">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="card-footer text-end small text-muted">
            {{ $tasks->count() }} {{ Str::plural('Task', $tasks->count()) }}
        </div>
    </div>
</div>
</body>
</html>
