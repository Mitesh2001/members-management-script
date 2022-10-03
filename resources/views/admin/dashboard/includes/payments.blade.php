<li class="col-12 col-md-6 col-lg-3">
    <a href="{{ route('admin.payments.index') }}">
        <div class="member-card d-flex flex-column">
            <div class="d-flex justify-content-between">
                <div class="member-card-member">
                    <h5>{{ __('Payments') }}</h5>
                    <div class="color-green number">{{ number_format($currentMonthPayments, 2) }}</div>
                </div>

                <div class="member-card-icon bg-green d-flex justify-content-center align-items-center">
                    <img src="{{ asset('/images/icons/payments.png') }}">
                </div>
            </div>

            <div class="member-per">
                <span class="color-{{ $paymentsPercentage > 0 ? 'green' : 'red' }}">
                    @if ($paymentsPercentage != 0 )
                        {{ $paymentsPercentage }} %,
                    @else
                        @lang('N/A'),
                    @endif
                </span>

                {{ $paymentsPercentage > 0 ? 'more' : 'less'}} {{ __('Payments') }}
            </div>
        </div>
    </a>
</li>
