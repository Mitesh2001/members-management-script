@extends('admin.layouts.app', ['page' => 'members'])

@section('title', __("Member's Payments"))

@section('content')
    <div class="member-card d-flex flex-column">
        <div class="d-flex align-items-center justify-content-between mb-20 border-bottom pb-3 flex-wrap">
            <div>
                <h2 class="title">{{ $member->first_name }}'s {{ __('Payments') }}</h2>
            </div>
        </div>

        <div class="table-responsive">
            <table class="user-detail-list col-12">
                <thead>
                    <tr>
                        <th class="ptb-15">
                            <div class="user-title">#</div>
                        </th>

                        <th class="ptb-15">
                            <div class="user-title">{{ __('Payment Date') }}</div>
                        </th>

                        <th class="ptb-15">
                            <div class="user-title">{{ __('Amount') }}</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($member->payments as $payment)
                        <tr>
                            <td class="ptb-15">
                                <div class="user-info">
                                    <div class="u-id">
                                        {{ $payment->id }}
                                    </div>
                                </div>
                            </td>

                            <td class="ptb-15">
                                <div class="user-info">
                                    <div class="u-name">
                                        {{ $payment->payment_date }}
                                    </div>
                                </div>
                            </td>

                            <td class="ptb-15">
                                <div class="user-info">
                                    <div class="u-date">
                                        {{ $payment->amount }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="ptb-15" colspan="4">
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
        </div
    </div>
@endsection
