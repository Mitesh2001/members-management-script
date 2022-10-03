<ul class="d-flex justify-content-start align-items-center actions">
    <li>
        <a href="{{ route('admin.timings.edit', ['timing' => $timing->id]) }}"
            class="hover-orange"
            title="Edit Timing"
        >
            <i class="fa fa-pencil-square-o"></i>
        </a>
    </li>

    <li>
        <form method="post" action="{{ route('admin.timings.destroy', ['timing' => $timing->id]) }}">
            @csrf
            @method('DELETE')

            <a onclick="if (confirm('Are you sure?')) { this.parentNode.submit() }"
                class="hover-red pointer"
                title="Remove Timing"
            >
                <i class="fa fa-trash-o"></i>
            </a>
        </form>
    </li>
</ul>
