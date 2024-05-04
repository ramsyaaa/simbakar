<!doctype html>
<html lang="en">
    @include('admin.partials.head')
    <body class="  ">
        <!-- loader Start -->
        <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body">
                <img src="../assets/images/loader.webp" alt="loader" class="light-loader img-fluid w-25" width="200" height="200">
            </div>
        </div>
        </div>
        <!-- loader END -->
        @include('admin.partials.left-sidebar')
        <main class="main-content">
            <div class="position-relative ">
            @include('admin.partials.header')
            
            @yield('content')
               
               
                
            </div>
            </div>
            @include('admin.partials.footer')
        </main>
        @include('admin.partials.right-sidebar')
        @include('admin.partials.scripts')
    @include('sweetalert::alert')

       </body>
</html>
