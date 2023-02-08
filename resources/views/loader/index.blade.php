<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="http://iainmadura.ac.id/media/iainmadura.png" type="image/x-icon">
    <title>Aplikasi KPM {{ date('Y') }}</title>
    <style>
        body {
            height: 100vh;
            width: 100vw;
            margin: 0px;
            padding: 0px;
            display: flex;
            align-items: center;
            justify-content: center;
            /* background: #1a1a1a; */
            background: #343a40;
        }

        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 160px;
            width: 170px;
            position: relative;
            margin: 0px;
            padding: 0px;
        }

        img {
            width: 50%;
            position: absolute;
            top: -205px;
            background: #eee;
            padding: 5px;
            border-radius: 50%;
            border: 2px solid gold;
            background-position: center center;
            background-size: cover;
            background-repeat: no-repeat;
        }

        h4 {
            position: absolute;
            top: -145px;
            font-size: 2.5em;
            letter-spacing: 0.15em;
            font-weight: 100;
            width: max-content;
            color: #eee;
            filter: drop-shadow(2px 2px 15px #ffffff70);
            font-family: roboto, sans-serif;
        }

        p {
            font-family: roboto, sans-serif;
            /* color: #eee; */
            color: transparent;
            position: relative;
            overflow: hidden;
            /* position: absolute; */
            top: 175px;
            font-size: 1.5em;
            letter-spacing: 0.15em;
            font-weight: 100;
            filter: drop-shadow(2px 2px 15px #ffffff70);
        }

        .circle {
            border: 5px transparent solid;
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 69%;
        }

        .cyan {
            top: 0px;
            border-top: 5px #008000 solid;
            animation-delay: 4s;
            animation: cyan 1.5s infinite;
        }

        /*:after element = circle at the end of each line.
:before element = cap in be start of each line*/
        .cyan:after {
            position: absolute;
            content: "";
            width: 10px;
            height: 10px;
            background: #008000;
            border-radius: 69%;
            right: 5px;
            top: 10px;
            box-shadow: 0px 0px 20px #008000;
        }

        .cyan:before {
            content: " ";
            width: 5px;
            height: 5px;
            position: absolute;
            background: #008000;
            top: 10px;
            left: 11px;
            border-radius: 69%;
        }

        .magenta {
            left: 0px;
            bottom: 0px;
            border-top: 5px #990000 solid;
            animation: magenta 1.5s infinite;
        }

        .magenta:after {
            position: absolute;
            content: "";
            width: 10px;
            height: 10px;
            background: #990000;
            border-radius: 69%;
            right: 5px;
            top: 10px;
            box-shadow: 0px 0px 20px #990000;
        }

        .magenta:before {
            content: " ";
            width: 5px;
            height: 5px;
            position: absolute;
            background: #990000;
            top: 10px;
            left: 11px;
            border-radius: 69%;
        }

        .yellow {
            right: 0px;
            bottom: 0px;
            border-top: 5px #cc9933 solid;
            animation: yellow 1.5s infinite;
        }

        .yellow:after {
            position: absolute;
            content: "";
            width: 10px;
            height: 10px;
            background: #cc9933;
            border-radius: 69%;
            right: 5px;
            top: 10px;
            box-shadow: 0px 0px 20px #cc9933;
        }

        .yellow:before {
            content: " ";
            width: 5px;
            height: 5px;
            position: absolute;
            background: #cc9933;
            top: 10px;
            left: 11px;
            border-radius: 69%;
        }

        @keyframes cyan {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes magenta {
            0% {
                transform: rotate(240deg);
            }

            100% {
                transform: rotate(600deg);
            }
        }

        @keyframes yellow {
            0% {
                transform: rotate(120deg);
            }

            100% {
                transform: rotate(480deg);
            }
        }

        p::before {
            content: "Loading...";
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            border-right: 4px solid #eee;
            overflow: hidden;
            color: #eee;
            animation: load91371 3s linear infinite;
        }

        @keyframes load91371 {

            0%,
            10%,
            100% {
                width: 0;
            }

            10%,
            20%,
            30%,
            40%,
            50%,
            60%,
            70%,
            80%,
            90%,
            100% {
                border-right-color: transparent;
            }

            11%,
            21%,
            31%,
            41%,
            51%,
            61%,
            71%,
            81%,
            91% {
                border-right-color: #eee;
            }

            60%,
            80% {
                width: 100%;
            }
        }

        @media (max-height: 992px) and (max-width: 768px) {
            img {
                width: 30%;
                top: -165px;
            }

            h4 {
                font-size: 20px;
                top: -110px;
                width: fit-content;
                text-align: center;
            }
        }

        #text-checking {
            font-family: roboto, sans-serif;
            color: white;
            position: absolute;
            top: 240px;
            width: 400px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="loading">
        <img src="http://iainmadura.ac.id/media/iainmadura.png" alt="Logo">
        <h4>Aplikasi KPM IAIN Madura</h4>
        <div class="circle cyan"></div>
        <div class="circle magenta"></div>
        <div class="circle yellow"></div>
        {{-- <p id="is-loading">Loading...</p> --}}
        <div id="text-checking">LOADING...</div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script>
        function cekSKS() {
            $('#text-checking').text('Cek minimal SKS yang ditempuh..!');
            $.ajax({
                type: 'post',
                url: 'reg/sks',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: res => {
                    if (res.next) {
                        cekNilai();
                    } else {
                        alert(res.message);
                    }
                }
            })
        }

        function cekNilai() {
            $('#text-checking').text('Cek Matakuliah KPM..!');
            $.ajax({
                type: 'post',
                url: 'reg/mk',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: res => {
                    if (res.next) {
                        // cekNilai();
                    } else {
                        alert(res.message);
                    }
                }
            })
        }
        cekSKS();
    </script>
</body>

</html>
