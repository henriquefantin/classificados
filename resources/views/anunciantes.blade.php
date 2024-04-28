@extends('welcome')
@section('conteudo')
<?php
?>

<span class="flex my-5 items-center text-xl font-medium text-gray-900"><span class="flex w-2.5 h-2.5 bg-purple-500 rounded-full me-1.5 flex-shrink-0"></span>Anunciantes</span>
<div class="mt-6 row">
<!-- <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8"> -->

    @foreach ($empresa as $reg)
    <div codigo="{{ $reg->id }}" class="cardProduto group relative border-solid border rounded border-gray-200 shadow-md hover:shadow-xl">
        <div class="mt-4 flex justify-between p-1">
            <div>
                <h3 class="text-sm text-gray-700">
                    <a href="#">
                        <span aria-hidden="true" class="absolute inset-0"></span>
                        {{ $reg->nome }}
                    </a>
                </h3>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection