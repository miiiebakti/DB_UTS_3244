<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>

    <h2>Selamat {{ $transaction->customer_name }}</h2>

    <p>
        Terima kasih telah mengikuti event
        <strong>{{ $transaction->event->title }}</strong>.
    </p>

    <p>
        E-Sertifikat Anda kami lampirkan pada email ini.
    </p>

    <p>Salam,<br>Panitia Event</p>

</body>
</html>