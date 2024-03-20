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
            Thank you for Password change request. Now you can change your password using below:(
                @if($role_id==1)
                  <a href="{{ env('AdminForgetPasswordLink').'/'.$token }}">link</a>
                @elseif($role_id==2)
                  <a href="{{ env('SellerForgetPasswordLink').'/'.$token }}">link</a>
                @elseif($role_id==3)
                  <a href="{{ env('BuyerForgetPasswordLink').'/'.$token }}">link</a>
                @endif
            )
        </p>
    </div>
</body>
</html>
