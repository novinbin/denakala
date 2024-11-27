@foreach($child as $category)

    @if(count($category->children))
        <div class="accordion item-category mt-2">
            <div class="accordion-item">
                <div class="accordion-header item-category-title" id="headingOne">
                    @if($category->hasChildren())
                        <a class="my-3 btn  accordion-button" href="#collapse{{ $category->id }}" data-bs-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                            <h6>{{ $category->title }}</h6>
                        </a>
                    @else
                        <div>{{ __('messages.there_is_no_child') }}</div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="accordion item-category">
            <div class="accordion-item">
                <div class="accordion-header p-4 item-category-title" id="headingOne">
                    <div class="ms-5 p-2 d-flex justify-content-start">
                        <div class="mx-2">
                            <input {{ $category->id =   }} type="radio" class="mt-1" name="advGroup" value="{{ $category->id }}">
                        </div>
                        <div>
                            {{ $category->title }}
                        </div>
                    </div>
                </div>
            </div>
           {{-- <div>{{ $category->title }}</div>
            <input type="radio" name="advertisement" value="{{ $category->id }}">--}}
        </div>

    @endif


    <div class="collapse" id="collapse{{$category->id}}">
        @if($category->hasChildren())
            @include('admin_end.category.edit_child_category',['child'=>$category->children])
        @else
            <div>{{ __('messages.there_is_no_child') }}</div>
        @endif
    </div>

@endforeach
{{--@foreach($child as $category)

    <div class="accordion item-category">
        <div class="accordion-item">
            <div class="accordion-header item-category-title" id="headingOne">
                @if($category->hasChildren())
                    <a class="my-3 btn  accordion-button" href="#collapse{{ $category->id }}" data-bs-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                        <h6>{{ $category->title }}</h6>
                    </a>
                @else
                    <div>{{ __('messages.there_is_no_child') }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="collapse" id="collapse{{$category->id}}">
        @if($category->hasChildren())
            @include('admin_end.category.child_category',['child'=>$category->children])
        @else
            <div>{{ __('messages.there_is_no_child') }}</div>
        @endif
    </div>

@endforeach--}}

{{-- <input type="radio" name="advertisement" value="{{ $category->id }}"> --}}





