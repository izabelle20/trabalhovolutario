
// script.js
function bookTicket(movieTitle) {
    const modal = document.getElementById('booking-modal');
    modal.style.display = 'block';

    document.getElementById('confirm-booking').addEventListener('click', function (e) {
        e.preventDefault();

        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;

        if (name && email) {
            // Simulação de uma API de reserva de ingressos
            const reservationData = {
                movie: movieTitle,
                name: name,
                email: email,
            };

            // Aqui você pode enviar os dados da reserva para uma API real
            // usando fetch() ou outra biblioteca de requisições HTTP.

            closeModal();
            alert('Reserva confirmada para ' + name + ' (' + email + ').');
        } else {
            alert('Por favor, preencha todos os campos.');
        }
    });
}

function closeModal() {
    const modal = document.getElementById('booking-modal');
    modal.style.display = 'none';
}
