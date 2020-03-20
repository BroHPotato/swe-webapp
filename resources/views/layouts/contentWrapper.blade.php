<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
        @auth
            @include('layouts.topbar')
        @endauth

        <!-- Begin Page Content -->
        <div class="container-fluid">
            @yield('content')
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span><i class="fas fa-code"></i> with <i class="text-danger far fa-heart"></i>
                    by <a href="https://github.com/RedRoundRobin">Red Round Robin</a> <i class="fas fa-dove"></i>
                    - &copy; 2020</span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

