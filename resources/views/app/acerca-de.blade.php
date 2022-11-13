@extends('layouts.app')

@section('content')

<h3>
    <a href="{{ route('home') }}" title="Inicio">Inicio</a> <span>| Acerca de</span>
</h3>

<div class="row">
    <i class="large material-icons">info_outline</i>
    <p>
        Esta página muestra noticias relacionadas con el universo de Harry Potter
    </p>
    <p>
        Está desarrollada en PHP con Programación orientada a Objetos, siguiendo el modelo MVC
        utiliza como base de datos la siguiente versión:<br>
        {!! $row !!} 
    </p>
</div>

@endsection