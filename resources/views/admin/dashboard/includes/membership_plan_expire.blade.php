<div class="col-12 col-lg-6">
    <div id="member-expire-accordion">
        <div class="member-card">
            <div class="panel panel-default">
                <div role="tab"
                    class="panel-heading collapsed d-flex justify-content-between align-items-center"
                    id="member-expire-heading"
                    data-toggle="collapse"
                    data-parent="#member-expire-accordion"
                    href="#member-expire-body-collapse"
                    aria-expanded="true"
                    aria-controls="member-expire-body-collapse"
                >
                    <h4 class="panel-title">
                        <span class="title">{{ __('Membership Plan Expire') }}</span>
                    </h4>

                    <i class="fa fa-chevron-down"></i>
                    <i class="fa fa-chevron-up" style="display: none"></i>
                </div>

                <div id="member-expire-body-collapse"
                    class="panel-collapse"
                    role="tabpanel"
                    aria-labelledby="member-expire-heading"
                >
                    <div class="panel-body table-responsive">
                        <table class="user-detail-list col-12" id="expire-plan-members">
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
                                        <div class="user-title">{{ __('Validity Till') }}</div>
                                    </th>

                                    <th class="ptb-15">
                                        <div class="user-title">{{ __('Status') }}</div>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
