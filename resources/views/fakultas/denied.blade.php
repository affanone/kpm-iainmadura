<!DOCTYPE html>
<html>

<head>
    <title>Access Denied</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            animation: change-background 25s infinite;
        }

        p {
            font-size: 28;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #e4ff16;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            padding: 30px;
        }

        a {
            display: inline-block;
            margin-top: 12px;
            padding: 12px 24px;
            background-color: #303030;
            color: #FFFFFF;
            font-size: 24px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-decoration: none;
            border-radius: 4px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #000000;
        }

        @keyframes change-background {
            0% {
                background-color: #000000;
            }

            25% {
                background-color: #333333;
            }

            50% {
                background-color: #666666;
            }

            75% {
                background-color: #999999;
            }

            100% {
                background-color: #CCCCCC;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <p>{{ $message }}</p>
        <a href="{{ route('fakultas.dashboard') }}">Kembali</a>
    </div>
</body>

</html>
