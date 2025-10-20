document.querySelectorAll('.cancel-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const bookingId = this.getAttribute('data-id');
        showConfirmToast(bookingId);
    });
});

function showConfirmToast(bookingId) {
    const toastDiv = document.createElement('div');
    toastDiv.style.display = 'flex';
    toastDiv.style.flexDirection = 'column';
    toastDiv.style.alignItems = 'center';
    toastDiv.innerHTML = `
        <p style="margin-bottom:8px; font-weight:500;">Are you sure you want to cancel this booking?</p>
        <div style="display:flex; gap:10px;">
            <button id="yes-${bookingId}" style="background:#f44336;color:white;border:none;padding:5px 12px;border-radius:6px;cursor:pointer;">Yes</button>
            <button id="no-${bookingId}" style="background:#4caf50;color:white;border:none;padding:5px 12px;border-radius:6px;cursor:pointer;">No</button>
        </div>
    `;

    const toast = Toastify({
        node: toastDiv,
        duration: -1,
        close: false,
        gravity: "top",
        position: "center",
        style: {
            background: "#4d4d4d",
            borderRadius: "10px",
            padding: "12px 16px",
            color: "#fff",
            textAlign: "center",
            minWidth: "280px"
        }
    }).showToast();

    document.getElementById(`yes-${bookingId}`).addEventListener('click', () => {
        confirmCancel(bookingId);
        toast.hideToast();
    });

    document.getElementById(`no-${bookingId}`).addEventListener('click', () => {
        toast.hideToast();
    });
}

function confirmCancel(bookingId) {
    fetch('cancel_booking.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'booking_id=' + bookingId
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = document.querySelector('#booking-' + bookingId);
                row.querySelector('.status').textContent = 'Cancelled';
                row.querySelector('.status').className = 'status Cancelled';
                row.querySelector('.cancel-btn')?.remove();

                Toastify({
                    text: "Booking cancelled successfully!",
                    duration: 3000,
                    gravity: "top",
                    position: "center",
                    style: {
                        background: "#4caf50"
                    }
                }).showToast();
            } else {
                Toastify({
                    text: "Failed to cancel booking.",
                    duration: 3000,
                    gravity: "top",
                    position: "center",
                    style: {
                        background: "#f44336"
                    }
                }).showToast();
            }
        });
}