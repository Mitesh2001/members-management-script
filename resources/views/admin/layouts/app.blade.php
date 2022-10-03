<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="images/favicon.png">
    <meta name="theme-color" content="#ffffff">

    <title>{{ config('app.name') }} - @yield('title')</title>

    {{--Favicon--}}
    @include('admin.layouts.include.favicon')

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.css">
    <link rel="stylesheet" href="{{ asset('css/data_table_styles.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">

    {{-- You can put page wise internal css style in styles section --}}
    @stack('styles')
</head>
<body id="top">
    <nav class="navbar navbar-expand-md navbar-light sticky-top" id="nav-main">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
            <img src="{{ asset('/images/logo.png') }}" class="nav-logo" alt="LOGO">
        </a>

        <button class="navbar-toggler"
            data-target="#navigation"
            data-control="navigation"
            data-toggle="collapse"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navigation">
            <ul class="nav navbar-nav pull-lg-right ml-auto d-flex align-items-center">
                <li class="nav-item">
                    <a class="nav-link active">
                        {{ date('l') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active">
                        {{ date('d M Y') }}
                    </a>
                </li>

                <li class="nav-item user d-flex align-items-center">
                    <span class="user-name">
                        {{ Auth::guard('admin')->user()->name }}
                    </span>

                    <div class="dropdown">
                        <a class="dropdown-toggle nav-link"
                            data-toggle="dropdown"
                            role="button"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            <span class="profile-icon">
                                {{ substr(Auth::guard('admin')->user()->name, 0, 1) }}
                            </span>
                        </a>

                        <ul class="dropdown-menu">
                            <li class="my-2">
                                <a href="{{ route('admin.change_password') }}">
                                    {{ __('Change Password') }}
                                </a>
                            </li>

                            <li class="my-2">
                                <button
                                    class="nav-btn bg-red color-red ml-2"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                >
                                    {{ __('Logout') }}
                                </button>

                                <form id="logout-form"
                                    action="{{ route('admin.logout') }}"
                                    method="post"
                                    style="display: none;"
                                >
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="page-container">
        <nav class="vertical-nav">
            <div class="sidebar">
                <div class="sidebar-nav-logo text-center">
                    <button class="nav-button">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>

                    <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
                        <img src="{{ asset('/images/logo.png') }}" class="nav-logo" alt="LOGO">
                    </a>
                </div>

                <ul class="nav-list">
                    <li {{ $page == 'dashboard' ? ' class=active' : '' }}>
                        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center">
                            <div class="nav-list-img">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <defs>
                                        <style>
                                            .cls-1 {
                                                fill: none;
                                            }
                                        </style>
                                    </defs>
                                    <title>Dashboard</title>
                                    <g id="Layer_2" data-name="Layer 2">
                                        <g id="Layer_1-2" data-name="Layer 1">
                                            <path class="cls-1" d="M0,0H24V24H0Z" />
                                            <path d="M3,13h8V3H3Zm0,8h8V15H3Zm10,0h8V11H13ZM13,3V9h8V3Z" />
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            {{ __('Dashboard') }}
                        </a>
                    </li>

                    <li {{ $page == 'members' ? ' class=active' : '' }}>
                        <a href="{{ route('admin.members.index') }}" class="d-flex align-items-center">
                            <div class="nav-list-img">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 14">
                                    <title>Members</title>
                                    <g id="Layer_2" data-name="Layer 2">
                                        <g id="Layer_1-2" data-name="Layer 1">
                                            <path
                                                d="M15,6a3,3,0,1,0-3-3A3,3,0,0,0,15,6ZM7,6A3,3,0,1,0,4,3,3,3,0,0,0,7,6ZM7,8C4.67,8,0,9.17,0,11.5V14H14V11.5C14,9.17,9.33,8,7,8Zm8,0c-.29,0-.62,0-1,.05a4.22,4.22,0,0,1,2,3.45V14h6V11.5C22,9.17,17.33,8,15,8Z" />
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            {{ __('Members') }}
                        </a>
                    </li>

                    <li {{ $page == 'membership-plans' ? ' class=active' : '' }}>
                        <a href="{{ route('admin.membership-plans.index') }}" class="d-flex align-items-center">
                            <div class="nav-list-img">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <defs>
                                        <style>
                                            .cls-1 {
                                                fill: none;
                                            }
                                        </style>
                                    </defs>
                                    <title>Membership Plans</title>
                                    <g id="Layer_2" data-name="Layer 2">
                                        <g id="Layer_1-2" data-name="Layer 1">
                                            <path class="cls-1" d="M0,0H24V24H0Z" />
                                            <path
                                                d="M20,2H4A2,2,0,0,0,2,4V15a2,2,0,0,0,2,2H8v5l4-2,4,2V17h4a2,2,0,0,0,2-2V4A2,2,0,0,0,20,2Zm0,13H4V13H20Zm0-5H4V4H20Z" />
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            {{ __('Membership Plans') }}
                        </a>
                    </li>

                    <li {{ $page == 'trainers' ? ' class=active' : '' }}>
                        <a href="{{ route('admin.trainers.index') }}" class="d-flex align-items-center">
                            <div class="nav-list-img">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <defs>
                                        <style>
                                            .cls-1 {
                                                fill: none;
                                            }
                                        </style>
                                    </defs>
                                    <title>Trainers</title>
                                    <g id="Layer_2" data-name="Layer 2">
                                        <g id="Layer_1-2" data-name="Layer 1">
                                            <g id="Bounding_Box" data-name="Bounding Box">
                                                <rect class="cls-1" width="24" height="24" />
                                            </g>
                                            <g id="Flat">
                                                <circle cx="12" cy="4" r="2" />
                                                <path
                                                    d="M15.89,8.11A3.1,3.1,0,0,0,13.53,7H11A5,5,0,0,1,6,2H4A7,7,0,0,0,9,8.71V22h2V16h2v6h2V10.05L19,14l1.41-1.41Z" />
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            {{ __('Trainers') }}
                        </a>
                    </li>

                    <li {{ $page == 'timings' ? ' class=active' : '' }}>
                        <a href="{{ route('admin.timings.index') }}" class="d-flex align-items-center">
                            <div class="nav-list-img">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <defs>
                                        <style>
                                            .cls-1 {
                                                fill: none;
                                            }
                                        </style>
                                    </defs>
                                    <title>Timings</title>
                                    <g id="Layer_2" data-name="Layer 2">
                                        <g id="Layer_1-2" data-name="Layer 1">
                                            <path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" />
                                            <path class="cls-1" d="M0,0H24V24H0Z" />
                                            <path d="M12.5,7H11v6l5.25,3.15L17,14.92l-4.5-2.67Z" />
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            {{ __('Timings') }}
                        </a>
                    </li>

                    <li {{ $page == 'payments' ? ' class=active' : '' }}>
                        <a href="{{ route('admin.payments.index') }}" class="d-flex align-items-center">
                            <div class="nav-list-img">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <defs>
                                        <style>
                                            .cls-1 {
                                                fill: none;
                                            }
                                        </style>
                                    </defs>
                                    <title>Payments</title>
                                    <g id="Layer_2" data-name="Layer 2">
                                        <g id="Layer_1-2" data-name="Layer 1">
                                            <path class="cls-1" d="M0,0H24V24H0Z" />
                                            <path d="M20,4H4A2,2,0,0,0,2,6V18a2,2,0,0,0,2,2H20a2,2,0,0,0,2-2V6A2,2,0,0,0,20,4Zm0,14H4V12H20ZM20,8H4V6H20Z" />
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            {{ __('Payments') }}
                        </a>
                    </li>

                    <li {{ $page == 'member-mail' ? ' class=active' : '' }}>
                        <a href="{{ route('admin.member-mail.index') }}" class="d-flex align-items-center">
                            <div class="nav-list-img">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <defs>
                                        <style>
                                            .cls-1 {
                                                fill: none;
                                            }
                                        </style>
                                    </defs>
                                    <title>Send Mails</title>
                                    <g id="Layer_2" data-name="Layer 2">
                                        <g id="Layer_1-2" data-name="Layer 1">
                                            <path d="M20,4H4A2,2,0,0,0,2,6V18a2,2,0,0,0,2,2H20a2,2,0,0,0,2-2V6A2,2,0,0,0,20,4Zm0,4-8,5L4,8V6l8,5,8-5Z" />
                                            <path class="cls-1" d="M0,0H24V24H0Z" />
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            {{ __('Send Mails') }}
                        </a>
                    </li>

                    <li {{ $page == 'top-referrers' ? 'class= active' : '' }}>
                        <a href="{{ route('admin.top-referrers.list') }}" class="d-flex align-items-center">
                            <div class="nav-list-img">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <defs>
                                        <style>
                                            .cls-1 {
                                                fill: none;
                                            }
                                        </style>
                                    </defs>
                                    <title>Top Referrers</title>
                                    <g id="Layer_2" data-name="Layer 2">
                                        <g id="Layer_1-2" data-name="Layer 1">
                                            <path d="M5,9.2H8V19H5ZM10.6,5h2.8V19H10.6Zm5.6,8H19v6H16.2Z" />
                                            <path class="cls-1" d="M0,0H24V24H0Z" />
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            {{ __('Top Referrers') }}
                        </a>
                    </li>

                    <li {{ $page == 'payment-report' ? 'class=active' : '' }}>
                        <a href="{{ route('admin.payments.report') }}" class="d-flex align-items-center">
                            <div class="nav-list-img">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <defs>
                                        <style>
                                            .cls-1 {
                                                fill: none;
                                            }
                                        </style>
                                    </defs>
                                    <title>Payments Report</title>
                                    <g id="Layer_2" data-name="Layer 2">
                                        <g id="Layer_1-2" data-name="Layer 1">
                                            <path d="M5,9.2H8V19H5ZM10.6,5h2.8V19H10.6Zm5.6,8H19v6H16.2Z" />
                                            <path class="cls-1" d="M0,0H24V24H0Z" />
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            {{ __('Payments Report') }}
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="main-page-container">
            <div class="section section-main-container">
                @include('admin.layouts.include.errors')

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="https://www.jqueryscript.net/demo/Bootstrap-4-Dropdown-Select-Plugin-jQuery/dist/js/bootstrap-select.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/main.js')}}"></script>

    @if (session('message'))
        <script>
            new PNotify({
                text: "{{ session('message') }}",
                styling: "bootstrap3",
                type: "{{ session('type') }}",
                icon: ''
            });
        </script>
    @endif

    <script>
        $(function () {
            $.extend(true, $.fn.dataTable.defaults, {
                 language: {
                    searchPlaceholder: "Search..."
                },
                 "oLanguage": {
                    "sSearch": "<i class='fa fa-search' aria-hidden='true'></i>",
                    "sLengthMenu": "_MENU_"
                },
                "lengthMenu": [
                    [10, 10, 25, 50],
                    ["Showing Entries", 10, 25, 50]
                ]
            });
        });
    </script>

    {{-- You can put page wise javascript in scripts section --}}
    @stack('scripts')
</body>
</html>
