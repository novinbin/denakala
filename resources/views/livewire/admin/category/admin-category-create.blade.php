<div>
    @section('dash_page_title')
        {{ __('messages.categories') }}
    @endsection
    {{--@section('breadcrumb')
         {{ Breadcrumbs::render('admin.category.index') }}
     @endsection--}}
    <div class="container-fluid">


        <div class="row d-flex justify-content-start my-4 bg-white">
            <div class="col-lg-4 col-md-4 col  my-5  border-bottom title-add-to-stock">
                <div class="alert my-4">
                    <h3> {{ __('messages.base_categories') }}</h3>
                </div>
            </div>
        </div>

        <div class="row d-flex my-4 bg-white">

            <form wire:submit="store">

                <div class="row  py-2 bg-white rounded">
                    <div class="col-sm-4">

                        <div class="mb-3 mt-3">
                            <label for="title" class="form-label">عنوان دسته بندی</label>
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
                                <span class="text-danger ">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-4">

                        <div class=" mb-3 mt-3">
                            <label for="status" class="form-label">وضعیت دسته بندی</label>
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

                        {{-- <div class="mb-3 mt-3">
                             <label for="parent" class="form-label">انتخاب دسته بندی والد</label>
                             <select class="form-control" wire:model="parent" id="parent">
                                 <option value="null">فاقد دسته بندی</option>
                                 @foreach ($categories as $item)
                                     <option value="{{ $item->id }}">{{ $item->title }}</option>
                                 @endforeach
                             </select>
                         </div>--}}

                    </div>

                    <div class="mb-3 mt-3">
                        <button class="btn btn-success" type="submit">
                            {{ __('messages.save') }}
                        </button>
                    </div>

                </div>

            </form>


        </div>


        <div class="row d-flex justify-content-center search-category-section">
            <div class="col">
                <div class="mb-3 mt-3">
                    <input wire:model.live.debounce.500ms="search" placeholder="{{ __('messages.search') }}"
                           type="text" class="form-control" id="search">
                </div>
            </div>
        </div>

        <div class="row  category-list bg-white overflow-auto">
            <div class="my-5">
                <table class="table table-striped table-responsive">
                    <thead class="border-bottom-3 border-top-3">
                    <tr class="text-center">
                        <th>{{ __('messages.id') }} </th>
                        <th>{{ __('messages.name')}}</th>
                        {{--<th>{{ __('messages.category_parent')}}</th>--}}
                        <th>{{ __('messages.sub_categories') }}</th>
                        <th>{{ __('messages.status')}}</th>
                        <th>{{ __('messages.operation')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr class="text-center">
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->title }}</td>
                            {{--<td>{{ $category->parent_id ? $category->parent->title_persian : __('messages.main_category') }}</td>--}}
                            <td>
                                    <a href="{{ route('admin.sub.category.create',$category->id) }}" class="mx-4">
                                        <i class="">{{ __('messages.sub_categories') }}</i>
                                    </a>
                            </td>
                            <td>
                                <a href="#" wire:click.prevent="changeState({{ $category->id }})"
                                   class="mx-4 btn btn-sm {{ $category->status === 0 ? 'btn-danger' : 'btn-success' }} btn-sm">
                                    {{ $category->status === 0 ? __('messages.deactivate') : __('messages.active') }}
                                </a>
                            </td>

                            {{--  <td><a href="#" wire:click.prevent="detachCategory({{ $category->id }})" class="mx-4">
                                      <i class="fa fa-unlink"></i>
                                  </a>
                              </td>--}}
                            <td>
                                <a href="{{ route('admin.category.edit',['id'=>$category->id]) }}" class="mx-4">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="border border-0 bg-transparent"
                                        wire:click="deleteConfirmation({{ $category->id }})">
                                    <i class="fas fa-trash "></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>


        <div class="row d-flex justify-content-center bg-white my-4">
            <div class="col-lg-2 col-md-2 my-2 pt-2 pb-2 ">
                {{ $categories->links(data: ['scrollTo' => false]) }}
            </div>
        </div>


        {{-- <div class="col-lg-8 col-md-9 col-sm-6  category-list">

             @if($category_tree->isEmpty())
                 <div
                     class="alert d-flex justify-content-center border border-1 border-secondary bg-white no-categories">
                     <p class="text-center my-auto">دسته بندی وجود ندارد.</p>
                 </div>
             @else
                 <div class="category-content">
                     @foreach($category_tree as $category)
                         <div id="accordion-{{$category->id}}">
                             <div class="card mt-4">
                                 <div class="card-header item-category bg-secondary">
                                     <div class="item-category-title d-flex justify-content-center  align-items-center">
                                         <a class="btn my-auto text-black" href="#collapse{{ $category->id }}" data-bs-toggle="collapse"><h6>{{ $category->title_persian }}</h6></a>
                                     </div>
                                     <div class="item-category-actions d-flex justify-content-center  align-items-center">
                                         @if($category->parent_id == null)
                                             <a href="javascript:void(0)" class="alert {{ $category->has_spec ? 'alert-success' : ''}}  me-2">  {{ $category->has_spec == '1' ? 'دارای مشخصات فنی' : '' }} </a>
                                             <a href="javascript:void(0)" class="alert {{ $category->has_brand ? 'alert-success' : ''}}  me-2">  {{ $category->has_brand == '1' ? 'دارای برند' : '' }} </a>
                                             <a href="{{ route('admin.category.edit',['id'=>$category->id]) }}" class="mx-4 my-2"><i class="fas fa-edit"></i></a>
                                             <a href="#" wire:click.prevent="deleteConfirmation({{ $category->id }})"><i class="fas fa-trash"></i></a>

                                         @else
                                             <a href="javascript:void(0)" class="alert {{ $category->has_spec ? 'alert-success' : '' }}  me-2">  {{ $category->has_spec == '1' ? 'دارای مشخصات فنی' : '' }} </a>
                                             <a href="javascript:void(0)" class="alert {{ $category->has_brand ? 'alert-success' : ''}}  me-2">  {{ $category->has_brand == '1' ? 'دارای برند' : '' }} </a>
                                             <a href="{{ route('admin.category.edit',['id'=>$category->id]) }}" class="mx-4"><i class="fas fa-edit"></i></a>
                                             <a href="#" wire:click.prevent="detachCategory({{ $category->id }})" class="mx-4"><i class="fa fa-unlink"></i></a>
                                             <a href="#" wire:click.prevent="deleteConfirmation({{ $category->id }})"><i class="fas fa-trash"></i></a>
                                         @endif
                                     </div>
                                 </div>
                             </div>
                             <div class="collapse show" id="collapse{{$category->id}}">
                                 @if(!$category->chlidren)
                                     @include('dash.category.child_category',['child'=>$category->children])
                                 @endif
                             </div>
                         </div>
                     @endforeach
                 </div>
             @endif
         </div>--}}


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
                    // Livewire.emit('deleteConfirmed')
                    // Livewire.on('deleteConfirmed')
                    Livewire.dispatch('deleteConfirmed')
                }
            });
        })
    </script>
    <script>
        /* const Toast = Swal.mixin({
             toast: true,
             position: 'top',
             showConfirmButton: false,
             showCloseButton: true,
             timer: 5000,
             timerProgressBar: true,
             // didOpen: (toast) => {
             //     toast.addEventListener('mouseenter', Swal.stopTimer)
             //     toast.addEventListener('mouseleave', Swal.resumeTimer)
             // }
         });*/

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
