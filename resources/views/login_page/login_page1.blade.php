<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets/dist/css/login_page1.css') }}">
</head>

<body>
    <div class="parent clearfix">
        <div class="bg-illustration">
            <img src="http://iainmadura.ac.id/media/iainmadura.png" alt="logo">

            <div class="burger-btn">
                <span></span>
                <span></span>
                <span></span>
            </div>

        </div>

        <div class="login">
            <div class="container">
                <h1>Login to access to<br />your account</h1>

                <div class="login-form">
                    <form action="">
                        <input type="email" placeholder="E-mail Address">
                        <input type="password" placeholder="Password">

                        <div class="remember-form">
                            <input type="checkbox">
                            <span>Remember me</span>
                        </div>
                        <div class="forget-pass">
                            <a href="#">Forgot Password ?</a>
                        </div>

                        <button type="submit">LOG-IN</button>

                    </form>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
