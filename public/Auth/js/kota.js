$(document).ready(function () {

    // Load data provinsi dari API eksternal
    $.getJSON('https://ibnux.github.io/data-indonesia/provinsi.json', function (data) {
        const provinsiSelect = $('#provinsi');

        $.each(data, function (index, provinsi) {
            provinsiSelect.append($('<option>', {
                value: provinsi.id,
                text: provinsi.nama
            }));
        });
    });

    // Ketika provinsi dipilih, load data kota sesuai provinsi
    $('#provinsi').on('change', function () {
        const idProvinsi = $(this).val();
        const kotaSelect = $('#kota');

        // Reset kota dan tampilkan loading
        kotaSelect.html('<option value="">Memuat kota...</option>');

        if (!idProvinsi) {
            kotaSelect.html('<option value="">Pilih Kota</option>');
            return;
        }

        // Ambil data kota berdasarkan ID provinsi
        $.getJSON(`https://ibnux.github.io/data-indonesia/kota/${idProvinsi}.json`, function (data) {
            kotaSelect.empty().append('<option value="">Pilih Kota</option>');

            $.each(data, function (index, kota) {
                kotaSelect.append($('<option>', {
                    value: kota.id,
                    text: kota.nama
                }));
            });
        });
    });

    $(document).ready(function () {
        const input = document.querySelector("#telepon");
        window.intlTelInput(input, {
            initialCountry: "id", // default Indonesia
            preferredCountries: ["id", "us", "sg", "my"],
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
        });
    });

    //hilangkan + secara otomatis
    $('#telepon').on('input', function () {
        this.value = this.value.replace(/\+/g, '');
    });

    window.intlTelInput(input, {
    initialCountry: "id",
    preferredCountries: ["id", "us", "sg", "my"],
    separateDialCode: true,
    nationalMode: true,
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
    });

});
