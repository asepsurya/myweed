@if(isset($music))
<audio autoplay loop>
    <source src="{{ $music }}" type="audio/mpeg">
</audio>
@endif