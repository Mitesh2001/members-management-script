@extends('admin.layouts.app', ['page' => 'membership-plans'])

@section('title', __('Membership Plans'))

@section('content')
    <div class="member-card d-flex flex-column">
        <div class="d-flex align-items-center justify-content-between mb-20 border-bottom pb-2 flex-wrap">
            <h2 class="title">{{ __('Membership Plans') }}</h2>

            <a href="{{ route('admin.membership-plans.create') }}">
                <button class="pull-right nav-btn bg-blue color-blue">
                    {{ __('Add New') }}
                </button>
            </a>
        </div>

        <div class="table-responsive">
            <table class="user-detail-list col-12">
                <thead>
                    <tr>
                        <th class="ptb-15">
                            <div class="user-title">#</div>
                        </th>

                        <th class="ptb-15">
                            <div class="user-title">{{ __('Name') }}</div>
                        </th>

                        <th class="ptb-15">
                            <div class="user-title">{{ __('Price') }}</div>
                        </th>

                        <th class="ptb-15">
                            <div class="user-title">{{ __('Plan') }}</div>
                        </th>

                        <th class="ptb-15">
                            <div class="user-title">{{ __('Members') }}</div>
                        </th>

                        <th class="ptb-15">
                            <div class="user-title">{{ __('Action') }}</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($membershipPlans as $membershipPlan)
                        <tr>
                            <td class="ptb-15">
                                <div class="user-info">
                                    <div class="u-id">{{ $membershipPlan->id }}</div>
                                </div>
                            </td>

                            <td class="ptb-15">
                                <div class="user-info">
                                    <div class="u-name">{{ $membershipPlan->name }}</div>
                                </div>
                            </td>

                            <td class="ptb-15">
                                <div class="user-info">
                                    <div class="u-date">{{ $membershipPlan->price }}</div>
                                </div>
                            </td>

                            <td class="ptb-15">
                                <div class="user-info">
                                    <div class="u-date">{{ $planOptions[$membershipPlan->plan] }}</div>
                                </div>
                            </td>

                            <td class="ptb-15">
                                <div class="user-info">
                                    <div class="u-date">{{ $membershipPlan->members->count() }}</div>
                                </div>
                            </td>

                            <td class="ptb-15">
                                <ul class="d-flex justify-content-start align-items-center actions">
                                    <li>
                                        <a class="hover-green"
                                            href="{{ route('admin.membership-plans.edit', ['membership_plan' => $membershipPlan->id]) }}"
                                            title="Edit Membership Plan"
                                        >
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </li>

                                    <li>
                                        <form method="post"
                                            action="{{ route('admin.membership-plans.destroy', ['membership_plan' => $membershipPlan->id]) }}"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <a class="hover-red pointer"
                                                onclick="if (confirm('Are you sure?')) { this.parentNode.submit() }"
                                                title="Remove Membership Plan"
                                            >
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="ptb-15" colspan="6">
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
@endsection
