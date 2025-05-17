{{-- resources/views/people/_form.blade.php --}}
@csrf

<div>
  <label>Nombre</label>
  <input type="text" name="first_name" value="{{ old('first_name', $person->first_name ?? '') }}" required>
  @error('first_name')<div>{{ $message }}</div>@enderror
</div>

<div>
  <label>Apellido</label>
  <input type="text" name="last_name" value="{{ old('last_name', $person->last_name ?? '') }}" required>
  @error('last_name')<div>{{ $message }}</div>@enderror
</div>

<div>
  <label>RUT</label>
  <input type="text" name="rut" value="{{ old('rut', $person->rut ?? '') }}"
         pattern="^\d{1,2}\.\d{3}\.\d{3}-[kK\d]$" required>
  @error('rut')<div>{{ $message }}</div>@enderror
</div>

<div>
  <label>Fecha de nacimiento</label>
  <input type="date" name="birth_date" value="{{ old('birth_date', $person->birth_date ?? '') }}" required>
  @error('birth_date')<div>{{ $message }}</div>@enderror
</div>
