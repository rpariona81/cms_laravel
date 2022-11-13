@extends('layouts.admin')

@section('content')

<h3>Acceso</h3>
<div class="row">
    <form class="col m6" method="POST" action="{{ route('autenticar') }}">
        @csrf
        <div class="input-field col s12">
            <input id="email" type="email" name="email" value="">
            <label for="email">Email</label>
        </div>
        <div class="input-field col s12">
            <input id="password" type="password" name="password" value="">
            <label for="password">Contraseña</label>
        </div>
        <div class="input-field col s12">
            <a href="#" title="Cambiar contraseña">
                <button class="btn waves-effect waves-light" type="button">Cambiar contraseña
                    <i class="material-icons right">help</i>
                </button>
            </a>
            <a href="{{ route('registro') }}" title="Registrarse">
                <button class="btn waves-effect waves-light" type="button">Registrarse
                    <i class="material-icons right">person_add</i>
                </button>
            </a>
            <button class="btn waves-effect waves-light" type="submit">Acceder
                <i class="material-icons right">person</i>
            </button>
        </div>
    </form>
</div>

@endsection