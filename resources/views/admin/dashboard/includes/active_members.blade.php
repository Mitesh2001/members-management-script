<li class="col-12 col-md-6 col-lg-3">
    <a href="{{ route('admin.members.index') }}">
        <div class="member-card d-flex flex-column">
            <div class="d-flex justify-content-between">
                <div class="member-card-member">
                    <h5>{{ __('Active Members') }}</h5>
                    <div class="color-pink number">{{ $activeMembers }}</div>
                </div>

                <div class="member-card-icon bg-pink d-flex justify-content-center align-items-center">
                    <img src="{{ asset('/images/icons/active_members.png') }}">
                </div>
            </div>
        </div>
    </a>
</li>
