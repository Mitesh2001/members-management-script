<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>{{ config('app.name') }} - {{__('Payment Invoice')}}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
</head>
<body onload="window.print();">
    <div class="container mt-5">
        <section class="invoice">
            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                        <i class="fa fa-globe"></i>
                        {{ config('app.name') }}

                        <small class="float-right">
                            {{ __('Date') }}: {{ date("d-m-Y", strtotime($payment->payment_date) ) }}
                        </small>
                    </h2>
                </div>
            </div>

            <div class="row invoice-info">
                <div class="col-8 invoice-col">
                    {{ __('From') }}
                    <address>
                        <strong>{{ config('app.name') }}</strong>
                    </address>

                    <b>{{ __('Invoice') }} #{{ $payment->id }}</b><br>
                </div>

                <div class="col-4 invoice-col">
                    {{ __('To') }},
                    <address>
                        <strong>{{ $member->first_name .' '. $member->last_name }}</strong><br>
                        {{ $member->address }}<br>
                        {{ __('Phone') }}: {{ $member->phone }}<br>
                        {{ __('Email') }}: {{ $member->email }}
                    </address>
                </div>
            </div>

            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Qty') }}</th>
                                <th>{{ __('New Validity Date') }}</th>
                                <th>{{ __('Payment Status') }}</th>
                                <th>{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    {{ $payment->new_validity_date ? date("d-m-Y", strtotime($payment->new_validity_date) ) : '--' }}
                                </td>
                                <td>
                                    {{ $payment->status == 1 ? 'Draft' :  ( $payment->status == 2 ? 'Open' : ( $payment->status == 3 ? 'Paid' : 'Uncollectible or Void'))}}
                                </td>
                                <td>
                                    ${{ number_format($payment->amount , 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <p class="lead">
                        {{ __('Payment Methods') }}:{{ $payment->webhook_id ? __('Online') : __('Manually') }}
                    </p>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
