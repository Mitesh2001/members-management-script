@extends('admin.layouts.app', ['page' => 'payments'])

@section('title', __('Add New Payments'))

@section('content')
    <div class="main-content">
        @include('admin.payments.form', [
            'route' => route('admin.payments.store'),
            'method' => '',
        ])
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#member-id').on('change', function () {
                $.ajax({
                    method: "POST",
                    url: "{{ route('admin.member.detail') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": $('#member-id :selected').val(),
                    },
                    success: function(response) {
                        $('.new-validity-date-display').val(response.newValidityDate);
                        $('.new-validity-date').prop("checked", false);
                        $('.new-validity-date-display').closest('.form-input').addClass('d-none')
                        $('.membership-plan').parent('label').parent('.form-input').removeClass('d-none')

                        if (response.member.membership_plan) {
                            $('.membership-plan').val(response.member.membership_plan.name);
                            $('form [name=amount]').val(response.member.membership_plan.price);
                        } else {
                            $('.membership-plan').val("{{ __('Membership Plan not selected') }}");
                            $('form [name=amount]').val('');
                        }

                        $('.membership-validity-date').parent('label').parent('.form-input').removeClass('d-none');

                        if (response.member.validity_date) {
                            var date = new Date(response.member.validity_date);
                            $('.membership-validity-date').val(date.getDate() + "-" + (date.getMonth()+1) +"-"+date.getFullYear());
                        } else {
                            $('.membership-validity-date').val("{{ __('validity Date not set') }}");
                        }

                        if (response.member.membership_plan && response.member.validity_date) {
                            $('.new-validity-date').closest('.form-input').removeClass('d-none');
                        } else {
                            $('.new-validity-date').closest('.form-input').addClass('d-none');
                        }
                    }
                });
            });

            $('.new-validity-date').on('change', function() {
                if (this.checked) {
                    $('.new-validity-date-display').closest('.form-input').removeClass('d-none')
                } else {
                    $('.new-validity-date-display').closest('.form-input').addClass('d-none')
                }
            });
        });
    </script>
@endpush
