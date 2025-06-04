

function initMap() {
    const location = {
        lat: -6.2,
        lng: 106.816666
    }; // Jakarta
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: location
    });

    new google.maps.Marker({
        position: location,
        map: map,
        title: "Lokasi Anda"
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photo-preview');

    if (photoInput && photoPreview) {
        photoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                    photoPreview.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            }
        });
    }
});

