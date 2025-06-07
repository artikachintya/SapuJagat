// document.addEventListener('DOMContentLoaded', function () {
//     // Lihat Detail Button
//      const stars = document.querySelectorAll('#rating-stars i');
//     let selectedOrderId = 0;
//     let currentUserId = 0;

//     const detailButtons = document.querySelectorAll('.lihat-detail-btn');
//     const modal = document.getElementById('historiModal');
//     const closeBtn = document.querySelector('.close-btn');

//     detailButtons.forEach(button => {
//         button.addEventListener('click', () => {
//             document.getElementById('modal-date').innerText = button.dataset.date || '-';
//             document.getElementById('modal-address').innerText = button.dataset.address || '-';
//             document.getElementById('modal-driver').innerText = button.dataset.driver || '-';
//             // document.getElementById('modal-summary').innerText = button.dataset.summary || '-';
//             document.getElementById('modal-summary').innerHTML = button.dataset.summary || '-';

//              selectedOrderId = button.dataset.orderId;
//         currentUserId = button.dataset.userId;

//             if (modal) modal.style.display = 'flex';

//             stars.forEach((star, index) => {
//         star.addEventListener('click', () => {
//             selectedRating = index + 1;

//             // Reset semua bintang
//             stars.forEach((s, i) => {
//                 s.classList.toggle('selected', i < selectedRating);
//                 s.classList.remove('fa-star');
//                 s.classList.add('fa-star-o');
//             });

//             // Highlight yang dipilih
//             for (let i = 0; i < selectedRating; i++) {
//                 stars[i].classList.remove('fa-star-o');
//                 stars[i].classList.add('fa-star');
//             }

//             // Kirim rating ke server
//             if (selectedOrderId && currentUserId && selectedRating) {
//                 fetch('/simpan-rating', {
//                     method: 'POST',
//                     headers: {
//                         'Content-Type': 'application/json',
//                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//                     },
//                     body: JSON.stringify({
//                         order_id: selectedOrderId,
//                         user_id: currentUserId,
//                         star_rating: selectedRating
//                     })
//                 })
//                 .then(res => res.json())
//                 .then(data => {
//                     if (data.success) {
//                         alert('Terima kasih atas rating Anda!');
//                         // Tutup modal setelah rating diberikan
//                         modal.style.display = 'none';
//                     }
//                 })
//                 .catch(err => {
//                     console.error('AJAX error:', err);
//                 });
//             }
//         });
//     });
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

// console.log('order_id:', selectedOrderId, 'user_id:', currentUserId, 'rating:', selectedRating);


// document.addEventListener('DOMContentLoaded', function () {
//     const stars = document.querySelectorAll('#rating-stars i');
//     let selectedRating = 0;

//     stars.forEach((star, index) => {
//         star.addEventListener('click', () => {
//             selectedRating = index + 1;

//             // Reset semua bintang
//             stars.forEach((s, i) => {
//                 s.classList.toggle('selected', i < selectedRating);
//                 s.classList.remove('fa-star');
//                 s.classList.add('fa-star-o');
//             });

//             // Highlight yang dipilih
//             for (let i = 0; i < selectedRating; i++) {
//                 stars[i].classList.remove('fa-star-o');
//                 stars[i].classList.add('fa-star');
//             }

//             // Kirim rating ke server (opsional AJAX)
//             console.log('Rating diberikan:', selectedRating);

//             // Contoh jika pakai fetch/AJAX:
//             /*
//             fetch('/simpan-rating', {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//                 },
//                 body: JSON.stringify({
//                     order_id: currentOrderId, // ambil ID dari data-* misalnya
//                     rating: selectedRating
//                 })
//             });
//             */
//         });

//         fetch('/simpan-rating', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//             },
//             body: JSON.stringify({
//                 order_id: selectedOrderId, // Ambil dari data-* di tombol/modal
//                 user_id: currentUserId,    // Bisa di-passing dari Blade pakai JS
//                 star_rating: selectedRating
//             })
//         })
//             .then(res => res.json())
//             .then(data => {
//                  console.log('response:', data);
//                 if (data.success) {
//                     alert('Terima kasih atas rating Anda!');
//                 }
//                 console.error('AJAX error:', err);
//             });


//     });
// });

document.addEventListener('DOMContentLoaded', function () {
    // Variables
    let selectedOrderId = 0;
    let currentUserId = 0;
    let selectedRating = 0;

    // Elements
    const detailButtons = document.querySelectorAll('.lihat-detail-btn');
    const modal = document.getElementById('historiModal');
    const closeBtn = document.querySelector('.close-btn');
    const fileInput = document.getElementById('inputGroupFile02');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const previewImage = document.getElementById('imagePreview');

    // Initialize star rating functionality
    function initStarRating() {
        // Get fresh reference to stars
        const stars = document.querySelectorAll('#rating-stars i');

        stars.forEach((star, index) => {
            // Remove all existing event listeners
            const newStar = star.cloneNode(true);
            star.replaceWith(newStar);

            newStar.addEventListener('click', () => {
                selectedRating = index + 1;

                // Update all stars
                stars.forEach((s, i) => {
                    if (i < selectedRating) {
                        s.classList.remove('far', 'fa-star');
                        s.classList.add('fas', 'fa-star');
                    } else {
                        s.classList.remove('fas', 'fa-star');
                        s.classList.add('far', 'fa-star');
                    }
                });

                // Send rating to server
                if (selectedOrderId && currentUserId && selectedRating) {
                    fetch('/simpan-rating', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            order_id: selectedOrderId,
                            user_id: currentUserId,
                            star_rating: selectedRating
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Terima kasih atas rating Anda!');
                            modal.style.display = 'none';
                        }
                    })
                    .catch(err => {
                        console.error('AJAX error:', err);
                    });
                }
            });

            // Hover effects
            newStar.addEventListener('mouseover', () => {
                const hoverValue = index + 1;
                stars.forEach((s, i) => {
                    if (i < hoverValue) {
                        s.style.transform = 'scale(1.2)';
                        s.style.color = '#FFD700';
                    }
                });
            });

            newStar.addEventListener('mouseout', () => {
                stars.forEach(s => {
                    s.style.transform = 'scale(1)';
                    // Only reset color if not selected
                    if (!s.classList.contains('fas')) {
                        s.style.color = '';
                    }
                });
            });
        });
    }

    // Detail button click handler
    detailButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Set modal content
            document.getElementById('modal-date').innerText = button.dataset.date || '-';
            document.getElementById('modal-address').innerText = button.dataset.address || '-';
            document.getElementById('modal-driver').innerText = button.dataset.driver || '-';
            document.getElementById('modal-summary').innerHTML = button.dataset.summary || '-';

            // Set order and user IDs
            selectedOrderId = button.dataset.orderId;
            currentUserId = button.dataset.userId;

            // Reset stars when opening modal
            const stars = document.querySelectorAll('#rating-stars i');
            stars.forEach(star => {
                star.classList.remove('fas', 'fa-star');
                star.classList.add('far', 'fa-star');
                star.style.color = '';
                star.style.transform = '';
            });
            selectedRating = 0;

            // Show modal
            if (modal) modal.style.display = 'flex';

            // Initialize star rating for this order
            initStarRating();
        });
    });

    // Close button handler
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            if (modal) modal.style.display = 'none';
        });
    }

    // Close modal when clicking outside
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Image preview handler
    if (fileInput && previewContainer && previewImage) {
        fileInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewImage.src = '#';
                previewContainer.style.display = 'none';
            }
        });
    }
});
