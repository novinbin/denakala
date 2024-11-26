<div>
    @section('dash_page_title')
        ویرایش دسته بندی
    @endsection
   {{-- @section('breadcrumb')
        {{ Breadcrumbs::render('admin.category.edit',$category_title) }}
    @endsection--}}
    <div class="container-fluid">


            <form wire:submit="update">

                <div class="row  py-2 bg-white rounded">
                    <div class="col-sm-4">


                        <div class=" mb-3 mt-3">
                            <label for="title" class="form-label">عنوان دسته بندی </label>
                            <input type="text" wire:model="title" class="form-control" id="title">
                            @error('title')
                            <div class="mt-3">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>


                        <div class=" mb-3 mt-3">
                            <label for="show_in_menu" class="form-label">نمایش در منو</label>
                            <select class="form-control" wire:model="show_in_menu" id="show_in_menu">
                                <option>انتخاب کنید</option>
                                <option value="0">{{ __('messages.not_show') }}</option>
                                <option value="1">{{ __('messages.show') }}</option>
                            </select>
                            @error('show_in_menu')
                            <div class="mt-3">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>


                     </div>


                     <div class="col-sm-4">

                        <div class="mb-3 mt-3">
                            <label for="status" class="form-label">وضعیت دسته بندی</label>
                            <select class="form-control" wire:model="status" id="status">
                                <option>انتخاب کنید</option>
                                <option value="0">{{ __('messages.deactivate') }}</option>
                                <option value="1">{{ __('messages.active') }}</option>
                            </select>
                            @error('status')
                            <div class="mt-3">
                                <span class="text-danger">{{ $message}}</span>
                            </div>
                            @enderror
                        </div>


                       {{-- <div class=" mb-3 mt-3">
                            <label for="parent" class="form-label">انتخاب دسته بندی والد</label>
                            <select class="form-control" wire:model="parent" id="parent">
                                <option value="null">فاقد دسته بندی</option>
                                @foreach($categories as $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>--}}
                    </div>


                    <div class="mb-3 mt-3">
                        <button class="btn btn-success" type="submit">
                            {{ __('messages.update') }}
                        </button>
                        <a href="{{ route('admin.category.create') }}" class="btn btn-primary">لیست دسته بندی ها</a>
                    </div>


                </div>
            </form>


    </div>
</div>
@push('dash_custom_scripts')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        window.addEventListener('show-result', ({detail: {type, message}}) => {
            Toast.fire({
                icon: type,
                title: message
            })
        })
        @if(session()->has('warning'))
        Toast.fire({
            icon: 'warning',
            title: '{{ session()->get('warning') }}'
        })
        @elseif(session()->has('success'))
        Toast.fire({
            icon: 'success',
            title: '{{ session()->get('success') }}'
        })
        @endif
    </script>
@endpush

