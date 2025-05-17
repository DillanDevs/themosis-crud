@extends('layouts.plain')

@section('content')
  <div class="content">
    <h1>Listado de Personas</h1>

    <a href="{{ route('people.create') }}" class="btn btn-primary">Nuevo registro</a>

    @if(session('success'))
      <div class="alert">
        {{ session('success') }}
      </div>
    @endif

    <table>
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>RUT</th>
          <th>Fecha Nac.</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($people as $p)
          <tr>
            <td>{{ $p->first_name }}</td>
            <td>{{ $p->last_name }}</td>
            <td>{{ $p->rut }}</td>
            <td>{{ $p->birth_date }}</td>
            <td>
              <a href="{{ route('people.edit', $p->id) }}" class="btn btn-primary">Editar</a>
              <form action="{{ route('people.destroy', $p->id) }}" method="POST" style="display:inline">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-delete">Eliminar</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
