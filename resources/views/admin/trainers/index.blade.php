@extends('admin.layouts.app', ['page' => 'trainers'])

@section('title', __('Trainers'))

@section('content')
    <div class="main-content">
        <ul class="member-list row">
            <li class="col-12">
                <div class="member-card mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-20 border-bottom pb-2 flex-wrap">
                        <h2 class="title">{{ __('Trainers') }}</h2>

                        <a href="{{ route('admin.trainers.create') }}">
                            <button class="pull-right nav-btn bg-blue color-blue">
                                {{ __('Add New') }}
                            </button>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="user-detail-list" id="trainers-table">
                            <thead>
                                <tr>
                                    <th class="ptb-15 user-title">#</th>
                                    <th class="ptb-15 user-title">@lang('Avatar')</th>
                                    <th class="ptb-15 user-title">@lang('Name')</th>
                                    <th class="ptb-15 user-title">@lang('Gender')</th>
                                    <th class="ptb-15 user-title">@lang('Mobile')</th>
                                    <th class="ptb-15 user-title">@lang('Email')</th>
                                    <th class="ptb-15 user-title">@lang('Action')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    {{-- Trainers' Timing Model --}}
    <div class="modal" tabindex="-1" role="dialog" id="trainer-timings-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __("Trainer's Timings") }}
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <table class="user-detail-list col-12 trainer-timings-table">
                        <thead>
                            <tr>
                                <th class="ptb-15">
                                    <div class="user-title">#</div>
                                </th>

                                <th class="ptb-15">
                                    <div class="user-title">{{ __('Start Time') }}</div>
                                </th>

                                <th class="ptb-15">
                                    <div class="user-title">{{ __('End Time') }}</div>
                                </th>
                            </tr>
                        </thead>

                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <template id="trainer-timing-row">
        <tr>
            <td class="ptb-15">
                <div class="user-info">
                    <div class="u-id"></div>
                </div>
            </td>

            <td class="ptb-15">
                <div class="user-info">
                    <div class="u-start-time"></div>
                </div>
            </td>

            <td class="ptb-15">
                <div class="user-info">
                    <div class="u-end-time"></div>
                </div>
            </td>
        </tr>
    </template>
@endsection

@push('scripts')
    <script>
        function timings(id) {
            var url = "{{ route('admin.trainers.timings', ['id' => 'trainer_id' ]) }}";
            url = url.replace('trainer_id', id);

            $.ajax({
                method: "GET",
                url: url,
                success: function(response) {
                    $('.trainer-timings-table tbody tr').remove();

                    response.data.timings.forEach(function(data) {
                        var trainerTimingRowTemplate = $('#trainer-timing-row').html();
                        $('.trainer-timings-table tbody').append(trainerTimingRowTemplate);

                        var trainerTimingRow = $('.trainer-timings-table tbody tr').last();
                        trainerTimingRow.find('.u-id').append(data.id);
                        trainerTimingRow.find('.u-start-time').append(data.start_time);
                        trainerTimingRow.find('.u-end-time').append(data.end_time);
                    });

                    if (response.data.timings.length == 0) {
                        $('.trainer-timings-table tbody').append(
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

                    $('#trainer-timings-modal').appendTo("body").modal('show');
                },
                error: function (response) {
                    console.log(response);
                },
            });
        }

        $(function () {
            $('#trainers-table').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: "{{ route('admin.trainers.list') }}",
                columns: [
                    { name: 'id' },
                    { name: 'avatar', orderable: false, searchable: false },
                    { name: 'first_name' },
                    { name: 'gender' },
                    { name: 'mobile_no' },
                    { name: 'email' },
                    { name: 'action', orderable: false, searchable: false }
                ],
            });
        });
    </script>
@endpush
