<ul class="d-flex justify-content-start align-items-center actions">
    <li>
        <a href="{{ route('admin.members.edit', ['member' => $member->id]) }}"
            class="hover-green"
            title="Edit Member"
        >
            <i class="fa fa-pencil"></i>
        </a>
    </li>

    <li>
        <a href="{{ route('admin.members.measurements', ['id' => $member->id]) }}"
            class="hover-blue"
            title="Member Measurements"
        >
            <i class="fa fa-list"></i>
        </a>
    </li>

    <li>
        <a href="{{ route('admin.members.payments', ['id' => $member->id]) }}"
            class="hover-orange"
            title="Member Payments"
        >
            <i class="fa fa-credit-card"></i>
        </a>
    </li>

    <li>
        <form method="post" action="{{ route('admin.members.destroy', ['member' => $member->id]) }}">
            @csrf
            @method('DELETE')

            <a onclick="if (confirm('This member\'s measurements, timings, and all details will be removed from the system. Are you sure?')) { this.parentNode.submit() }"
                class="hover-red pointer"
                title="Remove Member"
            >
                <i class="fa fa-trash"></i>
            </a>
        </form>
    </li>
</ul>
