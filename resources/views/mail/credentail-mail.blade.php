<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <div class="" style="width: 100%">
        <p>
            Thank you for signing up account with Market Database. Now you can access your account by signing in your account through following <a href="{{ env('SellerLoginLink') }}">Login Link</a>
        </p>
    </div>
    <br />
    <p>Please note down your login credentials:</p>
    <br />
    <p>Email : {{ $email }}</p>
    <p>Passoword : {{ $password }}</p>
    <br />

    {{-- <div class="" style="width : 100%">
        <p>
            <span style="color: red;">Pease do not reply email </span> to following email address:
            <a href="mailto:noreply@assessbr.com">noreply@assessbr.com</a> . Emails received at <a
                href="mailto:noreply@assessbr.com">noreply@assessbr.com</a> are not viewed, read, or answered. So
            AssessBR
            will not be responsible for any delays or not responding such emails.
        </p>
        <p>

            If you have any queries regarding setting up your account, pricing or other general queries, please do
            not
            hesitate to contact us at: <a href="mailto:admin@assessbr.com">admin@assessbr.com</a>
            <br />
        </p>
        <p>

            If you have any queries regarding your orders, please contact us at: <a
                href="mailto:orders@assessbr.com.">orders@assessbr.com.</a>
            <br />
            <br />
            Thank you
        </p>

    </div>
    <p style="width: 100%">
        Customer Service Team
    </p>
    <a class="ml-2 me-auto" href="https://creditreport.developer-hi.xyz/">
        <img style="width: 150px" src="{{ asset('./assets/img/assessbr.png') }}"
            alt="access br" />
    </a> --}}
</body>

</html>
