<!DOCTYPE html>
<html>
<head>
    <title>Cinema Funcional</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Cinema Funcional</h1>
    <div class="movie-list">
        <?php
        $movies = [
            ['title' => 'Filme 1', 'description' => 'Descrição do Filme 1', 'showtime' => '19:00'],
            ['title' => 'Filme 2', 'description' => 'Descrição do Filme 2', 'showtime' => '21:30'],
        ];

        foreach ($movies as $movie) {
            echo '<div class="movie-card">';
            echo '<h2>' . $movie['title'] . '</h2>';
            echo '<p>' . $movie['description'] . '</p>';
            echo '<p>Horário: ' . $movie['showtime'] . '</p>';
            echo '<button class="book-button" onclick="bookTicket(\'' . $movie['title'] . '\')">Reservar Ingresso</button>';
            echo '</div>';
        }
        ?>
    </div>

    <div id="booking-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Reservar Ingresso</h2>
            <form>
                <label for="name">Nome:</label>
                <input type="text" id="name" required>
                <label for="email">E-mail:</label>
                <input type="email" id="email" required>
                <button type="button" id="confirm-booking">Confirmar Reserva</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
