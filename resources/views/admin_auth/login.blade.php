@extends('admin_auth.auth_master')
@section('auth_admin_title')
    {{ __('messages.admin_login') }}
@endsection
@section('main_content')
    <div class="container">

        <div class="row d-flex justify-content-center">
            <div class="col-lg-8 col-md-10 my-2 alert-dive">
                @include('admin_auth.alert')
            </div>
        </div>

        <div class="row">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                {{-- <img alt="Logo" src="#" class="logo-login my-5"/>--}}
                <h3 class="my-5 admin-logo-login">{{ __('messages.site_name') }}</h3>
                <div class="w-lg-500px bg-white rounded shadow-sm p-10 p-lg-15 mx-auto admin-login-form">

                    <form action="{{ route('admin.login') }}" method="post" class="form w-100" novalidate="novalidate">
                        @csrf

                        <div class="text-center mb-10">
                            <h1 class="text-dark mb-3">ورود به پنل مدیریت</h1>
                        </div>

                        <div class="fv-row mb-10">
                            <label class="form-label fs-6 fw-bolder text-dark" for="email">ایمیل</label>
                            <input class="form-control form-control-lg form-control-solid"
                                   id="email"
                                   type="text"
                                   dir="ltr"
                                   style="direction: ltr"
                                   name="email"/>
                            @error('email')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="fv-row mb-10">
                            <label class="form-label fs-6 fw-bolder text-dark" for="password">رمز عبور</label>
                            <input class="form-control form-control-lg form-control-solid"
                                   id="password"
                                   type="password"
                                   dir="ltr"
                                   style="direction: ltr"
                                   name="password"/>
                            @error('password')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-10 px-md-10">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember"> من را به خاطر بسپار !
                            </label>
                        </div>


                        <div class="text-center">
                            <button type="submit" id="login-btn" class="btn btn-lg btn-primary w-100 mb-5">

                                <span class="indicator-label" id="login-text-element">ادامه</span>

                                <div class="spinner-border d-none" id="spinnder-element" style="border-colore:rgba(255, 255, 255, 0.2)" role="status">
                                    <span class="sr-only"></span>
                                </div>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('admin_custom_scripts')
<script>

    $(document).ready(function(){
       $("#login-btn").click(function(){
            $("#login-text-element").addClass('d-none');
            $("#spinnder-element").removeClass('d-none');
        });
    });

</script>
@endpush
