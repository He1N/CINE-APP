<?php
require_once '../controlador/pelicula.controlador.php';
require_once '../controlador/usuario.controlador.php';

session_start();

$peliculaController = new PeliculaControlador();
$usuarioController = new UsuarioControlador();

$idPelicula = isset($_GET['id']) ? $_GET['id'] : null;
if (!$idPelicula) {
    header('Location: index.php');
    exit();
}

$pelicula = $peliculaController->obtenerPeliculaPorId($idPelicula);
if (!$pelicula) {
    header('Location: index.php');
    exit();
}

$mensaje = '';
$usuarioLogueado = isset($_SESSION['usuario_id']);
$nombreCompleto = $usuarioLogueado ? $_SESSION['usuario_nombre'] : '';

$fechasDisponibles = $peliculaController->obtenerFechasDisponibles($idPelicula);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    
    if (rand(1, 100) <= 80) {
        $mensaje = "Reserva realizada con éxito para {$pelicula['nombre']} el día {$fecha} a las {$hora}.";
    } else {
        $mensaje = "Error al realizar la reserva: No hay suficientes asientos disponibles para la función seleccionada.";
    }
}

$pageTitle = "Reserva para " . $pelicula['nombre'];
?>

<?php require_once 'layout/header.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Instrument+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/estilosreserva.css">
    <link rel="stylesheet" href="./css/estilosreservaasientos.css">
    <style>
        .countdown-timer {
            font-size: 1em;
            font-weight: bold;
            color: white;
            text-align: left;
            margin-bottom: 20px;
        }
        .payment-container {
            background-color: #1a0808;
            border: 1px solid #3a3a3a;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        .payment-summary {
            background-color: #341616;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .payment-summary h6 {
            color: #FFD700;
            margin-bottom: 10px;
        }
        .payment-summary p {
            margin-bottom: 5px;
        }
        .payment-form label {
            color: #ffffff;
            margin-bottom: 5px;
        }
        .payment-form input {
            background-color: #2a1515;
            border: 1px solid #3a3a3a;
            color: #ffffff;
            margin-bottom: 15px;
        }
        .payment-form input:focus {
            background-color: #2a1515;
            color: #ffffff;
            border-color: #BDDC9F;
            box-shadow: 0 0 0 0.2rem rgba(189, 220, 159, 0.25);
        }
        .btn-pay {
            background-color: #BDDC9F;
            border: none;
            color: #1a0808;
            font-weight: bold;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        .btn-pay:hover {
            background-color: #9FBD7F;
            color: #1a0808;
        }
        .btn-back-payment {
            background-color: transparent;
            border: 1px solid #BDDC9F;
            color: #BDDC9F;
            font-weight: bold;
            padding: 10px 20px;
            transition: all 0.3s ease;
            margin-right: 10px;
        }
        .btn-back-payment:hover {
            background-color: #BDDC9F;
            color: #1a0808;
        }
    </style>
</head>
<body>
    <div class="movie-banner">
        <img src="<?php echo htmlspecialchars($pelicula['img_banner']); ?>" alt="<?php echo htmlspecialchars($pelicula['nombre']); ?> Banner">
        <h1 class="movie-title"><?php echo htmlspecialchars($pelicula['nombre']); ?></h1>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 d-flex justify-content-center">
                <div class="movie-poster-container">
                    <img src="<?php echo htmlspecialchars($pelicula['imagen']); ?>" alt="<?php echo htmlspecialchars($pelicula['nombre']); ?>" class="movie-poster">
                    <div class="instructions-box">
                        <h2>INSTRUCCIONES</h2>
                        <ol>
                            <li>
                                <span class="number">1</span>
                                <span class="text">Elige la fecha preferida.</span>
                            </li>
                            <li>
                                <span class="number">2</span>
                                <span class="text">Elige la hora disponible.</span>
                            </li>
                            <li>
                                <span class="number">3</span>
                                <span class="text">Selecciona tus asientos.</span>
                            </li>
                            <li>
                                <span class="number">4</span>
                                <span class="text">Realiza el pago.</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="booking-container">
                    <div class="booking-steps">
                        <div class="step active" data-number="1"><span>ELIGE LA FECHA</span></div>
                        <div class="step" data-number="2"><span>ELIGE TUS ASIENTOS</span></div>
                        <div class="step" data-number="3"><span>PAGO</span></div>
                    </div>

                    <?php if ($mensaje): ?>
                        <div class="alert <?php echo strpos($mensaje, 'Error') !== false ? 'alert-danger' : 'alert-success'; ?>" role="alert">
                            <?php echo $mensaje; ?>
                        </div>
                    <?php endif; ?>

                    <form action="reserva.php?id=<?php echo $idPelicula; ?>" method="POST" id="scheduleSelection">
                        <h5 class="mb-3 section-title">FECHAS</h5>
                        <div class="dates-container">
                            <?php foreach ($fechasDisponibles as $index => $fecha): ?>
                                <?php
                                $fecha_obj = new DateTime($fecha);
                                $es_primera_fecha = $index === 0;
                                ?>
                                <button type="button" class="date-button <?php echo $es_primera_fecha ? 'active' : ''; ?>" data-date="<?php echo $fecha; ?>">
                                    <div><?php echo $fecha_obj->format('d'); ?></div>
                                    <div><?php echo $fecha_obj->format('M'); ?></div>
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <input type="hidden" name="fecha" id="fechaInput" value="<?php echo $fechasDisponibles[0] ?? ''; ?>">

                        <h5 class="mt-4 mb-3 section-title">HORAS DISPONIBLES</h5>
                        <div id="showtime-container" class="showtime-container">
                            <!-- Las horas se cargarán aquí mediante AJAX -->
                        </div>

                        <input type="hidden" name="hora" id="horaInput" value="">

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="index.php" class="btn btn-back">Regresar</a>
                            <div class="flex-grow-1"></div>
                            <button type="button" id="confirmScheduleButton" class="btn btn-confirm" style="margin-right: 20%;">Confirmar</button>
                        </div>
                    </form>

                    <div id="seatSelection" style="display: none;">
                        <div class="seat-selection-container">
                            <div class="seat-map">
                                <h5 class="mb-3 section-title">ELIGE TUS ASIENTOS</h5>
                                <div class="countdown-timer" id="countdown-timer">5:00</div>
                                <div class="screen">PANTALLA</div>
                                <div class="seats-container">
                                    <!-- Aquí irán los asientos -->
                                </div>
                            </div>
                            <div class="seat-info-container">
                                <div class="booking-info">

                                    <div id="selected-month-display"></div>
                                    <div style="margin-top: 15px;">HORA</div>
                                    <div id="selected-time-display"></div>
                                    <div style="margin-top: 15px;">SALA</div>
                                    <div id="selected-room-display"></div>
                                    <div style="margin-top: 15px;">ASIENTOS DISPONIBLES</div>
                                    <div id="available-seats-display"></div>
                                </div>
                                <div class="seat-info">
                                    <div class="seat-type">
                                        <div class="seat"></div>
                                        <span>Libre</span>
                                    </div>
                                    <div class="seat-type">
                                        <div class="seat selected"></div>
                                        <span>Seleccionado</span>
                                    </div>
                                    <div class="seat-type">
                                        <div class="seat occupied"></div>
                                        <span>Ocupado</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <button id="back-to-schedule" class="btn btn-back">Regresar</button>
                            <button id="confirm-seats" class="btn btn-confirm">Confirmar asientos</button>
                        </div>
                    </div>

                    <div id="payment-section" style="display: none;">
                        <div class="payment-container">
                            <h5 class="mb-3 section-title">PAGO</h5>
                            <div class="payment-summary">
                                <h6>Resumen de la compra</h6>
                                <p>Película: <span id="movie-name"><?php echo htmlspecialchars($pelicula['nombre']); ?></span></p>
                                <p>Fecha: <span id="selected-date"></span></p>
                                <p>Hora: <span id="selected-time"></span></p>
                                <p>Sala: <span id="selected-room"></span></p>
                                <p>Asientos: <span id="selected-seats"></span></p>
                                <p>Total a pagar: S/ <span id="total-amount"></span></p>
                                <?php if ($usuarioLogueado): ?>
                                    <p>Cliente: <span id="client-name"><?php echo htmlspecialchars($nombreCompleto); ?></span></p>
                                <?php endif; ?>
                            </div>
                            <form class="payment-form">
                                <?php if (!$usuarioLogueado): ?>
                                    <div class="mb-3">
                                        <label for="nombres" class="form-label">Nombres</label>
                                        <input type="text" class="form-control" id="nombres" name="nombres" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellidos" class="form-label">Apellidos</label>
                                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dni" class="form-label">DNI</label>
                                        <input type="text" class="form-control" id="dni" name="dni" required>
                                    </div>
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label for="card-number" class="form-label">Número de tarjeta</label>
                                    <input type="text" class="form-control" id="card-number" placeholder="1234 5678 9012 3456" required>
                                </div>
                                <div class="mb-3">
                                    <label for="card-name" class="form-label">Nombre en la tarjeta</label>
                                    <input type="text" class="form-control" id="card-name" placeholder="Juan Pérez" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="expiry-date" class="form-label">Fecha de expiración</label>
                                        <input type="text" class="form-control" id="expiry-date" placeholder="MM/AA" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cvv" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="cvv" placeholder="123" required>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <button type="button" id="back-to-seats" class="btn btn-back-payment">Regresar</button>
                                    <button type="submit" class="btn btn-pay">Pagar ahora</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateButtons = document.querySelectorAll('.date-button');
        const showtimeContainer = document.getElementById('showtime-container');
        const confirmScheduleButton = document.getElementById('confirmScheduleButton');
        const backToScheduleButton = document.getElementById('back-to-schedule');
        const confirmSeatsButton = document.getElementById('confirm-seats');
        const backToSeatsButton = document.getElementById('back-to-seats');
        const scheduleSelection = document.getElementById('scheduleSelection');
        const seatSelection = document.getElementById('seatSelection');
        const paymentSection = document.getElementById('payment-section');
        const bookingSteps = document.querySelectorAll('.step');
        const countdownTimer = document.getElementById('countdown-timer');
        const fechaInput = document.getElementById('fechaInput');
        const horaInput = document.getElementById('horaInput');

        let countdownInterval;
        let remainingTime = 5 * 60; // 5 minutos en segundos
        let selectedSeats = [];

        function startCountdown() {
            updateCountdownDisplay();
            countdownInterval = setInterval(() => {
                remainingTime--;
                updateCountdownDisplay();
                if (remainingTime <= 0) {
                    clearInterval(countdownInterval);
                    alert('El tiempo para seleccionar asientos ha terminado.');
                    backToSchedule();
                }
            }, 1000);
        }

        function updateCountdownDisplay() {
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            countdownTimer.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }

        function stopCountdown() {
            clearInterval(countdownInterval);
            remainingTime = 5 * 60;
            updateCountdownDisplay();
        }

        function backToSchedule() {
            seatSelection.style.display = 'none';
            paymentSection.style.display = 'none';
            scheduleSelection.style.display = 'block';
            bookingSteps[1].classList.remove('active');
            bookingSteps[2].classList.remove('active');
            bookingSteps[0].classList.add('active');
            stopCountdown();
        }

        function backToSeats() {
            paymentSection.style.display = 'none';
            seatSelection.style.display = 'block';
            bookingSteps[2].classList.remove('active');
            bookingSteps[1].classList.add('active');
            startCountdown();
        }

        function cargarHorasDisponibles(fecha) {
            fetch(`obtener_horas.php?id_pelicula=<?php echo $idPelicula; ?>&fecha=${fecha}`)
                .then(response => response.json())
                .then(data => {
                    showtimeContainer.innerHTML = '';
                    let formatoActual = '';
                    data.forEach(hora => {
                        if (hora.formato !== formatoActual) {
                            if (formatoActual !== '') {
                                showtimeContainer.innerHTML += '</div>';
                            }
                            showtimeContainer.innerHTML += `
                                <div class="showtime-section">
                                    <div class="format-title-container">
                                        <h6 class="format-title">${hora.formato}</h6>
                                    </div>
                            `;
                            formatoActual = hora.formato;
                        }
                        const horaObj = new Date(`2000-01-01T${hora.hora}`);
                        showtimeContainer.innerHTML += `
                            <button type="button" class="showtime-button" 
                                data-hora="${hora.hora}" 
                                data-sala="${hora.nombre_sala}" 
                                data-asientos="${hora.asientos_disponibles}">
                                ${horaObj.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                            </button>
                        `;
                    });
                    showtimeContainer.innerHTML += '</div>';

                    document.querySelectorAll('.showtime-button').forEach(button => {
                        button.addEventListener('click', function() {
                            document.querySelectorAll('.showtime-button').forEach(b => b.classList.remove('active'));
                            this.classList.add('active');
                            const selectedHora = this.getAttribute('data-hora');
                            horaInput.value = selectedHora;
                            document.getElementById('selected-time-display').textContent = new Date(`2000-01-01T${selectedHora}`).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                            document.getElementById('selected-room-display').textContent = this.getAttribute('data-sala');
                            document.getElementById('available-seats-display').textContent = this.getAttribute('data-asientos');
                        });
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        dateButtons.forEach(button => {
            button.addEventListener('click', function() {
                dateButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const fechaSeleccionada = this.getAttribute('data-date');
                fechaInput.value = fechaSeleccionada;
                cargarHorasDisponibles(fechaSeleccionada);

                // Update the date display
                const selectedDate = new Date(fechaSeleccionada);
                document.getElementById('selected-date-display').textContent = selectedDate.getDate();
                document.getElementById('selected-month-display').textContent = selectedDate.toLocaleString('default', { month: 'short' }).toUpperCase();
            });
        });

        confirmScheduleButton.addEventListener('click', () => {
            if (!fechaInput.value || !horaInput.value) {
                alert('Por favor, selecciona una fecha y hora.');
                return;
            }
            scheduleSelection.style.display = 'none';
            seatSelection.style.display = 'block';
            bookingSteps[0].classList.remove('active');
            bookingSteps[1].classList.add('active');
            startCountdown();
        });

        backToScheduleButton.addEventListener('click', backToSchedule);

        // Generar asientos
        const seatsContainer = document.querySelector('.seats-container');
        const rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        rows.forEach((row, i) => {
            for (let j = 1; j <= 10; j++) {
                const seat = document.createElement('div');
                seat.classList.add('seat');
                seat.dataset.seatId = `${row}${j}`;
                const seatLabel = document.createElement('span');
                seatLabel.className = 'seat-label';
                seatLabel.textContent = `${row}${j}`;
                seat.appendChild(seatLabel);
                
                // Simular algunos asientos ocupados aleatoriamente
                if (Math.random() < 0.2) {
                    seat.classList.add('occupied');
                }
                
                seatsContainer.appendChild(seat);
            }
        });

        // Seleccionar/deseleccionar asientos
        seatsContainer.addEventListener('click', (e) => {
            const seat = e.target.closest('.seat');
            if (seat && !seat.classList.contains('occupied')) {
                seat.classList.toggle('selected');
                const seatId = seat.dataset.seatId;
                if (seat.classList.contains('selected')) {
                    selectedSeats.push(seatId);
                } else {
                    selectedSeats = selectedSeats.filter(id => id !== seatId);
                }
            }
        });

        // Confirmar asientos y pasar al paso de pago
        confirmSeatsButton.addEventListener('click', () => {
            if (selectedSeats.length === 0) {
                alert('Por favor, selecciona al menos un asiento.');
                return;
            }
            stopCountdown();
            seatSelection.style.display = 'none';
            paymentSection.style.display = 'block';
            bookingSteps[1].classList.remove('active');
            bookingSteps[2].classList.add('active');

            // Actualizar resumen de compra
            document.getElementById('selected-date').textContent = fechaInput.value;
            document.getElementById('selected-time').textContent = horaInput.value;
            document.getElementById('selected-room').textContent = document.getElementById('selected-room-display').textContent;
            document.getElementById('selected-seats').textContent = selectedSeats.join(', ');
            document.getElementById('total-amount').textContent = (selectedSeats.length * 10).toFixed(2);
        });

        // Volver al paso de selección de asientos desde el pago
        backToSeatsButton.addEventListener('click', backToSeats);

        // Manejar el envío del formulario de pago
        document.querySelector('.payment-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('¡Pago procesado con éxito! Gracias por tu compra.');
            // Aquí puedes agregar la lógica para procesar el pago y redirigir al usuario
        });

        // Cargar horas para la primera fecha al cargar la página
        if (dateButtons.length > 0) {
            cargarHorasDisponibles(dateButtons[0].getAttribute('data-date'));
        }
    });
    </script>
</body>
</html
</ReactProject>

