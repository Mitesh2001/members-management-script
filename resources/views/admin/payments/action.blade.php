<ul class="d-flex justify-content-start align-items-center actions">
    <li>
        <a href="{{ route('admin.payments.edit', ['payment' => $payment->id]) }}"
            class="hover-green"
            title="Edit Payment"
        >
            <i class="fa fa-pencil-square-o"></i>
        </a>
    </li>

    <li>
        <a target="_blank"
            href="{{ route('admin.payment.invoice', ['payment' => $payment->id]) }}"
            class="hover-orange"
            title="Print Invoice"
        >
            <i class="fa fa-print"></i>
        </a>
    </li>

    <li>
        <form method="post"
            action="{{ route('admin.payments.destroy', ['payment' => $payment->id]) }}"
            data-id="{{ $payment->id }}"
        >
            @csrf
            @method('DELETE')

            <a class="hover-red pointer"
                onclick="deletePayment('{{ $payment->new_validity_date }}','{{ $payment->id }}' )"
                title="Remove Payment"
            >
                <i class="fa fa-trash-o"></i>
            </a>
        </form>
    </li>
</ul>
