@props(['status'=>'info'])

@php
if(session('status')==='info'){$bgColor='bg-green-400';}
if(session('status')==='alert'){$bgColor='bg-red-500';}
@endphp


@if(session('message'))
<div class="{{ $bgColor }} w-full md:w-1/2 text-center mx-auto p-2 my-4 text-white">
    {{session('message')}}
</div>
@endif
