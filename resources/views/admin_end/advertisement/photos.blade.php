<h2 class="mb-1 text-lg">{{ __('messages.images') }}</h2>
<div id="imageContainer" class="h-auto mb-3 py-10 w-100 bg-white rounded-xl d-flex  flex-wrap  justify-center gap-6 bg-center">
    @foreach($photos as $key => $photo)
        <div id="image_{{ $key }}">
            <div onclick="deleteImage({{ $key }})" class="rounded-xl  w-50 h-50 absolute d-flex" style="user-select: none">حذف</div>
            <img src="{{ asset('storage'.$photo) }}" alt="photo" class="w-52 h-52 rounded-xl">
        </div>
    @endforeach
    <input hidden id="old_photos" name="old_photos" value="{{ json_encode($photos->toArray()) }}">
</div>

<script>
    function deleteImage(key) {
        document.getElementById('imageContainer').removeChild(document.getElementById('image_' + String(key)));
        let old_photos = document.getElementById('old_photos');
        let array = JSON.parse(old_photos.value);
        delete array[key];
        old_photos.value = JSON.stringify(array);
    }
</script>
