<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets/dist/css/login_page3.css') }}">
</head>

<body>

    <div class='box'>
        <div class='box-form'>
            <div class='box-login-tab'></div>
            <div class='box-login-title'>
                <div class='i i-login'></div>
                <h2>LOGIN</h2>
            </div>
            <div class='box-login'>
                <div class='fieldset-body' id='login_form'>
                    <button onclick="openLoginInfo();" class='b b-form i i-more' title='Mais Informações'></button>
                    <p class='field'>
                        <label for='user'>E-MAIL</label>
                        <input type='text' id='user' name='user' title='Username' />
                        <span id='valida' class='i i-warning'></span>
                    </p>
                    <p class='field'>
                        <label for='pass'>PASSWORD</label>
                        <input type='password' id='pass' name='pass' title='Password' />
                        <span id='valida' class='i i-close'></span>
                    </p>

                    <label class='checkbox'>
                        <input type='checkbox' value='TRUE' title='Keep me Signed in' /> Keep me Signed in
                    </label>

                    <input type='submit' id='do_login' value='GET STARTED' title='Get Started' />
                </div>
            </div>
        </div>
        <div class='box-info'>
            <p><button onclick="closeLoginInfo();" class='b b-info i i-left' title='Back to Sign In'></button>
            <h3>Need Help?</h3>
            </p>
            <div class='line-wh'></div>
            <button onclick="" class='b-support' title='Forgot Password?'> Forgot Password?</button>
            <button onclick="" class='b-support' title='Contact Support'> Contact Support</button>
            <div class='line-wh'></div>
            <button onclick="" class='b-cta' title='Sign up now!'> CREATE ACCOUNT</button>
        </div>
    </div>


    <div class='icon-credits'>Icons made by <a href="http://www.freepik.com" title="Freepik">Freepik</a>, <a
            href="http://www.flaticon.com/authors/budi-tanrim" title="Budi Tanrim">Budi Tanrim</a> & <a
            href="http://www.flaticon.com/authors/nice-and-serious" title="Nice and Serious">Nice and Serious</a> from
        <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed by <a
            href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0
            BY</a>
    </div>
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/login_page3.js') }}"></script>
</body>

</html>
