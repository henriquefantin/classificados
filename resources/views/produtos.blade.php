@extends('welcome')
@section('conteudo')
<?php
function valorVazio($valor)
{
    if ($valor != null && $valor != "") {
        return $valor;
    } else {
        return "0.00";
    }
}

function limiteDesc($valor)
{
    return mb_strimwidth($valor, 0, 100, "...");
}
?>

<span class="flex my-5 items-center text-xl font-medium text-gray-900"><span class="flex w-2.5 h-2.5 bg-purple-500 rounded-full me-1.5 flex-shrink-0"></span>Classificados</span>
<div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">

    @foreach ($lista as $reg)
    <div codigo="{{ $reg->id }}" class="cardProduto group relative border-solid border rounded border-gray-200 shadow-md hover:shadow-xl">
        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-t bg-gray-200 lg:aspect-none group-hover:opacity-85 lg:h-80">
            <img src="{{ url('arquivos/imagens/'.$reg->imagem) }}" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
        </div>
        <div class="mt-4 flex justify-between p-1">
            <div>
                <h3 class="text-sm text-gray-700">
                    <a href="#">
                        <span aria-hidden="true" class="absolute inset-0"></span>
                        {{ $reg->titulo }}
                    </a>
                </h3>
            </div>
            <p class="text-sm font-medium text-gray-900 p-1">R$ {{ valorVazio($reg->valor) }}</p>
        </div>
        <p class="mt-1 text-justify text-sm text-gray-500 p-1">{{ limiteDesc($reg->descricao) }}</p>
    </div>

    <!-- More products... -->
    @endforeach
</div>

@endsection