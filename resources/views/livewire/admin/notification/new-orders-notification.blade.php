<div data-kt-menu-trigger="click" id="order-notification-section" data-kt-menu-placement="bottom-end" class="menu-item menu-lg-down-accordion me-lg-1">

    <div class="menu-link py-3">


        @if ($notifications->count() !== 0)

        <div class="menu-title me-4"><span style="height:10px;width:10px" class="bullet bullet-dot bg-success   animation-blink"></span></div>

        @endif



        <div class="menu-title">

            {{ __('messages.orders_new') }}

            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 10H13V11C13 11.6 12.6 12 12 12C11.4 12 11 11.6 11 11V10H3C2.4 10 2 10.4 2 11V13H22V11C22 10.4 21.6 10 21 10Z" fill="currentColor"/>
                <path opacity="0.3" d="M12 12C11.4 12 11 11.6 11 11V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V11C13 11.6 12.6 12 12 12Z" fill="currentColor"/>
                <path opacity="0.3" d="M18.1 21H5.9C5.4 21 4.9 20.6 4.8 20.1L3 13H21L19.2 20.1C19.1 20.6 18.6 21 18.1 21ZM13 18V15C13 14.4 12.6 14 12 14C11.4 14 11 14.4 11 15V18C11 18.6 11.4 19 12 19C12.6 19 13 18.6 13 18ZM17 18V15C17 14.4 16.6 14 16 14C15.4 14 15 14.4 15 15V18C15 18.6 15.4 19 16 19C16.6 19 17 18.6 17 18ZM9 18V15C9 14.4 8.6 14 8 14C7.4 14 7 14.4 7 15V18C7 18.6 7.4 19 8 19C8.6 19 9 18.6 9 18Z" fill="currentColor"/>
            </svg>

        </div>


        <div class="menu-title ms-4">
           {{ $notifications->count() !== 0 ? $notifications->count() : '0' }}
        </div>

        <div class="menu-arrow d-lg-none"></div>

    </div>

    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown w-100 w-lg-600px p-5 p-lg-5">
        <div class="row" data-kt-menu-dismiss="true">

            <div class="col border-left-lg-1">
                <div class="menu-inline menu-column menu-active-bg">

                     @if ( $notifications->count() !== 0)
                        @foreach ( $notifications as $notification)
                            <div class="menu-item bg-light-info my-2">
                                <p class="mx-2 my-2">
                                  کاربر   {{ App\Models\User::find($notification['data']['user_id'])->name  }}
                                  شماره سفارش  {{ $notification['data']['order_id']  }}
                                </p>
                            </div>
                        @endforeach
                    @else
                        <div class="menu-item">
                            {{ __('messages.no_new_messages') }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
