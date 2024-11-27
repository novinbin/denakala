@extends('admin_end.include.master_dash')

@section('dash_page_title')
    {{ __('messages.edit_adv') }}
@endsection

@push('dash_custom_style')
    <link rel="stylesheet"
          href="{{ asset('admin_assets/plugins/jalalidatepicker/dist/css/persian-datepicker.min.css') }}">
@endpush

{{--@section('breadcrumb')
    {{ Breadcrumbs::render('admin.edit.product.basic', $product->title_persian) }}
@endsection--}}

@section('dash_main_content')
    <div class="container-fluid">
        <div class="mx-auto my-5 bg-white row product-create-body">
            <form action="{{ route('admin.adv.update') }}" method="post" enctype="multipart/form-data"
                  id="advertisement-form">
                @csrf

                <input type="hidden" name="adv" value="{{ $adv->id }}">

                <div class="row">
                    {{--   advertisement fields  --}}
                    <div class="col-lg-6">

                        <div class="mt-5 mb-5 col">
                            <div class="my-5">موقعیت آگهی</div>
                            <label for="province-select" class="form-label">
                                    <span style="margin-left: 10px"><i class="fa fa-star text-danger" style="font-size:10px"></i></span>استان
                            </label>
                            <select class="province-select form-select" id="province-select" name="province">
                                <option value="">{{ __('messages.choose') }}</option>
                                @foreach($provinces as $province)

                                    @if ($province->id == $adv->province_id)
                                        <option selected value="{{ $province->id }}">{{ $province->name }}</option>
                                    @else
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endif

                                @endforeach
                            </select>
                            @error('province')
                            <div class="my-5 alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="mt-5 mb-5 col">
                            <label for="city-select" class="form-label">
                                    <span style="margin-left: 10px"><i class="fa fa-star text-danger" style="font-size:10px"></i></span>شهر
                            </label>
                            <select class="city-select form-select" id="city-select" name="city">
                                @foreach($cities as $city)

                                    @if ($city->id == $adv->city_id)
                                        <option selected value="{{ $city->id }}">{{ $city->name }}</option>
                                    @else
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endif

                                @endforeach
                            </select>
                            @error('city')
                            <div class="my-5 alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="mt-5  col">
                            <label for="title" class="form-label"><span style="margin-left: 10px">
                                        <i class="fa fa-star text-danger" style="font-size:10px"></i></span>عنوان آگهی
                            </label>
                            <input type="text" class="form-control" id="title" name="title"
                                   value="{{ $adv->title }}">
                            @error('title')
                            <div class="mt-3 alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="mt-5  col">
                            <label for="description" class="mb-2 form-label">
                                    <span style="margin-left: 10px"><i class="fa fa-star text-danger"
                                                                       style="font-size:10px"></i></span>شرح آگهی
                            </label>
                            <textarea class="mt-1 form-control" rows="8" id="description"
                                      name="description">{{ $adv->description }}</textarea>
                            @error('description')
                            <div class="mt-3 alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="mt-5  col">
                            <label for="advertiser_phone" class="form-label"><span style="margin-left: 10px">
                                        <i class="fa fa-star text-danger" style="font-size:10px"></i></span>تلفن /
                                موبایل
                            </label>
                            <input type="text" class="form-control" id="advertiser_phone" name="advertiser_phone"
                                   value="{{ $adv->advertiser_phone }}">
                            @error('advertiser_phone')
                            <div class="mt-3 alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col" style="margin-top:4rem">
                            <label for="owner" class="form-label"><span style="margin-left: 10px">
                                        <i class="fa fa-star text-danger" style="font-size:10px"></i></span> نام اگهی
                                دهنده
                            </label>
                            <input type="text" class="form-control" id="owner" name="owner"
                                   value="{{ $adv->owner }}">
                            @error('owner')
                            <div class="mt-3 alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mt-5 mb-5  col">
                            <label for="keywords" class="form-label">
                                    <span style="margin-left: 10px"><i class="fa fa-star text-danger"
                                                                       style="font-size:10px"></i></span>عبارات کلیدی
                            </label>
                            <input type="hidden" name="keywords" id="keywords" value="{{ $adv->keywords }}">
                            <select class="form-select" multiple="multiple" id="product_keywords"></select>
                            @error('keywords')
                            <div class="mt-3 alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <fieldset>
                            <legend>لینک ها</legend>

                            <div class="mt-2  col">
                                <label for="website" class="form-label">وب سایت</label>
                                <input type="text" class="form-control form-control-sm" id="website" name="website"
                                       value="{{ $adv->website }}">
                                @error('website')
                                <div class="mt-3 alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mt-2  col">
                                <label for="telegram" class="form-label">تلگرام</label>
                                <input type="text" class="form-control form-control-sm" id="telegram"
                                       name="telegram" value="{{ $adv->telegram }}">
                                @error('telegram')
                                <div class="mt-3 alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mt-2  col">
                                <label for="instagram" class="form-label">اینستاگرام</label>
                                <input type="text" class="form-control form-control-sm" id="instagram"
                                       placeholder="" name="instagram" value="{{ $adv->instagram }}">
                                @error('instagram')
                                <div class="mt-3 alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mt-5  col">
                                <label for="rubika" class="form-label">روبیکا</label>
                                <input type="text" class="form-control form-control-sm" id="rubika" name="rubika"
                                       value="{{ $adv->rubika }}">
                                @error('rubika')
                                <div class="mt-3 alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mt-5  col">
                                <label for="eitaa" class="form-label">ایتا</label>
                                <input type="text" class="form-control form-control-sm" id="eitaa" name="eitaa"
                                       value="{{ $adv->eitaa }}">
                                @error('eitaa')
                                <div class="mt-3 alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </fieldset>

                    </div>
                    {{--   advertisement group  --}}
                    <div class="col-lg-6" style="height: fit-content">


                        <div class="mb-5 col" style="margin-top:2rem">

                            <label for="category-select" class="form-label">
                                    <span style="margin-left: 10px"><i class="fa fa-star text-danger" style="font-size:10px"></i></span>گروه آگهی
                            </label>

                            <div class="mt-5 col current-adv-group">
                                @if($advGroups)
                                    <div style="font-size: 1.2rem">{{ $advGroups }}</div>
                                @endif
                            </div>

                            @if($categories->isEmpty())
                                <div style="margin-top:1rem"
                                     class="bg-white  border alert d-flex justify-content-center border-1 border-secondary no-categories">
                                    <p class="my-auto text-center">{{ __('messages.there_is_no_ad_grouping') }}</p>
                                </div>
                            @else
                                <div class="category-content mt-5 py-2" style="max-height:500px;overflow-y:auto">
                                    @foreach($categories as $category)
                                        <div class="accordion mt-2 " id="accordion-{{$category->id}}">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse-{{$category->id}}"
                                                            aria-expanded="true"
                                                            aria-controls="collapseOne">
                                                        {{ $category->title }}
                                                    </button>
                                                </h2>
                                                <div id="collapse-{{$category->id}}"
                                                     class="accordion-collapse collapse"
                                                     aria-labelledby="headingOne"
                                                     data-bs-parent="#accordion-{{$category->id}}">
                                                    @if($category->hasChildren())
                                                        @include('admin_end.category.edit_child_category',['child'=> $category->children ,'adv_cat' => $adv->adv_category_id ])
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @error('advGroup')
                            <div class="my-5 alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mt-5 col">
                            <label for="address" class="form-label">آدرس</label>
                            <input type="address" class="form-control" id="address" name="address"
                                   value="{{ $adv->address }}">
                            @error('address')
                            <div class="mt-3 alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mt-5  col">
                            <label for="email" class="form-label">ایمیل</label>
                            <input type="text" class="form-control" id="email" name="email"
                                   value="{{ $adv->email }}">
                            @error('email')
                            <div class="mt-3 alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mt-5  col">
                            <label for="seo_desc" class="mb-5">توضیحات سئو</label>
                            <input type="text" class="form-control" name="seo_desc" id="seo_desc"
                                   value="{{ $adv->seo_desc }}">
                            @error('seo_desc')
                            <div class="mt-3 alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- image upload -->
                        <div class="mt-5  col">
                            <label class="mb-5">تصاویر</label>
                            <!-- upload images using dropzone js -->
                            <div class="advImages needsclick dropzone d-flex flex-wrap"
                                 style="background-color:transparent" id="document-dropzone">
                                <div class="dz-message  d-flex flex-column" id="dropzoneClick">
                                    <div class="d-flex justify-content-center">
                                        <img width="120" height="120"
                                             src="{{ asset('admin_assets/images/no-image-icon-23494.png') }}"
                                             alt="upload-image"/>
                                    </div>
                                    <div style="width: 100px">
                                        <span class="text text-wrap lh-sm">تصاویر خود را در اینجا آپلود کنید</span>
                                    </div>
                                </div>
                            </div>
                            <div class="my-2">
                                <p class="text-danger">{{ __('messages.before_uploading_images_make_sure_that_the_starred_fields_are_complete') }}</p>
                                <p>{{ __('messages.images_are_uploaded_automatically') }}</p>
                            </div>
                        </div>

                        <div class="mt-5 col">
                            @if($adv->images != null)
                                @include('admin_end.advertisement.photos' ,['photos' => $adv->images])
                            @endif
                        </div>

                    </div>

                </div>

                <div class="row">
                    {{--   advertisement fields  --}}
                    <div class="col-lg-6">
                    </div>
                    <div class="col-lg-6">
                        <!-- image gallery adv  -->
                    </div>
                </div>

                <div class="m-4 col d-flex justify-content-start">
                    <div>
                        <button class="btn btn-success" type="submit" id="login-btn">
                                <span class="indicator-label" id="login-text-element">
                                    {{ __('messages.save') }}
                                </span>
                            <span class="spinner-border spinner-border-sm d-none" id="spinnder-element" role="status"
                                  aria-hidden="true"></span>
                            <span class="d-none" id="spinnder-text">{{ __('messages.saving') }}</span>
                        </button>
                    </div>
                    <div class="ms-2">
                        <a href="{{ route('admin.adv.index') }}"
                           class="btn btn-secondary">لیست {{ __('messages.advertisements') }}</a>
                    </div>
                </div>
            </form>


        </div>
    </div>

