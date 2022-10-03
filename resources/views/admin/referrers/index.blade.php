@extends('admin.layouts.app', ['page' => 'top-referrers'])

@section('title', __('Top Referrers'))

@section('content')
    <div class="member-card d-flex flex-column">
        <div class="d-flex align-items-center justify-content-between mb-20 border-bottom pb-2 flex-wrap">
            <h2 class="title">{{ __('Top Referrers') }}</h2>
        </div>

        <div class="table-responsive">
            <table class="user-detail-list col-12" id="top-referrers-table">
                <thead>
                    <tr>
                        <th class="ptb-15">
                            <div class="user-title">#</div>
                        </th>

                        <th class="ptb-15">
                            <div class="user-title">{{ __('Avatar') }}</div>
                        </th>

                        <th class="ptb-15">
                            <div class="user-title">{{ __('Name') }}</div>
                        </th>

                        <th class="ptb-15">
                            <div class="user-title">{{ __('Email') }}</div>
                        </th>

                        <th class="ptb-15">
                            <div class="user-title">{{ __('Phone') }}</div>
                        </th>

                        <th class="ptb-15">
                            <div class="user-title">{{ __('Total Referrers') }}</div>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            var membersTable = $('#top-referrers-table').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                "order": [[ 5, "desc" ]],
                ajax: "{{ route('admin.top-referrers.data_table_list') }}",
                columns: [
                    { name: 'id' },
                    { name: 'avatar', orderable: false, searchable: false },
                    { name: 'first_name' },
                    { name: 'email'},
                    { name: 'phone' },
                    { name: 'referents_count', searchable: false}
                ],
            });
        });
    </script>
@endpush
