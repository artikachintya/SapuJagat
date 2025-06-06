// document.addEventListener('DOMContentLoaded', function () {
//     // Lihat Detail Button
//     const detailButtons = document.querySelectorAll('.lihat-detail-btn');
//     const modal = document.getElementById('historiDriverModal');
//     const closeBtn = document.querySelector('.close-btn');

//     detailButtons.forEach(button => {
//         button.addEventListener('click', () => {
//             document.getElementById('modal-date').innerText = button.dataset.date || '-';
//             document.getElementById('modal-address').innerText = button.dataset.address || '-';
//             document.getElementById('modal-user').innerText = button.dataset.user || '-';
//             // document.getElementById('modal-summary').innerText = button.dataset.summary || '-';
//              document.getElementById('modal-photo').innerHTML = button.dataset.photo || '-';

//             const photoSrc = button.dataset.photo;
//             const photos=button.dataset.photos;
//             // alert(photos);
//             const imgElement = document.getElementById('modal-photo');
//             if (photoSrc!==photos) {
//                 imgElement.src = photoSrc;
//                 imgElement.style.display = 'block';
//             } else {
//                 imgElement.style.display = 'none';
//                 document.getElementById('photo-none').innerText = 'None';
//             }

//             // const statusElement = document.getElementById('modal-status');
//             // statusElement.innerText = button.dataset.status;
//             // statusElement.className = 'badge mb-1 ' + button.dataset.statusClass;

//             if (modal) modal.style.display = 'flex';
//         });
//     });

//     // Close Button
//     if (closeBtn) {
//         closeBtn.addEventListener('click', () => {
//             if (modal) modal.style.display = 'none';
//         });
//     }

//     // Close modal when clicking outside content
//     window.addEventListener('click', function (event) {
//         if (event.target === modal) {
//             modal.style.display = 'none';
//         }
//     });

//     // Image Preview Handler
//     const fileInput = document.getElementById('inputGroupFile02');
//     const previewContainer = document.getElementById('imagePreviewContainer');
//     const previewImage = document.getElementById('imagePreview');

//     if (fileInput && previewContainer && previewImage) {
//         fileInput.addEventListener('change', function (event) {
//             const file = event.target.files[0];
//             if (file) {
//                 const reader = new FileReader();
//                 reader.onload = function (e) {
//                     previewImage.src = e.target.result;
//                     previewContainer.style.display = 'block';
//                 };
//                 reader.readAsDataURL(file);
//             } else {
//                 previewImage.src = '#';
//                 previewContainer.style.display = 'none';
//             }
//         });
//     }
// });

document.addEventListener('DOMContentLoaded', function () {
    const detailButtons = document.querySelectorAll('.lihat-detail-btn');
    const modal = document.getElementById('historiDriverModal');
    const closeBtn = document.querySelector('.close-btn');

    detailButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Set modal content
            document.getElementById('modal-arrival').textContent = button.dataset.arrival || '-';
            document.getElementById('modal-pickup').textContent = button.dataset.pickup || '-';
            document.getElementById('modal-start').textContent = button.dataset.start || '-';
            document.getElementById('modal-address').textContent = button.dataset.address || '-';
            document.getElementById('modal-user').textContent = button.dataset.user || '-';

            // Handle photo display
            const photoSrc = button.dataset.photo;
            const imgElement = document.getElementById('modal-photo');
            const photoNoneElement = document.getElementById('photo-none');

            if (photoSrc && photoSrc !== button.dataset.photos) {
                imgElement.src = photoSrc;
                imgElement.style.display = 'block';
                photoNoneElement.textContent = '';
            } else {
                imgElement.style.display = 'none';
                photoNoneElement.textContent = 'Tidak ada foto bukti';
            }

            // Show modal
            if (modal) modal.style.display = 'flex';
        });
    });

    // Close modal
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            if (modal) modal.style.display = 'none';
        });
    }

    // Close when clicking outside
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});
