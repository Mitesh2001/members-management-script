@extends('admin.layouts.app', ['page' => 'members'])

@section('title', __('Members'))

@section('content')
    <div class="main-content">
        <div class="member-list row">
            <div class="col-12">
                <div class="member-card mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-20 border-bottom pb-2 flex-wrap">
                        <h2 class="title">{{ __('Members') }}</h2>

                        <div>
                            <a href="{{ route('admin.members.create') }}">
                                <button class="nav-btn bg-blue color-blue mr-3">
                                    {{ __('Add New') }}
                                </button>
                            </a>

                            <button class="nav-btn bg-blue color-blue import-member">
                                {{ __('Import Data') }}
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="user-detail-list" id="members-table">
                            <thead>
                                <tr>
                                    <th class="ptb-15 user-title">#</th>
                                    <th class="ptb-15 user-title">{{ __('Avatar') }}</th>
                                    <th class="ptb-15 user-title">{{ __('Name') }}</th>
                                    <th class="ptb-15 user-title">{{ __('Email') }}</th>
                                    <th class="ptb-15 user-title">{{ __('Phone') }}</th>
                                    <th class="ptb-15 user-title">{{ __('Status') }}</th>
                                    <th class="ptb-15 user-title">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Import Data --}}
    <div class="modal fade bd-example-modal-lg" id="import-member-data">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('Upload Member') }}
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="measurement-form-edit">
                        <form method="post"
                            action="{{ route('admin.members.uploads') }}"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            <div class="form-input col-12">
                                <label>
                                    {{ __('Member File') }}
                                    <input name="members" type="file" required>
                                </label>
                            </div>

                            <div class="form-group col-12">
                                <button type="reset" class="nav-btn bg-red color-red mr-3">
                                    {{ __('Reset') }}
                                </button>

                                <button type="submit" class="nav-btn bg-blue color-blue update-measurement">
                                    {{ __('Submit') }}
                                </button>

                                <a class="btn btn-primary" href="{{ asset('/xlsx/member_format.xlsx') }}">
                                    <button type="button" class="nav-btn bg-blue color-blue update-measurement">
                                        {{ __('Download Sample') }}
                                    </button>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('.import-member').on('click', function() {
                $('#import-member-data').appendTo("body").modal('show');
            });

            var membersTable = $('#members-table').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                "order": [[ 0, "desc" ]],
                ajax: "{{ route('admin.members.list') }}",
                columns: [
                    { name: 'id' },
                    { name: 'avatar', orderable: false, searchable: false },
                    { name: 'first_name' },
                    { name: 'email'},
                    { name: 'phone' },
                    { name: 'status' },
                    { name: 'action', orderable: false, searchable: false}
                ],
            });
        });
    </script>
@endpush
