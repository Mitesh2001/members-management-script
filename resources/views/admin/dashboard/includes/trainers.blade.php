<li class="col-12 col-md-6 col-lg-3">
    <a href="{{ route('admin.trainers.index') }}">
        <div class="member-card d-flex flex-column">
            <div class="d-flex justify-content-between">
                <div class="member-card-member">
                    <h5>{{ __('Trainers') }}</h5>
                    <div class="color-orange number">{{ $trainersCount }}</div>
                </div>

                <div class="member-card-icon bg-orange d-flex justify-content-center align-items-center">
                    <img src="{{ asset('/images/icons/trainers.png') }}">
                </div>
            </div>
        </div>
    </a>
</li>
