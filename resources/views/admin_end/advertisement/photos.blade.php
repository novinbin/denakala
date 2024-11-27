<h2 class="mb-1 text-lg">{{ __('messages.images') }}</h2>

<div id="imageContainer" class="h-auto mb-3 row row-cols-1 row-cols-md-4 row-cols-lg-4 row-cols-xl-4 g-4">
    @foreach($photos as $key => $photo)
        <div class="card" id="image_{{ $key }}" style="width: 18rem;">
            <img src="{{ asset('storage'.$photo) }}" alt="photo" class="w-52 h-52 rounded">
            <div class="card-body border rounded mt-2 d-flex justify-content-center">
                <div onclick="deleteImage({{ $key }})" class="btn btn-danger btn-sm text-center" style="user-select: none">حذف</div>
            </div>
        </div>
    @endforeach
    <input hidden id="old_photos" name="old_photos" value="{{ json_encode($photos->toArray()) }}">
</div>

<script>
    function deleteImage(key)
    {
        document.getElementById('imageContainer').removeChild(document.getElementById('image_' + String(key)));
        let old_photos = document.getElementById('old_photos');
        let array = JSON.parse(old_photos.value);
        delete array[key];
        old_photos.value = JSON.stringify(array);
    }
</script>
