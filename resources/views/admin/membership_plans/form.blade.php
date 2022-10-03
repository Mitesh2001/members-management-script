@push('styles')
    <link rel="stylesheet" href="https://www.jqueryscript.net/demo/Bootstrap-4-Dropdown-Select-Plugin-jQuery/dist/css/bootstrap-select.css">
@endpush

<form method="post" action="{{ $route }}">
    @csrf

    @if ($method)
        @method($method)
    @endif

    <div class="member-card">
        <div class="d-flex align-items-center justify-content-between mb-20 border-bottom pb-3 flex-wrap">
            <div class="title-main">
                <h2 class="title">
                    {{ $method ? __('Update Membership Plan') : __('Add New Membership Plan') }}
                </h2>
            </div>

            <div class="button-main">
                <a href="{{ route('admin.membership-plans.index') }}">
                    <button type="button" class="nav-btn bg-red color-red mr-3">
                        {{ __('Cancel') }}
                    </button>
                </a>

                <button type="submit" class="nav-btn bg-blue color-blue">
                    {{ $method ? __('Update') : __('Submit') }}
                </button>
            </div>
        </div>

        <div class="row">
            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('Name') }}
                    <input placeholder="{{ __('Name') }}"
                        tabindex="1"
                        name="name"
                        type="text"
                        value="{{ old('name', $membershipPlan->name) }}"
                        required
                    />
                </label>
            </div>

            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('Price') }}
                    <input type="number"
                        name="price"
                        placeholder="{{ __('Price') }}"
                        tabindex="2"
                        value="{{ old('price', $membershipPlan->price) }}"
                        required
                    />
                </label>
            </div>

            <div class="form-input col-12 col-lg-6">
                <label>
                    {{ __('Plan') }}
                    <select class="selectpicker btn-primary"
                        name="plan"
                        data-title="Location"
                        id="state_list2"
                        data-width="100%"
                        required
                    >
                        <option selected disabled>
                            {{__('Select Plan')}}
                        </option>

                        @foreach ($planOptions as $key => $value)
                            <option value="{{ $key }}"
                                {{ old('plan', $membershipPlan->plan) == $key ? "selected" : "" }}
                            >
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>
        </div>
    </div>
</form>
