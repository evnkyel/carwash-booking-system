document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        const bookingId = this.getAttribute('data-id');
        showActionConfirmToast('delete', bookingId);
    });
});

document.querySelectorAll('.cancel-btn').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        const bookingId = this.getAttribute('data-id');
        showActionConfirmToast('cancel', bookingId);
    });
});

function showActionConfirmToast(action, bookingId) {
    const actionText = action === 'delete' ? 'delete this booking?' : 'cancel this booking?';
    const color = action === 'delete' ? '#f44336' : '#ff9800';

    const toastDiv = document.createElement('div');
    toastDiv.style.display = 'flex';
    toastDiv.style.flexDirection = 'column';
    toastDiv.style.alignItems = 'center';
    toastDiv.innerHTML = `
            <p style="margin-bottom:8px; font-weight:500;">Are you sure you want to <strong>${action}</strong> this booking?</p>
            <div style="display:flex; gap:10px;">
                <button id="yes-${action}-${bookingId}" style="background:${color};color:white;border:none;padding:5px 12px;border-radius:6px;cursor:pointer;">Yes</button>
                <button id="no-${action}-${bookingId}" style="background:#4caf50;color:white;border:none;padding:5px 12px;border-radius:6px;cursor:pointer;">No</button>
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
    });
    toast.showToast();

    document.getElementById(`yes-${action}-${bookingId}`).addEventListener('click', () => {
        confirmAction(action, bookingId);
        toast.hideToast();
    });

    document.getElementById(`no-${action}-${bookingId}`).addEventListener('click', () => {
        toast.hideToast();
    });
}

function confirmAction(action, bookingId) {
    fetch(`index.php?action=${action}&id=${bookingId}`, {
        method: 'GET'
    })
        .then(response => {
            if (response.ok) {
                if (action === 'delete') {
                    const row = document.querySelector(`#booking-${bookingId}`);
                    if (row) row.remove();
                } else if (action === 'cancel') {
                    const statusCell = document.querySelector(`#booking-${bookingId} .status`);
                    if (statusCell) statusCell.textContent = 'Cancelled';
                }

                Toastify({
                    text: `Booking deleted successfully!`,
                    duration: 3000,
                    gravity: "top",
                    position: "center",
                    style: {
                        background: "#4caf50"
                    }
                }).showToast();
            } else {
                Toastify({
                    text: `Failed to delete booking.`,
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