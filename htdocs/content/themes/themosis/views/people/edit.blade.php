@extends('layouts.plain')

@section('content')
  <div class="content">
    <h1>Editar Persona</h1>

    <form action="{{ route('people.update', $person->id) }}" method="POST" class="people-form">
      @method('PUT')
      @include('people._form')
      <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
  </div>
@endsection
