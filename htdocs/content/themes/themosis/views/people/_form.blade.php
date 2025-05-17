@csrf

<div class="form-group">
  <label for="first_name">Nombre</label>
  <input
    id="first_name"
    type="text"
    name="first_name"
    value="{{ old('first_name', $person->first_name ?? '') }}"
    required
  >
  @error('first_name')
    <div class="error-message">{{ $message }}</div>
  @enderror
</div>

<div class="form-group">
  <label for="last_name">Apellido</label>
  <input
    id="last_name"
    type="text"
    name="last_name"
    value="{{ old('last_name', $person->last_name ?? '') }}"
    required
  >
  @error('last_name')
    <div class="error-message">{{ $message }}</div>
  @enderror
</div>

<div class="form-group">
  <label for="rut">RUT</label>
  <input
    id="rut"
    class="form-control"
    type="text"
    name="rut"
    placeholder="12.345.678-5"
    value="{{ old('rut', $person->rut ?? '') }}"
    required
  >
  @error('rut')
    <div class="error">{{ $message }}</div>
  @enderror
</div>


<div class="form-group">
  <label for="birth_date">Fecha de nacimiento</label>
  <input
    id="birth_date"
    type="date"
    name="birth_date"
    value="{{ old('birth_date', $person->birth_date ?? '') }}"
    required
  >
  @error('birth_date')
    <div class="error-message">{{ $message }}</div>
  @enderror
</div>
