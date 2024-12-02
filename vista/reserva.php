<?php
// Prevent any output before headers for AJAX requests
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // Disable error reporting for AJAX requests to prevent unwanted output
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Start output buffering to catch any unwanted output
ob_start();

require_once '../controlador/pelicula.controlador.php';
require_once '../controlador/usuario.controlador.php';
require_once '../controlador/reserva.controlador.php';

$usuarioController = new UsuarioControlador();

session_start();

// Process AJAX requests separately
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // Clear any output buffered so far
    ob_clean();
    
    header('Content-Type: application/json');
    
    try {
        $datosReserva = [
            'pelicula_id' => $_POST['pelicula_id'],
            'pelicula_nombre' => $_POST['pelicula_nombre'],
            'fecha_reserva' => $_POST['fecha_reserva'],
            'hora_reserva' => $_POST['hora_reserva'],
            'sala' => $_POST['sala'],
            'formato' => $_POST['formato'],
            'asientos' => $_POST['asientos'],
            'total' => $_POST['total'],
            'cliente_nombres' => isset($_SESSION['usuario_id']) ? $_SESSION['usuario_nombre'] : $_POST['nombres'],
            'cliente_apellidos' => isset($_SESSION['usuario_id']) ? $_SESSION['usuario_apellidos'] : $_POST['apellidos'],
            'cliente_dni' => isset($_SESSION['usuario_id']) ? $_SESSION['usuario_dni'] : $_POST['dni']
        ];

        $reservaController = new ReservaControlador();
        $resultado = $reservaController->crearReserva($datosReserva);
        
        echo json_encode($resultado);
    } catch (Exception $e) {
        echo json_encode([
            'exito' => false,
            'mensaje' => 'Error al procesar la reserva: ' . $e->getMessage()
        ]);
    }
    
    exit;
}

// Continue with regular page load for non-AJAX requests
$idPelicula = isset($_GET['id']) ? $_GET['id'] : null;
if (!$idPelicula) {
    header('Location: index.php');
    exit();
}

$peliculaController = new PeliculaControlador();
$usuarioController = new UsuarioControlador();
$reservaController = new ReservaControlador();

$pelicula = $peliculaController->obtenerPeliculaPorId($idPelicula);
if (!$pelicula) {
    header('Location: index.php');
    exit();
}

$mensaje = '';
$usuarioLogueado = isset($_SESSION['usuario_id']);
$usuarioInfo = null;
if ($usuarioLogueado) {
    $usuarioInfo = $usuarioController->obtenerUsuarioPorId($_SESSION['usuario_id']);
}
$nombreCompleto = $usuarioLogueado ? $_SESSION['usuario_nombre'] : '';

