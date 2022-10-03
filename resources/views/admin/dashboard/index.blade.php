@extends('admin.layouts.app', ['page' => 'dashboard'])

@section('title', __('Dashboard'))

@section('content')
<div class="main-content">
    <ul class="member-list row">
        @include('admin.dashboard.includes.members')

        @include('admin.dashboard.includes.active_members')

        @include('admin.dashboard.includes.trainers')

        @include('admin.dashboard.includes.payments')
    </ul>

    <ul class="member-list row">
        @include('admin.dashboard.includes.members_per_plan')

        @include('admin.dashboard.includes.timing_chart')
    </ul>

    <div class="member-list row mb-100">
        {{-- Membership Expire Details table --}}
        @include('admin.dashboard.includes.membership_plan_expire')

        {{-- New Payment success table --}}
        @include('admin.dashboard.includes.new_payment_success')
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>

    <script>
        var membershipPlanMembers = @json($membershipPlanMembers->pluck('members_count'));
        var membershipPlan = @json($membershipPlanMembers->pluck('name'));
        var timingMembers = @json($timingMembers->pluck('members_count'));
        var timingTrainers = @json($timingTrainers->pluck('trainers_count'));
        var timings = @json($timingMembers->pluck('full_time'));

        var membersTable = $('#expire-plan-members').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            searching: false,
            bInfo: false,
            lengthChange: false,
            pageLength: 5,
            ajax: "{{ route('admin.membership_plan_expire_list') }}",
            columns: [
                { name: 'id' },
                { name: 'avatar', orderable: false, searchable: false },
                { name: 'first_name' },
                { name: 'validity_date' },
                { name: 'status', orderable: false, searchable: false },
            ],
            order: [[3, 'asc']],
        });

        $(function(){
            const memberPerPlan = document.getElementById('member-per-plan').getContext('2d');
            const timingChart = document.getElementById('timing-per-member-trainer').getContext('2d');

            new Chart(memberPerPlan, {
                type: 'bar',
                data: {
                    labels: membershipPlan,
                    datasets: [{
                        label: 'Member Per Plan',
                        data: membershipPlanMembers,
                        backgroundColor: [
                            '#0d80f8',
                        ],
                        borderColor: [
                            '#0d80f8',
                        ],
                        borderWidth: 1,
                        borderRadius: 5,
                    }],
                },
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                        },
                        title: {
                            display: true,
                            text: 'Member Per Plan',
                            font: {
                                family: 'Montserrat',
                                size: '20px',
                                weight: '600'
                            },
                            color: '#26292f',
                            align: 'start'
                        },
                    },
                }
            });

            new Chart(timingChart, {
                type: 'bar',
                data: {
                    labels: timings,
                    datasets: [{
                        label: 'Member Per Plan',
                        data: timingMembers,
                        backgroundColor: [
                            '#0d80f8',
                        ],
                        borderColor: [
                            '#0d80f8',
                        ],
                        borderWidth: 1,
                        borderRadius: 5,
                    },
                    {
                        label: 'Trainer Per Plan',
                        data: timingTrainers,
                        backgroundColor: [
                            '#3f51b5',
                        ],
                        borderColor: [
                            '#3f51b5',
                        ],
                        borderWidth: 1,
                        borderRadius: 5,
                    }],
                },
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                        },
                        title: {
                            display: true,
                            text: 'Timing Chart',
                            font: {
                                family: 'Montserrat',
                                size: '20px',
                                weight: '600'
                            },
                            color: '#26292f',
                            align: 'start'
                        },
                    },
                }
            });
        });
    </script>
@endpush
