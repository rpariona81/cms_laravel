@extends('layouts.app')

@section('content')

<h3>
    <a href="{{ route('home') }}" title="Inicio">Inicio</a><span>| Noticias</span>
</h3>

<div class="row">

    @foreach ($rowset as $row)
        
    <article class="col m6">
        <div class="card horizontal small">
            <div class="card-image">
                {{ Html::image('img/'.$row->imagen, $row->titulo) }}
            </div>
            <div class="card-stacked">
                <div class="card-content">
                    <h4>{{ $row->titulo }}</h4>
                    <p>{{ $row->entradilla }}</p>
                </div>
                <div class="card-info">
                    <p>{{ date("d/m/Y", strtotime($row->fecha)) }}</p>
                </div>
                <div class="card-action">
                    <a href="{{ url('noticia/'.$row->slug) }}">Más información</a>
                </div>
            </div>
        </div>
    </article>

    @endforeach
</div>

@endsection