<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.title-meta')
    @include('layouts.head')
</head>

@section('body')

    <body>
    @show

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    @include('layouts.right-sidebar')
    <!-- /Right-bar -->

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')

    <!-- Center Modal example -->
    <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="/changepassword" method="POST">
                    @csrf
                    <div class="modal-header">
                        <i class="dripicons-warning p-2"></i>
                        <h5 class="modal-title">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <label for="code" class="form-label col-form-label">Password saat ini</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="password" id="oldpass" name="oldpass"
                                    placeholder="masukkan password saat ini" autocomplete="on" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="code" class="form-label col-form-label">Password baru</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="password" id="newpass" name="newpass"
                                    placeholder="masukkan password baru" minlength="6" autocomplete="on" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="code" class="form-label col-form-label">Konfirmasi Password baru</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="password" id="confnewpass" name="confnewpass"
                                    placeholder="konfirmasi password baru" minlength="6" autocomplete="on" required>
                                    <span id='message'></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                        <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <script>
        $('#newpass, #confnewpass').on('keyup', function() {
            if ($('#newpass').val() == $('#confnewpass').val()) {
                $('#message').html('Password Konfirmasi Cocok').css('color', 'green');
            } else
                $('#message').html('Password Konfirmasi Tidak Cocok').css('color', 'red');
        });
    </script>
    
</body>

</html>
