@foreach ($tasks as $task)
    <div class="task-item @if($task->is_completed) completed @endif">
        <h3>{{ $task->title }}</h3>
        <p>{{ $task->description }}</p>

        <form method="POST" action="{{ route('tasks.toggle', $task) }}" style="display:inline;">
            @csrf
            @method('PATCH')
            <button type="submit">
                {{ $task->is_completed ? 'Mark Incomplete' : 'Mark Complete' }}
            </button>
        </form>
        
        <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </div>
@endforeach