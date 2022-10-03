<ul class="d-flex justify-content-start align-items-center actions">
    <li>
        <a href="{{ route('admin.trainers.edit', ['trainer' => $trainer->id]) }}"
            class="hover-green"
            title="Edit Trainer"
        >
            <i class="fa fa-pencil-square-o"></i>
        </a>
    </li>

    <li>
        <a onclick="timings('{{ $trainer->id }}')"
            class="hover-blue pointer"
            title="Trainer's Timings"
        >
            <i class="fa fa-clock-o"></i>
        </a>
    </li>

    <li>
        <form method="post"
            action="{{ route('admin.trainers.destroy', ['trainer' => $trainer->id]) }}"
        >
            @csrf
            @method('DELETE')
            <a onclick="if (confirm('This trainer\'s timings, and all details will be removed from the system. Are you sure?')) { this.parentNode.submit() }"
                class="hover-red pointer"
                title="Remove Trainer"
            >
                <i class="fa fa-trash-o"></i>
            </a>
        </form>
    </li>
</ul>
