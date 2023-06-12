<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['title'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #aaa5aa;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>{{ $data['title'] }}</h1>
        <br><br>
        <p>Hi, {{ $data['name'] }}</p>
        <p>{{ $data['body'] }}</p>
        <p>
            <a href="{{ $data['url'] }}" class="btn">Click here to verify your email</a>
        </p>
        <p>Thanks for signing up to SewaIN. Please verify your email and confirm that you are a
            not a mean robot.</p>
    </div>
</body>

</html>
