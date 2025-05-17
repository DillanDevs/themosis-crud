{{-- resources/views/people/edit.blade.php --}}
@extends('layouts.main')
@section('content')
  <h1>Editar Persona</h1>
  <form action="{{ route('people.update', $person->id) }}" method="POST">
    @method('PUT')
    @include('people._form')
    <button type="submit">Actualizar</button>
  </form>
@endsection
