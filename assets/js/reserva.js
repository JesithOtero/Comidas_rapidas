// script.js

document.addEventListener("DOMContentLoaded", function () {
  const elegirMesaBtn = document.querySelector('#elegirMesaBtn');  // El botón "Elegir mesa"
  const radios = document.querySelectorAll('input[type="radio"]');
  
  // Función para comprobar si se ha seleccionado una mesa
  function checkSelection() {
    const selected = Array.from(radios).some(radio => radio.checked);
    elegirMesaBtn.disabled = !selected; // Habilitar o deshabilitar el botón "Elegir mesa"
  }

  // Añadir un listener de evento para cada radio
  radios.forEach(radio => {
    radio.addEventListener('change', checkSelection);
  });

  // Comprobar el estado de los radios al cargar la página
  checkSelection();

  document.querySelectorAll('input[name="mesa"]').forEach(radio => {
    radio.addEventListener('change', () => {
      document.getElementById('elegirMesaBtn').disabled = false;
    });
  });

  document.getElementById('elegirMesaBtn').addEventListener('click', () => {
    const mesaRadio = document.querySelector('input[name="mesa"]:checked');
    if (mesaRadio) {
      document.getElementById('mesaSeleccionadaInput').value = mesaRadio.value;
    }
  });

   const fechaInput = document.getElementById('fechaNueva');
  if (fechaInput) {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const minDate = `${yyyy}-${mm}-${dd}`;
    fechaInput.min = minDate;
  }

  // Limitar minutos a 00 o 30 en el input de hora
  const horaInput = document.getElementById('horaNueva');
  if (horaInput) {
    horaInput.addEventListener('input', function () {
      let [h, m] = this.value.split(':');
      if (m !== '00' && m !== '30') {
        m = (parseInt(m) < 30) ? '00' : '30';
        this.value = `${h}:${m}`;
      }
    });
    // Opcional: establecer step para que el selector muestre solo 00 y 30
    horaInput.step = 1800; // 1800 segundos = 30 minutos
  }


  
});

  