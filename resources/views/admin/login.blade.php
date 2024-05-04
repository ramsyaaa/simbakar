
<!doctype html>
<html lang="en" dir="ltr">
    @include('admin.partials.head')
  <body class=" ">
    <!-- loader Start -->
    <div id="loading">
      <div class="loader simple-loader">
          <div class="loader-body">
              <img src="../../assets/images/loader.webp" alt="loader" class="light-loader img-fluid w-25" width="200" height="200">
          </div>
      </div>
    </div>
    <!-- loader END -->
    <div class="wrapper">
    <section class="iq-auth-page" style="background: url(../../assets/images/dashboard/top-image.jpg); background-size: cover;background-repeat: no-repeat;">
        <div class="row d-flex align-items-center justify-content-center vh-100 w-100">
            <div class="col-md-4 col-xl-4">
                <div class="card p-4">
                    <div class="card-body ">
                        <img src="{{asset('assets/images/logo-ip.png')}}" alt="" width="250" class="pb-5 d-block mx-auto my-auto">
                        <h3 class="text-center">Log In</h3>
                        @if (\Session::has('success'))
                            <div class="alert alert-success">
                                {!! \Session::get('success') !!}
                            </div>
                        @endif

                        @if (\Session::has('danger'))
                            <div class="alert alert-danger">
                                {!! \Session::get('danger') !!}
                            </div>
                        @endif
                        <form action="{{route('authenticate')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="email-id">Email address</label>
                                <input type="email" class="form-control mb-0" id="email-id" placeholder="Enter email" name="email">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" class="form-control mb-0" id="password" placeholder="Enter password" name="password">
                            </div>
                            <div class="text-center pb-3">
                                <button type="submit" class="btn btn-primary">Log in</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
    @include('admin.partials.scripts')
      </body>
    @include('sweetalert::alert')

</html>
