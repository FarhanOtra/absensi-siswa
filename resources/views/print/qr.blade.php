<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>QR CODE</title>
  </head>
  <body class="text-center">
    <div class="mt-4 p-4">
        <img src="data:image/png;base64, {!! $qrcode !!}">
    </div>
    <br>
    <div>
        <h1>ABSENSI</h1>
        <h3>{{Carbon\Carbon::parse($attendance->date)->translatedFormat('l, d F Y')}}</h3>
    </div>
  </body>
</html>