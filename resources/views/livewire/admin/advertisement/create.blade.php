<div>
    <form wire:submit="store" id="product-form">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">


                    <div class="mt-5 mb-5 col-lg-6 col-md-8 col">
                        <label for="category-select" class="form-label">
                            <span style="margin-left: 10px"><i class="fa fa-star text-danger" style="font-size:10px"></i></span>گروه آگهی
                        </label>
                        <select class="category-select form-select"  id="category-select" name="advGroup">
                            {{-- @foreach($categories as $category)
                                 <option value="{{ $category->id }}" {{ (collect(old("categories"))->contains($category->id)  ? "selected":"") }} >
                                     {{ $category->title }}
                                 </option>
                             @endforeach--}}
                        </select>
                        @error('advGroup')
                        <div class="my-5 alert alert-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="mt-5 mb-5 col-lg-6 col-md-8 col">
                        <div class="my-5">موقعیت آگهی</div>
                        <label for="province-select" class="form-label">
                            <span style="margin-left: 10px"><i class="fa fa-star text-danger" style="font-size:10px"></i></span>استان
                        </label>
                        <select class="province-select form-select" wire:change="getCity()"  wire:model="province_id"  id="province-select" name="province">
                            <option value="">{{ __('messages.choose') }}</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}" {{ $province->id == old("province")  ? "selected": "" }}  >
                                    {{ $province->name}}
                                </option>
                            @endforeach
                        </select>
                        @error('province')
                        <div class="my-5 alert alert-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="mt-5 mb-5 col-lg-6 col-md-8 col">
                        <label for="city-select" class="form-label">
                            <span style="margin-left: 10px"><i class="fa fa-star text-danger" style="font-size:10px"></i></span>شهر
                        </label>
                        <select class="city-select form-select" wire:model="city_id" id="city-select"  name="city">
                            @foreach($loadCities as $city)
                                <option value="{{ $city->id }}" >
                                    {{ $city->name}}
                                </option>
                            @endforeach
                        </select>
                        @error('city')
                        <div class="my-5 alert alert-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="mt-5 col-lg-6 col-md-8 col">
                        <label for="title" class="form-label"><span style="margin-left: 10px">
                                        <i class="fa fa-star text-danger" style="font-size:10px"></i></span>عنوان آگهی
                        </label>
                        <input type="text" class="form-control" id="title" name="title"
                               value="{{ old('title_persian') }}">
                        @error('title')
                        <div class="mt-3 alert alert-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="mt-5 col-lg-6 col-md-8 col">
                        <label for="description" class="mb-5 form-label"><span style="margin-left: 10px">
                                        <i class="fa fa-star text-danger" style="font-size:10px"></i></span>شرح آگهی
                        </label>
                        <textarea class="mt-5 form-control" id="description"
                                  name="description">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="mt-3 alert alert-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="mt-5 mb-5 col-lg-6 col-md-8 col" wire:ignore>
                        <label for="product_tags" class="form-label">عبارات کلیدی</label>
                      {{--  <input type="hidden"  name="product_tags" id="product_tags" value="{{ old('product_tags') }}">--}}
                        <select class="form-select" wire:model="product_tags" multiple="multiple" id="product_selected_tags"></select>
                        @error('product_tags')
                        <div class="mt-3 alert alert-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    {{--  <div class="" style="margin-top:5rem"><h3 class="h3">لینک ها</h3></div>--}}


                    <fieldset>
                        <legend>لینک ها</legend>

                        <div class="mt-2 col-lg-6 col-md-8 col">
                            <label for="website" class="form-label">وب سایت</label>
                            <input type="text" class="form-control form-control-sm" id="website" name="website"
                                   value="{{ old('website') }}">
                            @error('website')
                            <div class="mt-3 alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mt-2 col-lg-6 col-md-8 col">
                            <label for="telegram" class="form-label">تلگرام</label>
                            <input type="text" class="form-control form-control-sm" id="telegram"
                                   name="telegram" value="{{ old('telegram') }}">
                            @error('telegram')
                            <div class="mt-3 alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mt-2 col-lg-6 col-md-8 col">
                            <label for="instagram" class="form-label">اینستاگرام</label>
                            <input type="text" class="form-control form-control-sm" id="instagram"
                                   placeholder="" name="instagram" value="{{ old('instagram') }}">
                            @error('instagram')
                            <div class="mt-3 alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mt-5 col-lg-6 col-md-8 col">
                            <label for="rubika" class="form-label">روبیکا</label>
                            <input type="text" class="form-control form-control-sm" id="rubika" name="rubika"
                                   value="{{ old('rubika') }}">
                            @error('rubika')
                            <div class="mt-3 alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mt-5 col-lg-6 col-md-8 col">
                            <label for="eitaa" class="form-label">ایتا</label>
                            <input type="text" class="form-control form-control-sm" id="eitaa" name="eitaa"
                                   value="{{ old('eitaa') }}">
                            @error('eitaa')
                            <div class="mt-3 alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </fieldset>


                    <div class="col-lg-6 col-md-8 col" style="margin-top:4rem">
                        <label for="owner" class="form-label"><span style="margin-left: 10px">
                                        <i class="fa fa-star text-danger" style="font-size:10px"></i></span> نام اگهی دهنده
                        </label>
                        <input type="text" class="form-control" id="owner" name="owner"
                               value="{{ old('owner') }}">
                        @error('owner')
                        <div class="mt-3 alert alert-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="mt-5 col-lg-6 col-md-8 col">
                        <label for="address" class="form-label">آدرس</label>
                        <input type="address" class="form-control" id="address" name="address"
                               value="{{ old('address') }}">
                        @error('address')
                        <div class="mt-3 alert alert-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="mt-5 col-lg-6 col-md-8 col">
                        <label for="advertiser_phone" class="form-label"><span style="margin-left: 10px">
                                        <i class="fa fa-star text-danger" style="font-size:10px"></i></span>تلفن / موبابل
                        </label>
                        <input type="text" class="form-control" id="advertiser_phone" name="advertiser_phone"
                               value="{{ old('advertiser_phone') }}">
                        @error('advertiser_phone')
                        <div class="mt-3 alert alert-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="mt-5 col-lg-6 col-md-8 col">
                        <label for="email" class="form-label">ایمیل</label>
                        <input type="text" class="form-control" id="email" name="email"
                               value="{{ old('email') }}">
                        @error('email')
                        <div class="mt-3 alert alert-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="mt-5 col-lg-6 col-md-8 col">
                        <label for="seo_desc" class="mb-5">توضیحات سئو</label>
                        <input type="text" class="form-control" name="seo_desc" id="seo_desc"
                               value="{{ old('seo_desc') }}">
                        @error('seo_desc')
                        <div class="mt-3 alert alert-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mt-5 mb-5 col-sm-4">
                        <div
                            class="row d-flex flex-column justify-content-center align-content-center product-image">
                            <div class="col-lg-8">
                                <img src="{{ asset('admin_assets/images/no-image-icon-23494.png') }}"
                                     id="image_view" class="img-thumbnail" height="300" width="300" alt="image">
                            </div>
                            <div class="col-lg-8">
                                <label for="image_label"
                                       class="mt-5 form-label">{{ __('messages.thumbnail_image') }}</label>
                                <input type="file" class="form-control" accept="image/png, image/jpeg"
                                       id="image_select"
                                       name="thumbnail_image" value="{{ old('thumbnail_image') }}" readonly>
                                @error('thumbnail_image')
                                <div class="mt-3 alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>


                </div>
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

    <script type="module">

        $('.province-select').select2({
            placeholder: "{{ __('messages.choose') }}",
            dir: 'rtl',
        })
        $('.province-select').on('change',function (e)
        {
            let value = $('#province-select').select2("val");
            Livewire.dispatch('listenerGetId',value);
        })


        $('.city-select').select2({
            dir: 'rtl',
        });

       /* $('.category-select').select2({
            maximumSelectionLength: 1,
            dir: 'rtl'
        });*/


        // tags select
        $(document).ready(function () {
            var selected_tags = $('#product_selected_tags');
           /* var tags_input = $('#product_tags'); // go for backend
            var selected_tags = $('#product_selected_tags'); // user enter tags
            var default_tags = tags_input.val();
            var default_data = null;
            // for keeping old value after failed validation
            if (tags_input.val() !== null && tags_input.val().length > 0) {
                default_data = default_tags.split(',');
                console.log(default_data);
            }*/
            // select2 config
            selected_tags.select2({
                theme: 'classic',
                dir: 'rtl',
                tags: 'true',
              //  data: default_data,
            }).on('change',function (){

                const values = $(this).val();
                console.log(values);

                @this.product_tags = values;
            });
          /*  selected_tags.children('option').attr('selected', true).trigger('change');
            // save all tags into hidden input & go for backed
            $('#product-form').submit(function (event) {
                if (selected_tags.val() !== null && selected_tags.val().length > 0) {
                    var selectedSource = selected_tags.val().join(',');
                    tags_input.val(selectedSource);
                }
            })*/
        });
    </script>
</div>
