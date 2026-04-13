@if(session('message'))
    <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
    {{ session('message') }}
    </div>
@endif