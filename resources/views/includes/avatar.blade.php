@if(Auth::user()->image)
<div class="container-avatar">
    <img 
        src="{{ route('user.avatar', ['filename' => auth()->user()->image]) }}" 
        class="<!-- w-11 h-11 rounded-full object-cover -->"
    >
</div>
@endif
