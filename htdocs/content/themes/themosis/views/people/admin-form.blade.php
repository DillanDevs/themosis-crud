@php
  $rutError = isset($_GET['error_rut']) ? urldecode($_GET['error_rut']) : null;
@endphp

@if($rutError)
  <div class="error-message" style="margin-bottom:1rem;">
    {{ $rutError }}
  </div>
@endif

<form id="person-form" action="{{ $endpoint }}?action={{ $action }}" method="POST">
  @csrf
  @if($person)
    <input type="hidden" name="id" value="{{ $person->id }}">
  @endif

  @include('people._form')

  <div class="form-actions" style="display:flex; justify-content: space-between; margin-top:1.5rem;">
    <a href="{{ admin_url('admin.php?page=people-admin') }}" class="btn btn-back">Atrás</a>
    <button type="submit" class="btn btn-primary">
      {{ $person ? 'Actualizar' : 'Guardar' }}
    </button>
  </div>
</form>
