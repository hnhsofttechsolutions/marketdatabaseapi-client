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
            Thank you for Signup. Please Varify Your Email:
            {{-- (<a href="{{ env('VerifyEmailLink').'/'.$token }}">link</a>) --}}
            <br>
            {{$token}}
                
        </p>
    </div>
</body>
</html>
