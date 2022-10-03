<div class="col-12 col-lg-6">
    <div id="new-payment-accordion">
        <div class="member-card">
            <div class="panel panel-default">
                <div role="button"
                    class="panel-heading collapsed d-flex justify-content-between align-items-center"
                    id="new-payment-heading"
                    data-toggle="collapse"
                    data-parent="#new-payment-accordion"
                    href="#new-payment-body-collapse"
                >
                    <h4 class="panel-title">
                        <a href="#" class="title">{{ __('New Payment Success') }}</a>
                    </h4>

                    <i class="fa fa-chevron-down"></i>
                    <i class="fa fa-chevron-up" style="display: none"></i>
                </div>

                <div id="new-payment-body-collapse" class="panel-collapse" role="tabpanel">
                    <div class="panel-body table-responsive">
                        <table class="user-detail-list col-12">
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
                                        <div class="user-title">{{ __('Payment Date') }}</div>
                                    </th>

                                    <th class="ptb-15">
                                        <div class="user-title">{{ __('Amount') }}</div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($newPaymentSuccesses as $newPayment)
                                    <tr>
                                        <td class="ptb-15">
                                            <div class="user-info">
                                                <div class="u-id">{{ $newPayment->member->id }}</div>
                                            </div>
                                        </td>

                                        <td class="ptb-15">
                                            <div class="user-info">
                                                <div class="u-img">
                                                    <img src="{{ getAvatarUrl($newPayment->member, 'members', 'thumb') }}"
                                                        class="rounded-circle"
                                                        height="30px"
                                                        width="30px"
                                                    >
                                                </div>
                                            </div>
                                        </td>

                                        <td class="ptb-15">
                                            <div class="user-info">
                                                <a href="{{ route('admin.members.edit',['member' => $newPayment->member->id]) }}"
                                                    class="u-name"
                                                >
                                                    {{ $newPayment->member->getName() }}
                                                </a>
                                            </div>
                                        </td>

                                        <td class="ptb-15">
                                            <div class="user-info">
                                                <div class="u-date">
                                                    {{ date('d-m-Y', strtotime($newPayment->payment_date))}}
                                                </div>
                                            </div>
                                        </td>

                                        <td class="ptb-15">
                                            <div class="user-info">
                                                <div class="u-status">{{ $newPayment->amount }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="ptb-15" colspan="5">
                                            <div class="user-info">
                                                <div class="u-status">{{ __('No records found.') }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
