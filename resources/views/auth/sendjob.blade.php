<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New Job</title>
        
</head>
<body>
        
        <div class="content">
                <div class="md-card">
                        <h1>{{ config('app.name', 'aTradies') }}</h1>
                        <p style="font-size: 20px">Hey dear {{$user->name}}! 👌</p>
                        <p style="color: green">Dear Employee You have a new job !</p>
                        <p>Stay in touch, available in your dashboard.</p>
                        <p>Do you need  this job ?</p>
                        <p>Click at bellow, our most popular job</p>
                        <a href="{{$url}}">Click it</a>
                </div>
        </div>

</body>
</html>
