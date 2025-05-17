@extends('layouts.plain')

@section('content')
  <div class="content">
    <h1>Crear Persona</h1>

    <form action="{{ route('people.store') }}" method="POST" class="people-form">
      @include('people._form')
      <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
  </div>
@endsection
