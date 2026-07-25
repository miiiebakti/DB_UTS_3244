<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>E-Certificate</title>

    <style>
        body{
            font-family: DejaVu Sans;
            text-align:center;
            padding-top:120px;
        }

        h1{
            font-size:42px;
        }

        h2{
            font-size:30px;
            margin-top:30px;
        }

        p{
            font-size:18px;
        }
    </style>

</head>
<body>

<h1>SERTIFIKAT</h1>

<p>Diberikan kepada</p>

<h2>{{ $transaction->customer_name }}</h2>

<p>Telah mengikuti event</p>

<h3>{{ $transaction->event->title }}</h3>

<p>
Tanggal Event :
{{ \Carbon\Carbon::parse($transaction->event->date)->format('d F Y') }}
</p>

</body>
</html>