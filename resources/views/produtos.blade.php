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

<span class="flex my-5 items-center text-xl font-medium text-white"><span class="flex w-2.5 h-2.5 bg-red-600 rounded-full me-1.5 flex-shrink-0"></span>Classificados</span>
<div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8 text-white">

    @foreach ($lista as $reg)
    <div codigo="{{ $reg->id }}" class="cardProduto group relative border-solid border rounded border-gray-600 shadow-md hover:shadow-xl hover:shadow-slate-600">
        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-t bg-gray-200 lg:aspect-none group-hover:opacity-85 lg:h-80">
            <img src="{{ url('arquivos/imagens/'.$reg->imagem) }}" alt="..." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
        </div>
        <div class="mt-4 flex justify-between p-1">
            <div>
                <h3 class="text-sm">
                    <a href="#">
                        <span aria-hidden="true" class="absolute inset-0"></span>
                        {{ $reg->titulo }}
                    </a>
                </h3>
            </div>
            <p class="text-sm font-medium p-1">R$ {{ valorVazio($reg->valor) }}</p>
        </div>
        <p class="mt-1 text-justify text-sm p-1">{{ limiteDesc($reg->descricao) }}</p>
    </div>

    <!-- More products... -->
    @endforeach
</div>

@endsection