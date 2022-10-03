@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://www.jqueryscript.net/demo/Bootstrap-4-Dropdown-Select-Plugin-jQuery/dist/css/bootstrap-select.css">
@endpush

<form role="form" method="POST" action="{{ $route }}">
    @csrf

    @if ($method)
        @method($method)
    @endif

    <div class="member-card">
        <div class="d-flex align-items-center justify-content-between mb-20 border-bottom pb-3 flex-wrap">
            <div class="title-main">
                <h2 class="title">
                    {{ $method ? __('Update Payment') : __('Add New Payments') }}
                </h2>
            </div>

            <div class="button-main">
                @if ($method)
                    <a href="{{ route('admin.payment.invoice', ['payment' => $payment->id]) }}" target="_blank">
                        <button type="button" class="nav-btn bg-orange color-orange mr-3">
                            <i class="fa fa-print"></i>
                            {{ __('Print Invoice') }}
                        </button>
                    </a>
                @endif

                <a href="{{ route('admin.payments.index') }}">
                    <button type="button" class="nav-btn bg-red color-red mr-3">{{ __('Cancel') }}</button>
                </a>

                @if (! $payment->webhook_id)
                    <button type="submit" class="nav-btn bg-blue color-blue mr-3">
                        {{ $method ? __('Update') : __('Submit') }}
                    </button>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('Member') }}
                    @if (isset($member->id))
                       <input type="text" value="{{ $member->getName() }}" readonly>
                    @else
                    <select class="selectpicker btn-primary"
                        name="member_id"
                        id="member-id"
                        required
                    >
                        <option selected disabled>{{ __('Select Member') }}</option>

                        @foreach ($members as $member)
                            <option value="{{ $member->id }}"
                                {{ old('member_id', $payment->member_id) == $member->id ? "selected" : "" }}
                            >
                                {{ $member->getName() }}
                            </option>

                        @endforeach
                    </select>
                    @endif
                </label>
            </div>

            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('Payment Date') }}
                    <div class="input-group">
                        <input type="text"
                            name="payment_date"
                            class="payment-date"
                            placeholder="{{ __('Payment Date') }}"
                            value="{{ old('payment_date', $payment->payment_date) }}"
                            required
                        >
                        <span class="input-group-addon">
                            <img src="{{ asset('/images/icons/calendar.png') }}" alt="Calendar">
                        </span>
                    </div>
                </label>
            </div>

            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('Amount') }}
                    <input name="amount"
                        type="number"
                        value="{{ old('amount', $payment->amount) }}"
                        placeholder="{{ __('Amount') }}"
                        {{ $payment && $payment->payment_date && $payment->webhook_id ? 'readonly' : ''}}
                    >
                </label>
            </div>

            <div class="form-input col-12 col-lg-6 {{ $method && $payment->new_validity_date ? '' : 'd-none' }}">
                <label>
                    {{ __('New Extended Validity Date') }}
                    <input type="text" value="{{ $payment->new_validity_date }}" readonly>
                </label>
            </div>

            <div class="form-input col-12 col-lg-6 d-none">
                <label>
                    {{ __('Membership Plan') }}
                    <input type="text"
                        class="membership-plan"
                        placeholder="{{ __('Amount') }}"
                        readonly
                    >
                </label>
            </div>

            <div class="form-input col-12 col-lg-6 d-none">
                <label>
                    {{ __('Validity Date') }}
                    <input type="text"
                        class="membership-validity-date"
                        value="{{ old('amount', $payment->amount) }}"
                        placeholder="{{ __('Amount') }}"
                        readonly
                    >
                </label>
            </div>

            <div class="form-input col-12 col-lg-6 d-none">
                <label>
                    {{ __('Extend validity') }}
                    <input type="checkbox"
                        class="new-validity-date"
                        name="new_validity_date"
                        id="new-validity-date"
                        value="1"
                        checked
                    >
                </label>
            </div>

            <div class="form-input col-12 col-lg-6 d-none">
                <label>
                    {{ __('New Validity Date') }}
                    <input type="text" class="new-validity-date-display" readonly>
                </label>
            </div>
        </div>
    </div>
</form>

@push('scripts')
    <script src="https://unpkg.com/flatpickr"></script>
    <script>
        @if ($payment && $payment->payment_date && $payment->webhook_id)
            flatpickr('.payment-date', {
                defaultDate: '{{ $method ? "" : "today"}}',
                enable: [
                    {
                        from: "{{$payment->payment_date}}",
                        to: "{{$payment->payment_date}}"
                    }
                ],
                maxDate: "today",
                altInput: true,
                disableMobile: true,
                altFormat: "d-m-Y"
            });
        @else
            flatpickr('.payment-date', {
                defaultDate: '{{ $method ? "" : "today"}}',
                maxDate: "today",
                altInput: true,
                disableMobile: true,
                altFormat: "d-m-Y"
            });
        @endif
    </script>
@endpush
