<div>
    @section('dash_page_title')
        {{ __('messages.packages_management') }}
    @endsection

    <div class="container-fluid">


        <div class="row d-flex justify-content-start my-4 bg-white">
            <div class="col-lg-4 col-md-4 col  my-5  border-bottom title-add-to-stock">
                <div class="alert my-4">
                    <h3> {{ __('messages.packages_management') }}</h3>
                </div>
            </div>
        </div>

        <div class="row d-flex my-4 bg-white">
            <form wire:submit="store">
                <div class="row  py-2 bg-white rounded">

                    <div class="d-flex flex-column">

                        <div class="col-sm-4 mb-3 mt-3">
                            <label for="title" class="form-label">عنوان</label>
                            <input type="text" wire:model="title" class="form-control" id="title">
                            @error('title')
                            <div class="mt-3">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>

                        <div class="col-sm-4 mb-3 mt-3">
                            <label for="show_in_menu" class="form-label">توضیحات</label>
                            <textarea class="form-control" rows="5" wire:model="description"></textarea>
                            @error('description')
                            <div class="mt-3">
                                <span class="text-danger ">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>

                    </div>
                    {{--<div class="col-sm-4">
                        <div class=" mb-3 mt-3">
                            <label for="status" class="form-label">وضعیت</label>
                            <select class="form-control" wire:model="status" id="status">
                                <option>انتخاب کنید</option>
                                <option value="0">{{ __('messages.deactivate') }}</option>
                                <option value="1">{{ __('messages.active') }}</option>
                            </select>

                            @error('status')
                            <div class="mt-3">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                    </div>--}}

                    <div class="mb-3 mt-3">
                        <button class="btn btn-success" type="submit">
                            {{ __('messages.save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>


        <div class="row  category-list bg-white overflow-auto">
            <div class="my-5">
                <table class="table table-striped table-responsive">
                    <thead class="border-bottom-3 border-top-3">
                    <tr class="text-center">
                        <th>{{ __('messages.id') }} </th>
                        <th>{{ __('messages.name')}}</th>
                        <th>{{ __('messages.description')}}</th>
                        <th>{{ __('messages.operation')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($subscriptions as $sub)
                        <tr class="text-center">
                            <td>{{ $sub->id }}</td>
                            <td>{{ $sub->title }}</td>
                            <td>{{ $sub->description }}</td>
                            <td>
                                <a wire:click.prevent="edit({{ $sub->id }})" href="javascript:void(0)" class="mx-4">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.packages.items',$sub->id)  }}"  class="mx-4">
                                    {{ __('messages.items') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
            position: 'center',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
        })

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
