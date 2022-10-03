<form role="form" method="post" action="{{ $route }}" enctype="multipart/form-data">
    @csrf

    @if ($method)
        @method($method)
    @endif

    <div class="member-card">
        <div class="d-flex align-items-center justify-content-between mb-20 border-bottom pb-3 flex-wrap">
            <div class="title-main">
                <h2 class="title">
                    {{ $method ? __('Update Trainer') : __('Add New Trainer') }}
                </h2>
            </div>

            <div class="button-main">
                <a href="{{ route('admin.trainers.index') }}">
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
            <div class="form-input col-12 col-md-6">
                <div class="avatar-upload">
                    <div class="avatar-edit">
                        <input type="file"
                            name="avatar"
                            id="trainer-image-upload"
                            accept=".png, .jpg, .jpeg"
                        >
                        <label for="trainer-image-upload"></label>
                    </div>

                    <div class="avatar-preview">
                        <div id="image-preview"
                            style="background-image: url({{ $method ? getAvatarUrl($trainer, 'trainers', 'thumb') : asset('images/avatar.png') }});">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 pt-4">
                @if ($method)
                    <ul class="list-group">
                        @foreach ($trainer->getMedia('identity_proofs') as $media)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ $media->getFullUrl() }}" target="_blank">
                                    {{ $media->file_name }}
                                </a>

                                <button type="button"
                                    class="btn btn-link remove-media"
                                    data-id="{{ $media->id }}"
                                >
                                    <i class="fa fa-times"></i>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <div class="upload-file">
                    <input type="file"
                        name="identity_proofs[]"
                        id="identity-proofs"
                        accept=".png, .jpg, .jpeg"
                        multiple
                    >

                    <label for="identity-proofs">
                        <img src="{{ asset('/images/icons/upload.png') }}" alt="Upload" />
                        <span>Upload your ID Proofs here</span>
                    </label>
                </div>
            </div>

            <div class="form-input col-12 col-md-6 pt-4">
                <div class="label">
                    {{ __('Gender') }}
                    <span class="d-flex align-items-center pt-1">
                        <span class="radio">
                            <input name="gender"
                                id="male-radio"
                                type="radio"
                                value="1"
                                checked
                                required
                            >
                            <label for="male-radio" class="radio-label d-flex align-items-center">
                                {{ __('Male') }}
                            </label>
                        </span>

                        <span class="radio ml-5">
                            <input name="gender"
                                id="female-radio"
                                type="radio"
                                value="2"
                                {{ old("gender", $trainer->gender) == "2" ? "checked" : "" }}
                            >
                            <label for="female-radio" class="radio-label  d-flex align-items-center">
                                {{ __('Female') }}
                            </label>
                        </span>
                    </span>
                </div>
            </div>

            <div class="form-input col-12 col-md-6 pt-4">
                <label>
                    {{ __('First Name') }}
                    <input name="first_name"
                        type="text"
                        value="{{ old('first_name', $trainer->first_name) }}"
                        placeholder="{{ __('First Name') }}"
                        tabindex="1"
                        required
                    >
                </label>
            </div>

            <div class="form-input col-12 col-md-6 pt-4">
                <label>
                    {{ __('Last Name') }}
                    <input name="last_name"
                        type="text"
                        value="{{ old('last_name', $trainer->last_name) }}"
                        placeholder="{{ __('Last Name') }}"
                        tabindex="2"
                        required
                    >
                </label>
            </div>

            <div class="form-input col-12 col-md-6 pt-4">
                <label>
                    {{ __('Mobile No.') }}
                    <input name="mobile_no"
                        type="text"
                        value="{{ old('mobile_no', $trainer->mobile_no) }}"
                        placeholder="{{ __('Mobile No.') }}"
                        tabindex="3"
                        required
                    >
                </label>
            </div>

            <div class="form-input col-12 col-md-6 pt-4">
                <label>
                    {{ __('Phone No.') }}
                    <input name="phone"
                        type="text"
                        value="{{ old('phone', $trainer->phone) }}"
                        placeholder="{{ __('Phone No.') }}"
                        tabindex="4"
                        required
                    >
                </label>
            </div>

            <div class="form-input col-12 col-md-6 pt-4">
                <label>
                    {{ __('Email') }}
                    <input name="email"
                        type="email"
                        value="{{ old('email', $trainer->email) }}"
                        placeholder="{{ __('Email') }}"
                        tabindex="5"
                        required
                    >
                </label>
            </div>

            <div class="form-input col-12 pt-4">
                <label>
                    {{ __('Address') }}
                    <input name="address"
                        type="text"
                        value="{{ old('address', $trainer->address) }}"
                        placeholder="{{ __('Address') }}"
                        autocomplete="off"
                        tabindex="6"
                        required
                    >
                </label>
            </div>
        </div>
    </div>
</form>
@push('scripts')
    <script>
        $(function() {
            $("#trainer-image-upload").change(function() {
                updateImagePreview(this);
            });

            $(".remove-media").click(function() {
                var element = $(this);

                $.ajax({
                    method: "POST",
                    url: "/admin/trainers/{{ $trainer->id }}/remove-identification-proof/"+$(this).attr('data-id'),
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        new PNotify({
                            text: 'Identification proof removed successfully.',
                            styling: "bootstrap3",
                            type: 'success',
                        });

                        $(element).parent().remove();
                    }, error: function (xhr) {
                        new PNotify({
                            text: 'Something went wrong!',
                            styling: "bootstrap3",
                            type: 'error',
                        });
                    },
                });
            });
        });

        function updateImagePreview(element) {
            if (element.files && element.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview').css('background-image', 'url('+e.target.result +')');
                    $('#image-preview').hide();
                    $('#image-preview').fadeIn(650);
                }
                reader.readAsDataURL(element.files[0]);
            }
        }
    </script>
@endpush
