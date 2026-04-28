@foreach($images as $image)
    <x-image-card :image="$image" />
@endforeach