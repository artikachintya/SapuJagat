function saveBankInfo() {
    const bankName = document.getElementById('bankName').value;
    const accountNumber = document.getElementById('accountNumber').value;

    // Set display
    document.getElementById('displayBankName').innerText = bankName;
    document.getElementById('displayAccountNumber').innerText = accountNumber;

    // Set hidden inputs
    document.getElementById('inputBankName').value = bankName;
    document.getElementById('inputAccountNumber').value = accountNumber;

    
    let bankLogo = 'bca.png'; // default
    if (bankName.toLowerCase() === 'mandiri') {
        bankLogo = 'mandiri.png';
    } else if (bankName.toLowerCase() === 'bri') {
        bankLogo = 'bri.png';
    }
    document.getElementById('bankLogo').src = `${assetBasePath}/${bankLogo}`;
    // document.getElementById('bankLogo').src = "{{ asset('dashboard-assets/assets/img/"+ bankLogo+"') }}";
    // document.getElementById('bankLogo').alt = bankName;

    // Close modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('bankModal'));
    modal.hide();
}