@endsection

@push('dash_custom_script')
    <script type="text/javascript" src="{{ asset('admin_assets/plugins/dropzone/dropzone.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            let province_selected = $('.province-select').val();
            let province_id = null;
            $('.province-select').select2({
                placeholder: "{{ __('messages.choose') }}",
                data: '',
            }).on('change', function () {

                province_id = $('.province-select').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('admin.get.cities') }}',
                    method: 'GET',
                    data: {id: province_id}
                }).done(function (data) {
                    // let city_id = $( "#city-select option:selected" ).text();
                    if (data.status === 200) {
                        let cities = data['cities'];
                        $('#city-select').empty();
                        cities.map((city) => {
                            $('#city-select').append($('<option/>').val(city.id).text(city.name))
                        })
                    } else if (data.status === 404) {
                        $('#city-select').empty();
                    }
                }).fail(function (data) {
                    console.log(data['data']);
                });
            });
            $('.city-select').select2({}).on('change', function () {
                // get selected value if city dropdown change
                // let city_id = null;
                // city_id = $('.city-select').val();
                // console.log(city_id);
            });
        });
        // keywords select
        $(document).ready(function () {
            var tags_input = $('#keywords'); // go for backend
            var selected_tags = $('#product_keywords'); // user enter tags
            var default_tags = tags_input.val();
            var default_data = null;
            // for keeping old value after failed validation
            if (tags_input.val() !== null && tags_input.val().length > 0) {
                default_data = default_tags.split(',');
                //  console.log(default_data);
            }
            // select2 config
            selected_tags.select2({
                theme: 'classic',
                dir: 'rtl',
                tags: 'true',
                data: default_data,
            });
            selected_tags.children('option').attr('selected', true).trigger('change');
            // save all tags into hidden input & go for backed
            $('#advertisement-form').submit(function (event) {
                if (selected_tags.val() !== null && selected_tags.val().length > 0) {
                    var selectedSource = selected_tags.val().join(',');
                    tags_input.val(selectedSource);
                }
            })
        });
        $(document).ready(function () {
            $('#add_attribute').on('click', function () {
                var element = $(this).parent().prev().clone(true);
                $(this).before(element);
            })
            $("#login-btn").click(function () {
                $("#login-text-element").addClass('d-none');
                $("#spinnder-element").removeClass('d-none');
                $("#spinnder-text").removeClass('d-none');
            });
        })
    </script>

    <!-- dropzone initialize -->
    <script>
        let uploadedDocumentMap = {}
        Dropzone.options.documentDropzone = {
            url: '{{ route('admin.adv-save-images') }}',
            maxFilesize: 2, // MB
            maxFiles: 4,
            maxThumbnailFilesize: 2,
            thumbnailWidth: 120,
            thumbnailHeight: 120,
            acceptedFiles: '.jpg, .jpeg ,.png',
            addRemoveLinks: true,
            dictDefaultMessage: 'تصاویر خود را اینجا آپلود کنید',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="images[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form').find('input[name="images[]"][value="' + name + '"]').remove()
            },
            init: function () {
                @if(isset($project) && $project->document)
                let files =
                    {!! json_encode($project->document) !!}
                    for(let
                i in files
            )
                {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="images[]" value="' + file.file_name + '">')
                }
                @endif
            }
        }


        $(document).ready(function () {

            $('#dropzoneClick').on('click', function () {
                $('img-dropzone').hide();
                $('text-dropzone').hide();

            });
        })


    </script>

    @include('admin_end.include.alert.alert_toastify')
@endpush

