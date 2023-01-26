@props(['tagsCsv'])

@php
    $tags = explode(',', $tagsCsv); 
@endphp

<ul class="flex">
    @foreach ($tags as $tag)
    <li
        class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs"
    >
        <a href="http://localhost/My_First_Laravel_Project/public/?tag={{$tag}}">{{ucwords($tag)}}</a>
    </li>
    @endforeach
</ul>