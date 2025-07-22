<!-- resources/views/auth/otp.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ __('otp.title') }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f6f6; padding: 30px;">

    <div style="max-width: 600px; margin: auto; background-color: #e6ffed; border: 1px solid #b7eb8f; padding: 20px; border-radius: 8px;">

        <h2 style="color: #237804; text-align: center;">{{ __('otp.header') }}</h2>

        <p style="font-size: 16px; color: #333;">{{ __('otp.instructions') }}</p>

        <div style="text-align: center; margin: 30px 0;">
            <span style="display: inline-block; background-color: #52c41a; color: #fff; font-size: 28px; font-weight: bold; padding: 12px 30px; border-radius: 6px;">
                {{ $otp }}
            </span>
        </div>

        <p style="font-size: 14px; color: #666;">{!! __('otp.validity', ['minutes' => 1]) !!}</p>

        <hr style="border: none; border-top: 1px solid #d9d9d9; margin: 30px 0;">

        <p style="font-size: 14px; color: #cf1322; background-color: #fff1f0; padding: 10px; border: 1px solid #ffa39e; border-radius: 4px;">
            {!! __('otp.warning') !!}
        </p>
    </div>

</body>
</html>
