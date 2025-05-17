{{-- resources/views/people/create.blade.php --}}
@extends('layouts.main')
@section('content')
  <h1>Crear Persona</h1>
  <form action="{{ route('people.store') }}" method="POST">
    @include('people._form')
    <button type="submit">Guardar</button>
  </form>
@endsection
