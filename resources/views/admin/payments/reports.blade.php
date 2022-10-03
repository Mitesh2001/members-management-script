@extends('admin.layouts.app', ['page' => 'payment-report'])

@section('title', __('Payments Reports'))

@push('styles')
    <link rel="stylesheet"
        type="text/css"
        href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"
    />
@endpush

@section('content')
    <div class="member-card d-flex flex-column">
        <div class="d-flex align-items-center justify-content-between mb-20 border-bottom pb-3 flex-wrap">
            <div>
                <h2 class="title">{{ __('Payments Report') }}</h2>
            </div>
        </div>

        <div class="row">
            <div class="form-input col-12 col-md-6 offset-md-6">
                <label>
                    {{ __('Report Date') }}
                    <div class="input-group">
                        <input type="text" id="payment-report-date-range-filter">

                        <span class="input-group-addon">
                            <img src="{{ asset('/images/icons/calendar.png') }}" alt="Calendar">
                        </span>
                    </div>
                </label>
            </div>
        </div>

        <div class="table-responsive">
            <table class="user-detail-list col-12 payment-report-table">
                <thead>
                    <tr>
                        <th class="ptb-15">
                            <div class="user-title">#</div>
                        </th>

                        <th class="ptb-15">
                            <div class="user-title">{{ __('Amount') }}</div>
                        </th>

                        <th class="ptb-15">
                            <div class="user-title">{{ __('payment Date') }}</div>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($paymentsReports as $paymentsReport)
                        <tr>
                            <td class="ptb-15">
                                <div class="user-info">
                                    <div class="u-id">{{ $paymentsReport->id}}</div>
                                </div>
                            </td>

                            <td class="ptb-15">
                                <div class="user-info">
                                    <div class="u-name">{{ $paymentsReport->date_total}}</div>
                                </div>
                            </td>

                            <td class="ptb-15">
                                <div class="user-info">
                                    <div class="u-date">
                                        {{ date("d-m-Y", strtotime($paymentsReport->payment_date)) }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="ptb-15" colspan="2">
                                <div class="user-info">
                                    <div class="u-status color-red text-center">
                                        {{ __('No records found') }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <template id="payment-report-row">
        <tr>
            <td class="ptb-15">
                <div class="user-info">
                    <div class="u-id"></div>
                </div>
            </td>

            <td class="ptb-15">
                <div class="user-info">
                    <div class="u-name u-total"></div>
                </div>
            </td>

            <td class="ptb-15">
                <div class="user-info">
                    <div class="u-date u-payment-date"></div>
                </div>
            </td>
        </tr>
    </template>
@endsection

@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script type="text/javascript">
        $(function() {
            var start = moment().subtract(29, 'days');
            var end = moment();

            $('#payment-report-date-range-filter').daterangepicker({
                startDate: start,
                endDate: end,
                applyButtonClasses: 'btn-outline-primary',
                cancelButtonClasses: 'btn-outline-secondary',
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

            $('#payment-report-date-range-filter').on('apply.daterangepicker', function(ev, picker) {
                $.ajax({
                    method: "POST",
                    url: "{{ route('admin.payments.report') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "start_date": picker.startDate.format('YYYY-MM-DD'),
                        "end_date": picker.endDate.format('YYYY-MM-DD'),
                    },
                    success: function(response) {
                        $('.payment-report-table tbody').empty();

                        response.data.forEach(function(data) {
                            var paymentReportRowTemplate = $('#payment-report-row').html();
                            $('.payment-report-table tbody').append(paymentReportRowTemplate);

                            var paymentReportRow = $('.payment-report-table tbody tr').last();

                            paymentReportRow.find('.u-id').append(data.id);
                            paymentReportRow.find('.u-total').append(data.date_total);
                            paymentReportRow.find('.u-payment-date').append(data.payment_date);
                        });

                        if (response.data.length == 0) {
                            $('.payment-report-table tbody').append(
                                `<tr>
                                    <td class="ptb-15" colspan="3">
                                        <div class="user-info">
                                            <div class="u-status color-red text-center">
                                                {{ __('No records found') }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>`
                            );
                        }
                    }
                });
            });
        });

        function cb(start, end) {
            $('#payment-report-date-range-filter span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    </script>
@endpush
