@extends('admin.layouts.app', ['page' => 'members'])

@section('title', __("Member's Measurements"))

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://www.jqueryscript.net/demo/Bootstrap-4-Dropdown-Select-Plugin-jQuery/dist/css/bootstrap-select.css">
@endpush

@section('content')
    @php
        $color = [ 1 => 'green', 2 => 'blue', 3 => 'pink', 4 => 'orange', 5 => 'sgreen', 6 => 'purple' ];
    @endphp

    <div class="main-content">
        <ul class="member-list row">
            <li class="col-12">
                <div class="member-card">
                    <div class="d-flex align-items-center justify-content-between mb-20 border-bottom pb-3 flex-wrap">
                        <div class="title-main">
                            <h2 class="title">{{ __("Member's Measurements") }}</h2>
                        </div>
                    </div>

                    <div class="head">{{ __('Measurements') }}</div>

                    <div class="row">
                        <div class="col-12 col-lg-6 row pt-4 mes-card">
                            @foreach ($measurementTypes as $key => $value)
                                <div class="col-12 col-md-6 pt-4">
                                    <div class="bg-{{$color[$key]}} w-100 d-flex justify-content-between align-items-center h-100 m-box">
                                        <div>
                                            <div class="name color-{{ $color[$key] }}">
                                                {{ __($value) }}
                                            </div>

                                            <div class="digit color-{{ $color[$key] }} measurement-{{ $key }}">
                                                {{
                                                    $memberMeasurements[$key]->last() ?
                                                    $memberMeasurements[$key]->last()->measurement_value :
                                                    "--"
                                                }}
                                            </div>
                                        </div>

                                        <div class="icon">
                                            <img src="{{ asset('/images/icons/'.strtolower($value).'.png') }}"
                                                alt="{{ $value }}"
                                                title="{{ $value }}"
                                            >
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center pt-4">
                            <form class="row pt-4" name="measurement-form" method="post">
                                @csrf

                                <input type="hidden" name="member_id" value="{{ $member->id }}">

                                <div class="col-12">
                                    <ul class="alert alert-danger d-none" id="measurement-error"></ul>
                                </div>

                                <div class="form-input w-100 col-12">
                                    <label>
                                        {{ __('Measurement Date') }}
                                        <div class="input-group">
                                            <input type="text"
                                                class="measurement-date"
                                                name="measurement_date"
                                                placeholder="{{ __('Measurement Date')}}"
                                                value="{{ old('measurement_date', $member->measurement_date) }}"
                                            >
                                            <span class="input-group-addon">
                                                <img src="{{ asset('/images/icons/calendar.png') }}" alt="Calendar">
                                            </span>
                                        </div>
                                    </label>
                                </div>

                                <div class="form-input w-100 col-12">
                                    <label>
                                        {{ __('Measurement Type') }}
                                        <select name="measurement_type"
                                            class="selectpicker btn-primary"
                                            id="state_list"
                                            data-width="100%"
                                            required
                                        >
                                            <option selected disabled value="">
                                                {{ __('Select Measurement Type') }}
                                            </option>

                                            @foreach ($measurementTypes as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                </div>

                                <div class="form-input w-100 col-12">
                                    <label>
                                        {{ __('Measurement Value') }}
                                        <input name="measurement_value"
                                            type="number"
                                            min="1"
                                            max="999999.99"
                                            id="measurement-value"
                                            value="{{ old('measurement_value', $member->measurement_value) }}"
                                            placeholder="@lang('Measurement Value')"
                                        >
                                    </label>
                                </div>

                                <div class="d-flex justify-content-end align-items-end w-100 flex-wrap">
                                    <button type="reset" class="nav-btn bg-red color-red mr-3">
                                        {{ __('Reset') }}
                                    </button>

                                    <button type="button" class="nav-btn bg-blue color-blue" id="save-measurement">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    @include('admin.members.includes.measurement_list')
    @include('admin.members.includes.edit_measurement_modal')
    @include('admin.members.includes.edit_measurement_list')
@endsection

@push('scripts')
    <script src="https://unpkg.com/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>

    <script>
        var measurementTypes = @json($measurementTypes);
        var memberMeasurements = @json($memberMeasurements);

        $(function() {
            flatpickr(".measurement-date", {
                defaultDate: "today",
                altInput: true,
                disableMobile: true,
                altFormat: "d-m-Y"
            });

            for (const typeKey in measurementTypes) {
                var chartDataX = [];
                var chartDataY = [];
                if (memberMeasurements[typeKey][0]) {
                    var measurement = memberMeasurements[typeKey];

                    $(measurement).each(function(index) {
                        chartDataX.push(measurement[index].measurement_date)
                        chartDataY.push(parseFloat(measurement[index].measurement_value))
                    });

                    const measurementChart = document.getElementById('measurement-charts-' + typeKey).getContext('2d');

                    window['measurementChart'+typeKey] = new Chart(measurementChart, {
                        type: 'line',
                        data: {
                            labels: chartDataX,
                            datasets: [{
                                label: 'Measurements',
                                data: chartDataY,
                                backgroundColor: '#0d80f8',
                                borderColor: '#0d80f8',
                            }],
                        },
                        options: {
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'bottom',
                                },
                            },
                        },
                    });
                }
            }

            $('#save-measurement').click(function () {
                $('#measurement-error').addClass('d-none');

                $.ajax({
                    method: "POST",
                    url: "{{ route('admin.member-measurement.store') }}",
                    data: $('form[name="measurement-form"]').serialize(),
                    success: function(response) {
                        location.reload();

                        new PNotify({
                            text: response.message,
                            styling: "bootstrap3",
                            type: 'success',
                        });
                    }, error: function (xhr) {
                        $('#measurement-error').empty();

                        $.each(xhr.responseJSON.errors, function (key, value) {
                            $('#measurement-error').append('<li>' + value + '</li>');
                        });

                        $('#measurement-error').removeClass('d-none');
                    },
                });
            })

            $('.update-measurement').click(function () {
                var formData = $('form[name="measurement-form-edit"]').serialize();

                $.ajax({
                    method: "POST",
                    url: "{{ route('admin.member-measurement.update') }}",
                    data: formData,
                    success: function(response){
                        new PNotify({
                            text: response.message,
                            styling: "bootstrap3",
                            type: 'success',
                            icon: ''
                        });

                        location.reload();
                    },
                    error: function (xhr) {
                        $('#measurement-edit-error').empty();

                        $.each(xhr.responseJSON.errors, function (key, value) {
                            $('#measurement-edit-error').append('<li>' + value + '</li>');
                        });

                        $('#measurement-edit-error').removeClass('d-none');
                    },
                });
            })
        });

        function measurementEdit(id, date, value, type){
            $('.measurement-table').hide();
            $('.measurement-form-edit').show();

            $('#back-arrow').toggleClass('d-none');

            $('form[name="measurement-form-edit"] input[name="id"]').val(id);
            $('form[name="measurement-form-edit"] input[name="member_id"]').val("{{ $member->id }}");
            $('form[name="measurement-form-edit"] input[name="measurement_date"]').flatpickr({
                defaultDate: date,
                altInput: true,
                disableMobile: true,
                altFormat: "d-m-Y"
            });
            $('form[name="measurement-form-edit"] input[name="measurement_value"]').val(value);
            $('select[name=measurement_type]').val(type);
            $('.selectpicker').selectpicker('refresh')
        }

        function measurementDelete(id){
            if (! confirm("Are you sure ?")) { return false; }

            $.ajax({
                method: "POST",
                url: "{{ route('admin.member-measurement.delete') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                }, success: function(response){
                    location.reload();
                }
            });
        }

        // Open Model and fetch all data related measurement
        function listMeasurements(key) {
            var formData = {
                "_token": "{{ csrf_token() }}",
                "member_id": "{{ $member->id }}",
                "measurement_type": key ,
            }

            $.ajax({
                method: "POST",
                url: "{{ route('admin.member-measurement.list') }}",
                data: formData,
                success: function(response){
                    $('#measurement-modal').appendTo("body").modal('show');
                    $('.measurement-form-edit').hide();
                    $('.measurement-table tbody').empty();

                    response.data.member_measurements.forEach(function(data) {
                        var measurementRowTemplate = $('#member-measurement-row').html();

                        $('.measurement-table').show();
                        $('.measurement-table tbody').append(measurementRowTemplate);

                        var measurementRow = $('.measurement-table tbody tr').last();

                        measurementRow.find('.u-id').append(data.id);
                        measurementRow.find('.u-date').append(data.measurement_date);
                        measurementRow.find('.u-value').append(data.measurement_value);
                        measurementRow.find('.measurement-edit').attr('onclick', `measurementEdit(
                            `+data.id +`,
                            \'`+ data.measurement_date +`\',
                            `+data.measurement_value+`,
                            `+data.measurement_type+`
                            );`);
                        measurementRow.find('.measurement-delete').attr('onclick', `measurementDelete(`+data.id+`);`);
                    });
                },
                error: function (xhr) {
                },
            });
        }

        function backToMeasurementList() {
            $('.measurement-form-edit').hide();
            $('.measurement-table').show();
            $('#back-arrow').toggleClass('d-none');
        }
    </script>
@endpush