$fechasDisponibles = $peliculaController->obtenerFechasDisponibles($idPelicula);

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
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
        .reserva-summary {
            background-color: #341616;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            color: #ffffff;
        }
        .reserva-summary h2 {
            color: #FFD700;
            margin-bottom: 15px;
        }
        .reserva-summary p {
            margin-bottom: 10px;
        }
        .reserva-summary ul {
            padding-left: 20px;
        }
        .reserva-summary li {
            margin-bottom: 5px;
        }
        .reserva-confirmation {
            background-color: #341616;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            color: #ffffff;
            text-align: center;
        }
        .reserva-confirmation h2 {
            color: #FFD700;
            margin-bottom: 15px;
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
                        <input type="hidden" name="formato" id="formatoInput" value="">

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
                                    <div style="margin-top: 15px;">FECHA</div>
                                    <div id="selected-date-display"></div>
                                    <div style="margin-top: 15px;">HORA</div>
                                    <div id="selected-time-display"></div>
                                    <div style="margin-top: 15px;">SALA</div>
                                    <div id="selected-room-display"></div>
                                    <div style="margin-top: 15px;">FORMATO</div>
                                    <div id="selected-format-display"></div>
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
                                <p>Sala:<span id="selected-room"></span></p>
                                <p>Formato: <span id="selected-format"></span></p>
                                <p>Asientos: <span id="selected-seats"></span></p>
                                <p>Total a pagar: S/ <span id="total-amount"></span></p>
                                <?php if ($usuarioLogueado && $usuarioInfo): ?>
                                    <p>Nombre: <span id="client-name"><?php echo htmlspecialchars($usuarioInfo['nombres']); ?></span></p>
                                    <p>Apellido: <span id="client-lastname"><?php echo htmlspecialchars($usuarioInfo['apellidos']); ?></span></p>
                                    <p>DNI: <span id="client-dni"><?php echo htmlspecialchars($usuarioInfo['dni']); ?></span></p>
                                <?php endif; ?>
                            </div>
                            <form class="payment-form">
                                <?php if ($usuarioLogueado && $usuarioInfo): ?>
                                    <input type="hidden" id="nombres" name="nombres" value="<?php echo htmlspecialchars($usuarioInfo['nombres']); ?>">
                                    <input type="hidden" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($usuarioInfo['apellidos']); ?>">
                                    <input type="hidden" id="dni" name="dni" value="<?php echo htmlspecialchars($usuarioInfo['dni']); ?>">
                                <?php else: ?>
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
        const { jsPDF } = window.jspdf;
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
        const formatoInput = document.getElementById('formatoInput');

        const COUNTDOWN_DURATION = 5 * 60; // 5 minutos en segundos
        let remainingTime = COUNTDOWN_DURATION;
        let countdownInterval;
        let selectedSeats = [];

        function startCountdown() {
            updateCountdownDisplay();
            const startTime = Date.now();
            countdownInterval = setInterval(() => {
                const elapsedTime = Math.floor((Date.now() - startTime) / 1000);
                remainingTime = COUNTDOWN_DURATION - elapsedTime;
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
            countdownTimer.textContent = `${padZero(minutes)}:${padZero(seconds)}`;
        }

        function padZero(num) {
            return num.toString().padStart(2, '0');
        }

        function stopCountdown() {
            if (countdownInterval) {
                clearInterval(countdownInterval);
                countdownInterval = null;
            }
            remainingTime = COUNTDOWN_DURATION;
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
            selectedSeats = []; // Limpiar los asientos seleccionados
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
                                data-asientos="${hora.asientos_disponibles}"
                                data-formato="${hora.formato}">
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
                            const selectedFormato = this.getAttribute('data-formato');
                            horaInput.value = selectedHora;
                            formatoInput.value = selectedFormato;
                            document.getElementById('selected-time-display').textContent = new Date(`2000-01-01T${selectedHora}`).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                            document.getElementById('selected-room-display').textContent = this.getAttribute('data-sala');
                            document.getElementById('selected-date-display').textContent = fechaInput.value;
                            document.getElementById('selected-format-display').textContent = selectedFormato;
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
                const formattedDate = `${selectedDate.getDate()} ${selectedDate.toLocaleString('default', { month: 'short' }).toUpperCase()}`;
                document.getElementById('selected-date-display').textContent = formattedDate;
            });
        });

        // Generar asientos
        const seatsContainer = document.querySelector('.seats-container');
        const rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];

        function generarAsientos(asientosOcupados) {
            seatsContainer.innerHTML = '';
            rows.forEach((row, i) => {
                for (let j = 1; j <= 10; j++) {
                    const seat = document.createElement('div');
                    seat.classList.add('seat');
                    const seatId = `${row}${j}`;
                    seat.dataset.seatId = seatId;
                    const seatLabel = document.createElement('span');
                    seatLabel.className = 'seat-label';
                    seatLabel.textContent = seatId;
                    seat.appendChild(seatLabel);
                    
                    if (asientosOcupados.includes(seatId)) {
                        seat.classList.add('occupied');
                    }
                    
                    seatsContainer.appendChild(seat);
                }
            });
        }

        function obtenerAsientosOcupados() {
            const peliculaId = <?php echo $idPelicula; ?>;
            const fecha = fechaInput.value;
            const hora = horaInput.value;
            
            fetch(`obtener_asientos_ocupados.php?id_pelicula=${peliculaId}&fecha=${fecha}&hora=${hora}`)
                .then(response => response.json())
                .then(asientosOcupados => {
                    generarAsientos(asientosOcupados);
                })
                .catch(error => console.error('Error:', error));
        }

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
            obtenerAsientosOcupados();
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
            const paymentDate = new Date(fechaInput.value);
            const formattedPaymentDate = paymentDate.toISOString().split('T')[0]; // Formato YYYY-MM-DD
            document.getElementById('selected-date').textContent = formattedPaymentDate;
            document.getElementById('selected-time').textContent = horaInput.value;
            document.getElementById('selected-room').textContent = document.getElementById('selected-room-display').textContent;
            document.getElementById('selected-format').textContent = formatoInput.value;
            document.getElementById('selected-seats').textContent = selectedSeats.join(', ');
            document.getElementById('total-amount').textContent = (selectedSeats.length * 10).toFixed(2);
        });

        // Volver al paso de selección de asientos desde el pago
        backToSeatsButton.addEventListener('click', backToSeats);

        async function loadPacificoFont() {
            try {
                const response = await fetch('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');
                const text = await response.text();
                const fontUrl = text.match(/https:\/\/.*?\.ttf/)[0];
                const fontResponse = await fetch(fontUrl);
                return await fontResponse.arrayBuffer();
            } catch (error) {
                console.error('Error al cargar la fuente Pacifico:', error);
                return null;
            }
        }

        async function generatePDF(data) {
            if (!data || typeof data !== 'object') {
                throw new Error('Datos inválidos para generar el PDF');
            }

            const requiredFields = ['pelicula_nombre', 'sala', 'hora_reserva', 'fecha_reserva', 'asientos', 'id_reserva', 'cliente_nombres', 'cliente_apellidos', 'total'];
            for (const field of requiredFields) {
                if (!data[field]) {
                    throw new Error(`Campo requerido faltante: ${field}`);
                }
            }

            const { jsPDF } = window.jspdf;
            if (!jsPDF) {
                throw new Error('La librería jsPDF no está disponible');
            }

            const doc = new jsPDF();
            
            try {
                const pageWidth = doc.internal.pageSize.width;
                const pageHeight = doc.internal.pageSize.height;

                // Función auxiliar para centrar texto
                const centerText = (text, y) => {
                    const textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
                    const textOffset = (pageWidth - textWidth) / 2;
                    doc.text(text, textOffset, y);
                };

                // Agregar logo y texto Cinesmero
                const logoWidth = 20;
                const logoHeight = 20;
                const logoX = 20;
                const logoY = 15;
                doc.addImage('./img/logoCine.png', 'PNG', logoX, logoY, logoWidth, logoHeight);
                doc.setFontSize(16);
                doc.setFont("helvetica", "bold");
                doc.text('Cinesmero', logoX + logoWidth + 5, logoY + (logoHeight / 2), { baseline: 'middle' });

                // Título de la película
                doc.setFontSize(24);
                doc.setFont("helvetica", "bold");
                centerText(data.pelicula_nombre, logoY + logoHeight + 15);

                // Instrucciones
                doc.setFontSize(10);
                doc.setFont("helvetica", "normal");
                centerText("Muestra el código QR desde tu celular para canjear tus combos e ingresar a la sala.", logoY + logoHeight + 25);

                // Detalles de la reserva
                const startY = logoY + logoHeight + 40;
                doc.setFontSize(14);
                doc.setFont("helvetica", "bold");
                doc.text("SALA", 20, startY);
                doc.text("HORA", 60, startY);
                doc.text("FECHA", 100, startY);
                doc.setFont("helvetica", "normal");
                doc.text(`${data.sala}`, 20, startY + 7);
                doc.text(data.hora_reserva, 60, startY + 7);
                doc.text(data.fecha_reserva, 100, startY + 7);
                doc.text(`Tus butacas: ${data.asientos}`, 20, startY + 14);

                // Entradas
                doc.setFontSize(16);
                doc.setFont("helvetica", "bold");
                doc.text('Entradas', 20, startY + 28); 
                doc.setFontSize(12);
                doc.setFont("helvetica", "normal");
                doc.text(`Nro. de Compra: ${data.id_reserva}`, 20, startY + 35); 
                doc.text(`Cliente: ${data.cliente_nombres} ${data.cliente_apellidos}`, 20, startY + 42); 
                const precioUnitario = (parseFloat(data.total) / data.asientos.split(',').length).toFixed(2);
                doc.text(`Entradas 2D a S/${precioUnitario}....Cant. ${data.asientos.split(',').length}`, 20, startY + 49); 
                doc.text(`SubTotal : S/ ${data.total}`, 20, startY + 56); 
                doc.setFont("helvetica", "bold");
                doc.setTextColor(255, 0, 0); 
                doc.text(`Total : S/ ${data.total}`, 20, startY + 63); 
                doc.setTextColor(0, 0, 0); 

                // Recuerda
                doc.setFontSize(14);
                doc.setFont("helvetica", "bold");
                doc.text('Recuerda', 20, startY + 76); 
                doc.setFontSize(10);
                doc.setFont("helvetica", "normal");
                doc.text('• Muestra tu Orden de Compra directamente desde tu celular, no es necesario imprimir.', 25, startY + 83); 
                doc.text('• El horario de la función indica el inicio de proyección de publicidad y avances de los próximos estrenos.', 25, startY + 88); 
                doc.text('• Luego de éstos, iniciará la película.', 25, startY + 93); 

                // Condiciones de compra
                doc.setFontSize(14);
                doc.setFont("helvetica", "bold");
                doc.text('Condiciones de compra', 20, startY + 106); 
                doc.setFontSize(10);
                doc.setFont("helvetica", "normal");
                doc.text('Estimado Cliente', 20, startY + 113); 
                doc.text('Para un mejor servicio realiza los siguientes pasos:', 20, startY + 118); 
                const conditions = [
                    'La compra y el canje de las entradas y/o combos, solo son válidos para el mismo día de la función.',
                    'Esta compra no permite cambio de función, anulación y/o devolución de dinero.',
                    'Presenta desde tu smartphone este documento con el código QR en el ingreso a salas. No tiene que pasar por boletería ni imprimirlo.',
                    'Dirígete directamente al ingreso de tu sala.',
                    'Cualquier duda respecto al pago, realízala directamente con tu banco emisor.',
                    '¡Sin colas! Dirígete directamente a la sala. No necesitas pasar por boletería.',
                    'Respetar los protocolos de prevención covid-19 en nuestras instalaciones por disposición del estado. Caso contrario el establecimiento se reserva el derecho de retirar a la persona de sala.'
                ];

                let conditionYPos = startY + 125; 
                conditions.forEach((condition, index) => {
                    doc.text(`• ${condition}`, 25, conditionYPos, { maxWidth: pageWidth - 50 });
                    conditionYPos += doc.getTextDimensions(`• ${condition}`, { maxWidth: pageWidth - 50 }).h + 2;
                });

                // Pie de página
                doc.setFontSize(8);
                doc.text('Cineplex S.A - Av. José Larco N° 663 – Pisos 4 - 5 - Miraflores - Lima - Lima.', 20, pageHeight - 10);

                return doc;
            } catch (error) {
                console.error('Error al generar el PDF:', error);
                throw new Error('Error al generar el PDF: ' + error.message);
            }
        }

        // Manejar el envío del formulario de pago
        document.querySelector('.payment-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            try {
                const formData = new FormData(this);
                
                // Add reservation data
                formData.append('pelicula_id', '<?php echo $idPelicula; ?>');
                formData.append('pelicula_nombre', document.getElementById('movie-name').textContent);
                formData.append('fecha_reserva', document.getElementById('selected-date').textContent);
                formData.append('hora_reserva', document.getElementById('selected-time').textContent);
                formData.append('sala', document.getElementById('selected-room').textContent);
                formData.append('formato', document.getElementById('selected-format').textContent);
                formData.append('asientos', selectedSeats.join(','));
                formData.append('total', document.getElementById('total-amount').textContent);

                const response = await fetch('procesar_reserva.php', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new TypeError("La respuesta del servidor no es JSON válido");
                }

                const data = await response.json();
                
                if (data.exito) {
                    // Ocultar el formulario de pago y el resumen de la compra
                    document.querySelector('.payment-form').style.display = 'none';
                    document.querySelector('.payment-summary').style.display = 'none';

                    // Ocultar el título "PAGO"
                    document.querySelector('.payment-container .section-title').style.display = 'none';

                    const confirmationMessage = `
                        <div class="reserva-confirmation">
                            <h2>¡Reserva Exitosa!</h2>
                            <p>Tu reserva para "${data.pelicula_nombre}" ha sido procesada correctamente.</p>
                            <button id="download-boleta" class="btn mt-3" style="background-color: #3D1313; color: white; border: 2px solid #F5E6D3;">Descargar boleta</button>
                        </div>
                    `;
                    document.querySelector('.payment-container').insertAdjacentHTML('beforeend', confirmationMessage);

                    // Asegúrate de que todos los datos necesarios estén disponibles
                    const pdfData = {
                        pelicula_nombre: data.pelicula_nombre,
                        sala: data.sala,
                        hora_reserva: data.hora_reserva,
                        fecha_reserva: data.fecha_reserva,
                        asientos: data.asientos,
                        id_reserva: data.id_reserva,
                        cliente_nombres: data.cliente_nombres,
                        cliente_apellidos: data.cliente_apellidos,
                        total: data.total
                    };

                    // Agregar evento al botón de descarga
                    document.getElementById('download-boleta').addEventListener('click', async function() {
                        try {
                            const pdf = await generatePDF(pdfData);
                            pdf.save(`boleta_reserva_${data.id_reserva}.pdf`);
                        } catch (error) {
                            console.error('Error al generar el PDF:', error);
                            alert('Hubo un error al generar la boleta: ' + error.message + '. Por favor, inténtelo de nuevo o contacte al soporte.');
                        }
                    });

                    // Actualizar los asientos ocupados después de una reserva exitosa
                    obtenerAsientosOcupados();
                } else {
                    throw new Error(data.mensaje || 'Error desconocido al procesar la reserva');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Ocurrió un error al procesar la reserva: ' + error.message);
            }
        });

        // Cargar horas para la primera fecha al cargar la página
        if (dateButtons.length > 0) {
            cargarHorasDisponibles(dateButtons[0].getAttribute('data-date'));
        }
    });
    </script>

</body>
</html>

