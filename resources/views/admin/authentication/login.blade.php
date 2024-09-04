@include("admin/dash_cut/login_header")

<body class="account-pages">
    <!-- Begin page -->
    <div class="accountbg" style="background: url('{{ asset('dashboard_assets/images/login-wallpaper.jpg') }}');background-size: cover;background-position: center;height: 100vh;"></div>
        <div class="account-pages my-2 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-4">
                        <div class="card overflow-hidden" style="background-color: #3b383854 !important;">
                            <div class="bg-primary" style="background-color: #d91c10 !important;">
                                <div class="text-primary text-center p-4">
                                    <h5 class="text-dark font-size-20" style="color:#fff !important;">Welcome Back !</h5>
                                    <p class="text-dark-50" style="color:#fff !important;">Sign in to continue to {{ app_name() }}.</p>
                                    <a href="{{ url('/') }}" class="logo logo-admin" style="border-bottom: 2px solid #ebc1fd;">
                                        <img src="{{ get_icon() }}" height="75" alt="logo">
                                    </a>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                <div class="p-3">
                                    @if(Session::has("msg"))
                                    <!-- <h5 class="font-size-20" style="color:red;text-align:center;">{{Session::get("msg")}}</h5> -->
                                    <div class="alert alert-danger alert-dismissible fade show mb-0 mt-3" role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <strong>Oh snap!</strong> {{Session::get("msg")}}.
                                    </div>
                                    @endif
                                    <form class="mt-4" action="{{url('/checkuser')}}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label" style="color:#fff !important;" for="email">Email</label>
                                            <input type="text" name="email" class="form-control" id="email" placeholder="Enter email">
                                        </div>

                                        <div class="mb-3 password-container">
                                            <label class="form-label" style="color:#fff !important;" for="userpassword">Password</label>
                                            <input type="password" name="password" class="form-control password-new-field" id="userpassword" placeholder="Enter password">
                                            <span class="toggle-password" onclick="togglePassword(this)"><i class="fas fa-eye"></i></span>
                                        </div>

                                        <div class="mb-3 row">
                                            <div class="col-sm-6">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="customControlInline" name="remember" id="remember">
                                                    <label class="form-check-label" style="color:#fff !important;" for="customControlInline">Remember me</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 text-end">
                                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit" style="background:transparent linear-gradient(103deg, #38a4f8 0%, #225be5 100%) 0% 0% no-repeat padding-box; border:none !important;">
                                                    Log In
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                    <div class="mt-5 text-center" style="position: relative;color:#fff !important;">
                                        <!-- <p>Don't have an account ? <a href="pages-register.html" class="fw-medium text-primary"> Signup now </a> </p> -->
                                        {{ copyright() }}. Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="https://codeofdolphins.com/"><b>Code of Dolphins</b></a>
                                    </div>

                                </div>
                            </div>

                        </div>



                    </div>
                </div>
            </div>
        </div>

@include("admin/dash_cut/login_footer")