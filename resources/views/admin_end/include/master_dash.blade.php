<!DOCTYPE html>
<html direction="rtl" dir="rtl" style="direction: rtl">
<head>
    <base href="">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('dash_page_title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin_end.include.header_styles')
    @stack('dash_custom_style')
</head>
<body id="kt_body"
      class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed"
      style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
<div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
        @include('admin_end.include.sidebar')
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            @include('admin_end.include.header')
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            {{--  @include('admin_end.include.breadcrumb')--}}
                @include('admin_end.include.header_toolbar')
                <div class="post" id="kt_post">
                    <!--begin::main container------------------------------------------------------>
                @yield('dash_main_content')
                <!--end::main container------------------------------------------------------>
                </div>
            </div>
            <!--begin::Footer------------------------------------------------------------------->
        @include('admin_end.include.footer')
        <!--end::Footer---------------------------------------------------------------------------->
        </div>
    </div>
</div>
@include( 'admin_end.include.footer_scripts')
@include( 'admin_end.include.alert.delete_confirm',['className'=> 'delete-item'])
@include( 'admin_end.include.alert.alert_response')
@stack('dash_custom_script')
</body>
</html>
