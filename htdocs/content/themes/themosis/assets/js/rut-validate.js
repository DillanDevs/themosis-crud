document.addEventListener('DOMContentLoaded', function() {
  const rutInput = document.querySelector('input[name="rut"]');
  const form     = document.getElementById('person-form');

  function cleanRut(rut) {
    return rut.replace(/[\.\-\s]/g, '').toUpperCase();
  }

  function calcDv(rut) {
    let sum = 0;
    let mul = 2;
    for (let i = rut.length - 1; i >= 0; i--) {
      sum += Number(rut.charAt(i)) * mul;
      mul = mul === 7 ? 2 : mul + 1;
    }
    const mod = 11 - (sum % 11);
    if (mod === 11) return '0';
    if (mod === 10) return 'K';
    return String(mod);
  }

  function validateRut(rut) {
    const clean = cleanRut(rut);
    if (clean.length < 2) return false;
    const body = clean.slice(0, -1);
    const dv   = clean.slice(-1);
    if (!/^\d+$/.test(body)) return false;
    return calcDv(body) === dv;
  }

  function showError(message) {
    let err = rutInput.nextElementSibling;
    if (!err || !err.classList.contains('error')) {
      err = document.createElement('div');
      err.className = 'error';
      rutInput.insertAdjacentElement('afterend', err);
    }
    err.textContent = message;
  }

  function clearError() {
    const err = rutInput.nextElementSibling;
    if (err && err.classList.contains('error')) {
      err.remove();
    }
  }

  rutInput.addEventListener('input', () => {
    const val = rutInput.value;
    if (!val) {
      clearError();
      rutInput.classList.remove('error');
      return;
    }
    if (!validateRut(val)) {
      rutInput.classList.add('error');
      showError('RUT inválido');
    } else {
      rutInput.classList.remove('error');
      clearError();
    }
  });

  form.addEventListener('submit', (e) => {
    if (!validateRut(rutInput.value)) {
      e.preventDefault();
      rutInput.classList.add('error');
      showError('RUT inválido, por favor corrígelo');
      rutInput.focus();
    }
  });
});
