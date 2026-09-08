<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8fafc;
            color: #333;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .container {
            max-width: 600px;
            padding: 20px;
        }

        h1 {
            font-size: 4em;
            margin-bottom: 0.5em;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 1em;
        }

        a {
            color: #3490dc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>{{ Constant::HTTP_CODE_ERROR_NOT_FOUND }}</h1>
        <p>Hal yang ada cari tidak ditemukan</p>
        <p><a href="{{ url('/') }}">Go to Homepage</a></p>
    </div>
</body>

</html>