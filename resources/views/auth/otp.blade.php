<!-- auth/otp.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kode OTP Anda</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f6f6; padding: 30px;">

    <div style="max-width: 600px; margin: auto; background-color: #e6ffed; border: 1px solid #b7eb8f; padding: 20px; border-radius: 8px;">
        
        <h2 style="color: #237804; text-align: center;">Kode OTP Anda</h2>

        <p style="font-size: 16px; color: #333;">Gunakan kode di bawah ini untuk masuk ke akun Anda:</p>

        <div style="text-align: center; margin: 30px 0;">
            <span style="display: inline-block; background-color: #52c41a; color: #fff; font-size: 28px; font-weight: bold; padding: 12px 30px; border-radius: 6px;">
                {{ $otp }}
            </span>
        </div>

        <p style="font-size: 14px; color: #666;">Kode ini berlaku selama <strong>5 menit</strong>.</p>

        <hr style="border: none; border-top: 1px solid #d9d9d9; margin: 30px 0;">

        <p style="font-size: 14px; color: #cf1322; background-color: #fff1f0; padding: 10px; border: 1px solid #ffa39e; border-radius: 4px;">
            ⚠️ <strong>Jangan bagikan kode ini kepada siapa pun</strong>, termasuk pihak yang mengaku dari tim kami.
        </p>
    </div>

</body>
</html>
