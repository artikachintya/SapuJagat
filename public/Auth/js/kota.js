$(document).ready(function () {
    // Load data provinsi
    $.getJSON('https://ibnux.github.io/data-indonesia/provinsi.json', function (data) {
        const provinsiSelect = $('#province');

        $.each(data, function (index, provinsi) {
            provinsiSelect.append($('<option>', {
                value: provinsi.nama, // simpan nama bukan ID
                text: provinsi.nama
            }));
        });
    });

    // Load data kota saat provinsi dipilih
    $('#province').on('change', function () {
        const selectedProvinsi = $(this).val();
        const kotaSelect = $('#city');

        kotaSelect.html('<option value="">Memuat kota...</option>');

        if (!selectedProvinsi) {
            kotaSelect.html('<option value="">Pilih Kota</option>');
            return;
        }

        // Cari ID provinsi berdasarkan nama (karena kita simpan nama di option)
        $.getJSON('https://ibnux.github.io/data-indonesia/provinsi.json', function (provinsiData) {
            const matched = provinsiData.find(p => p.nama === selectedProvinsi);
            if (!matched) return;

            const idProvinsi = matched.id;

            // Ambil kota berdasarkan ID provinsi
            $.getJSON(`https://ibnux.github.io/data-indonesia/kota/${idProvinsi}.json`, function (data) {
                kotaSelect.empty().append('<option value="">Pilih Kota</option>');

                $.each(data, function (index, city) {
                    kotaSelect.append($('<option>', {
                        value: city.nama,
                        text: city.nama
                    }));
                });
            });
        });
    });

    $(document).ready(function () {
        if (oldProvince) {
            $('#province').val(oldProvince).trigger('change');
        }

        // Saat data kota di-load (kota.js)
        // tunggu data kota selesai dimuat
        setTimeout(() => {
            if (oldCity) {
                $('#city').val(oldCity).trigger('change');
            }
        }, 500); // ubah jika load kota lebih cepat/lambat
    });


    $(document).ready(function () {
        const input = document.querySelector("#phone_num");
        window.intlTelInput(input, {
            initialCountry: "id", // default Indonesia
            preferredCountries: ["id", "us", "sg", "my"],
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
        });
    });

    //hilangkan + secara otomatis
    $('#phone_num').on('input', function () {
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
