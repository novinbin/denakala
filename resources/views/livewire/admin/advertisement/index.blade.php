<div>
    @section('dash_page_title')
        مدیریت اگهی ها
    @endsection
       {{-- @section('breadcrumb')
            {{ Breadcrumbs::render('admin.adv.index') }}
        @endsection--}}
    <div class="container-fluid">

        <div class="row bg-white rounded rounded-2  add-adv-section">
            <div class="col-lg-11 col-md-2 col-sm-2 py-4">
                <a href="{{ route('admin.adv.create') }}"
                   class="btn btn-primary">{{ __('messages.new_adv') }}</a>
            </div>
        </div>

        <div class="row bg-white rounded rounded-2 py-2 mt-5 search-adv-section">
            <div class="col-lg-11 col-md-2 cols-sm-2 py-2">
                <h3>{{ __('messages.search_adv') }}</h3>
            </div>
        </div>

        <div class="row bg-white">

            <div class="col-sm-3">
                <div class="mb-3">
                    <label for="title_search" class="form-label">{{ __('messages.title') }}</label>
                    <input type="text" class="form-control" wire:model.debounce.500ms="search" id="title_search">
                </div>
            </div>

            <div class="col-sm-3">
                <div class="mb-3">
                    <label for="orderBy_filter" class="form-label">{{ __('messages.orderBy') }}</label>
                    <select class="form-control" wire:model.debounce.500ms="orderBy" id="orderBy_filter">
                        <option value="id">شناسه</option>
                        <option value="title_persian">عنوان</option>
                        <option value="created_at">تاریخ ایجاد</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="mb-3">
                    <label for="orderAsc_filter" class="form-label">{{ __('messages.orderBy') }}</label>
                    <select class="form-control" wire:model.debounce.500ms="orderAsc" id="orderAsc_filter">
                        <option>{{ __('messages.choose') }}</option>
                        <option value="ASC">صعودی</option>
                        <option value="DESC">نزولی</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="mb-3">
                    <label for="paginate_filter" class="form-label">{{ __('messages.paginate') }}</label>
                    <select class="form-control" wire:model.debounce.500ms="paginate" id="paginate_filter">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="row mt-5 result-search-adv list-adverts overflow-auto">

            <table class="table py-4 table-bordered border-2 rounded-3 bg-white">
                <thead class="">
                <tr class="text-center">

                    <th class="pro-field p-4">{{ __('messages.id') }}</th>
                    <th class="p-4">{{ __('messages.image') }}</th>
                    <th class="p-4">{{ __('messages.title') }}</th>
                    <th class="pro-field status-field p-4">{{ __('messages.status') }}</th>
                    <th class="p-4">{{ __('messages.operation') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach( $adverts as $adv)
                    <tr class="text-center">
                        <td class="pro-field">{{ $adv->id }}</td>

                        <td>
                            @if( $adv->images && \Illuminate\Support\Facades\Storage::disk('public')->exists($adv->images) )
                                <img class="img-thumbnail" width="100" height="100"
                                     src="{{ asset('storage/'.$adv->images) }}" alt="adv_image">
                            @else
                                <img class="img-thumbnail" width="100" height="100"
                                     src="{{ asset('admin_assets/images/no-image-icon-23494.png') }}"
                                     alt="adv_image">
                            @endif
                        </td>
                        <td>
                            <div class="mt-3">{{ Str::limit($adv->title,50)  }}</div>
                        </td>

                        <td class="pro-field status-field">
                            <a href="javascript:void(0)" wire:click.prevent="changeState({{ $adv->id }})"
                               class="btn btn-sm  {{ $adv->status == 1 ? 'btn-success': 'btn-danger' }}">
                                {{ $adv->status == 1 ? __('messages.published')  : __('messages.unpublished') }}
                            </a>
                        </td>
                        <td>
                            <a class="mt-3" href="{{ route('admin.adv.edit',['adv'=>$adv->id]) }}">
                                <i class="mt-3 fa fa-edit"></i>
                            </a>
                            <a class="mt-3" href="javascript:void(0)" wire:click.prevent="deleteConfirmation({{ $adv->id }})">
                                <i class="mt-3 fa fa-trash"></i>
                            </a>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-lg-2">
                {{ $adverts->links() }}
            </div>
        </div>

    </div>

</div>
@push('dash_custom_script')
    <script type="text/javascript">
        window.addEventListener('show-delete-confirmation', event => {
            Swal.fire({
                title: 'آیا مطمئن هستید این ایتم حذف شود؟',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله حذف کن!',
                cancelButtonText: 'خیر',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('deleteConfirmed')
                }
            });
        })
    </script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
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
