<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keyword" content="" />
    <meta name="author" content="flexilecode" />
    <title>Duralux || Dashboard</title>
    
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('template/assets/images/favicon.ico') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/vendors/css/vendors.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/vendors/css/daterangepicker.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/css/theme.min.css') }}" />
</head>

<body>
    
    @include('layouts.partials.sidebar')

    @include('layouts.partials.header')

    @include('layouts.partials.themecustom')

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-content">
                
                @yield('content')
                
            </div>
        </div>
        
        @include('layouts.partials.footer')
        
    </main>

    <script src="{{ asset('template/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('template/assets/vendors/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('template/assets/vendors/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('template/assets/vendors/js/circle-progress.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/dashboard-init.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/theme-customizer-init.min.js') }}"></script>
</body>

</html>