@extends('admin.layouts.app', ['page' => 'timings'])

@section('title', __('Timings'))

@section('content')
    <div class="main-content">
        <ul class="member-list row">
            <li class="col-12">
                <div class="member-card mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-20 border-bottom pb-2 flex-wrap">
                        <h2 class="title">{{ __('Timing') }}</h2>

                        <a href="{{ route('admin.timings.create') }}">
                            <button class="pull-right nav-btn bg-blue color-blue">
                                {{ __('Add New') }}
                            </button>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="user-detail-list" id="timings-table">
                            <thead>
                                <tr>
                                    <th class="ptb-15 user-title">#</th>
                                    <th class="ptb-15 user-title">@lang('Start Time')</th>
                                    <th class="ptb-15 user-title">@lang('End Time')</th>
                                    <th class="ptb-15 user-title">@lang('NO. of Trainers')</th>
                                    <th class="ptb-15 user-title">@lang('No. of Members')</th>
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
        $(function () {
            $('#timings-table').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: "{{ route('admin.timings.list') }}",
                columns: [
                    { name: 'id' },
                    { name: 'start_time' },
                    { name: 'end_time' },
                    { name: 'trainers_count', orderable: false, searchable: false },
                    { name: 'members_count', orderable: false, searchable: false },
                    { name: 'action', orderable: false, searchable: false}
                ],
            });
        });
    </script>
@endpush
