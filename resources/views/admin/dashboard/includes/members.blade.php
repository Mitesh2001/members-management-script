<li class="col-12 col-md-6 col-lg-3">
    <a href="{{ route('admin.members.index') }}">
        <div class="member-card d-flex flex-column">
            <div class="d-flex justify-content-between">
                <div class="member-card-member">
                    <h5>{{ __('Members') }}</h5>
                    <div class="color-blue number">{{ $currentMonthMembersCount }}</div>
                </div>

                <div class="member-card-icon bg-blue d-flex justify-content-center align-items-center">
                    <img src="{{ asset('/images/icons/users.png') }}">
                </div>
            </div>

            <div class="member-per">
                <span class="color-{{ $membersPercentage > 0 ? 'green' : 'red' }}">
                    @if ($membersPercentage != 0)
                        {{ $membersPercentage }} %,
                    @else
                        @lang('N/A'),
                    @endif
                </span>
                {{ $membersPercentage > 0 ? 'join' : 'less'}} {{ __('members') }}
            </div>
        </div>
    </a>
</li>
