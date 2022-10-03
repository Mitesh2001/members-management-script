@extends('admin.layouts.app', ['page' => 'payments'])

@section('title', __('Payments'))

@section('content')
    <div class="main-content">
        <ul class="member-list row">
            <li class="col-12">
                <div class="member-card">
                    <div class="d-flex align-items-center justify-content-between mb-20 border-bottom pb-2 flex-wrap">
                        <h2 class="title">{{ __('Payments') }}</h2>

                        <div>
                            <a href="{{ route('admin.payments.online') }}">
                                <button class="pull-right nav-btn bg-blue color-blue">
                                    {{ __('Online Payment') }}
                                </button>
                            </a>

                            <a href="{{ route('admin.payments.create') }}">
                                <button class="nav-btn bg-blue color-blue mr-3">
                                    {{ __('Add New') }}
                                </button>
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="user-detail-list" id="payments-table">
                            <thead>
                                <tr>
                                    <th class="ptb-15 user-title">#</th>
                                    <th class="ptb-15 user-title">@lang('Avatar')</th>
                                    <th class="ptb-15 user-title">@lang('Member')</th>
                                    <th class="ptb-15 user-title">@lang('Amount')</th>
                                    <th class="ptb-15 user-title">@lang('payment Date')</th>
                                    <th class="ptb-15 user-title">@lang('New Validity Date')</th>
                                    <th class="ptb-15 user-title">@lang('Status')</th>
                                    <th class="ptb-15 user-title">@lang('Action')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </li>
        </ul>
    </div>
@endsection

@push('scripts')
    <script>
        function deletePayment(date = null, id) {
            var message = 'Are you sure delete ?';

            if (date) {
                message = message + "This payment member validity extended to " + date;
            }

            if (confirm(message)) {
                $(" *[data-id="+id+"]").submit();
            }
        }

        $(function () {
            $('#payments-table').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: "{{ route('admin.payments.list') }}",
                columns: [
                    { name: 'id' },
                    { name: 'avatar', orderable: false, searchable: false },
                    { name: 'member.first_name' },
                    { name: 'amount' },
                    { name: 'payment_date' },
                    { name: 'new_validity_date', "defaultContent": "<i>Not set</i>" },
                    { name: 'status'},
                    { name: 'action', orderable: false, searchable: false }
                ],
            });
        });
    </script>
@endpush
