<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Aussie Farm Home</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="/css/styles.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/21.2.5/css/dx.light.css" rel="stylesheet" />

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <!-- DevExtreme library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/21.2.5/js/dx.all.js"></script>
        <!-- DevExpress.AspNet.Data -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme-aspnet-data/2.8.6/dx.aspnet.data.min.js"></script>
    </head>
    <body class="sb-nav">
        <nav class="sb-topnav navbar navbar-light bg-light">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="/">Aussie Farm</a>
            <!-- Sidebar Toggle-->
            {{-- <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button> --}}
        </nav>
        <div id="layoutSidenav p-auto">
            {{-- @include('template.sidebar') --}}
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
        
        <script src="/js/scripts.js"></script>
        
        @stack('scripts')

    </body>
</html>
