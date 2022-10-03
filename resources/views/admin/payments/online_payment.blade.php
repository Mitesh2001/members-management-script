@extends('admin.layouts.app', ['page' => 'payments'])

@section('title', __('Add New Online Payment'))

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://www.jqueryscript.net/demo/Bootstrap-4-Dropdown-Select-Plugin-jQuery/dist/css/bootstrap-select.css">
@endpush

@section('content')
    <div class="main-content">
        @php
            $route =  $payment->id ?
                route('admin.payments.online', ['id' => $payment->id]) :
                route('admin.payments.online')
            ;
        @endphp

        <form role="form" method="post" action="{{ $route }}">
            @csrf

            @if ($payment->id)
                @method('PUT')
            @endif

            <div class="member-card">
                <div class="d-flex align-items-center justify-content-between mb-20 border-bottom pb-3 flex-wrap">
                    <div class="title-main">
                        <h2 class="title">{{ __('Add New Online Payment') }}</h2>
                    </div>

                    <div class="button-main">
                        <a href="{{ route('admin.payments.index') }}">
                            <button type="button" class="nav-btn bg-red color-red mr-3">
                                {{ __('Cancel') }}
                            </button>
                        </a>

                        <button type="submit" class="nav-btn bg-blue color-blue mr-3">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="form-input col-12 col-lg-6">
                        <label>
                            {{ __('Member') }}
                            <select class="selectpicker btn-primary"
                                name="member_id"
                                id="member-id"
                                required
                            >
                                <option selected disabled>{{ __('Select Member') }}</option>

                                @foreach ($members as $member)
                                    @if ( $payment && $payment->payment_date && $payment->webhook_id)
                                        @if ($payment->member_id == $member->id)
                                            <option value="{{ $member->id }}" selected>
                                                {{ $member->getName() }}
                                            </option>
                                        @endif
                                    @else
                                        <option value="{{ $member->id }}"
                                            {{ old('member_id', $payment->member_id) == $member->id ? "selected" : "" }}
                                        >
                                            {{ $member->getName() }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
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

                    <div class="form-input col-12 col-lg-6 d-none">
                        <label>
                            {{ __('Membership Plan') }}
                            <input type="text" class="membership-plan" placeholder="{{ __('Amount') }}" readonly>
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

                    <div class="form-input col-12 col-lg-6 {{ $payment->new_validity_date ? '' : 'd-none' }}">
                        <label>
                            {{ __('New Extended Validity Date') }}
                            <input type="text" value="{{ $payment->new_validity_date }}" readonly>
                        </label>
                    </div>

                    <div class="form-input col-12 col-lg-6 d-none">
                        <label>
                            {{ __('Extend validity') }}
                            <input type="checkbox"
                                class="new-validity-date"
                                name="new_validity_date"
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
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/flatpickr"></script>
    <script>
        flatpickr('.payment-date', {
            defaultDate: "today",
            maxDate: "today",
            altInput: true,
            disableMobile: true,
            altFormat: "d-m-Y"
        });

        $(function () {
            $('#member-id').on('change', function () {
                $.ajax({
                    method: "POST",
                    url: "{{ route('admin.member.detail') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": $('#member-id :selected').val(),
                    },
                    success: function(response) {
                        $('.new-validity-date-display').val(response.newValidityDate);
                        $('.new-validity-date').prop("checked", false);
                        $('.new-validity-date-display').parent('label').closest('.form-input').addClass('d-none')
                        $('.membership-plan').parent('label').parent('.form-input').removeClass('d-none')

                        if (response.member.membership_plan) {
                            $('.membership-plan').val(response.member.membership_plan.name);
                            $('form [name=amount]').val(response.member.membership_plan.price);
                        } else {
                            $('.membership-plan').val('Membership Plan not selected');
                            $('form [name=amount]').val('');
                        }

                        $('.membership-validity-date').parent('label').parent('.form-input').removeClass('d-none');

                        if (response.member.validity_date) {
                            var date = new Date(response.member.validity_date);

                            $('.membership-validity-date').val(date.getDate() + "-" + (date.getMonth()+1) +"-"+date.getFullYear());
                        } else {
                            $('#membership-validity-date').val('validity Date not set');
                        }

                        if (response.member.membership_plan && response.member.validity_date) {
                            $('.new-validity-date').parent('label').closest('.form-input').removeClass('d-none');
                        } else {
                            $('.new-validity-date').parent('label').closest('.form-input').addClass('d-none');
                        }
                    }
                });
            });

            $('.new-validity-date').on('change', function() {
                if (this.checked) {
                    $('.new-validity-date-display').parent('label').closest('.form-input').removeClass('d-none')
                } else {
                    $('.new-validity-date-display').parent('label').closest('.form-input').addClass('d-none')
                }
            });
        });
    </script>
@endpush
