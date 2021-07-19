
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | Se connecter</title>

    {!! Html::style('node_modules/noty/lib/noty.css') !!}
    {!! Html::style('node_modules/noty/lib/themes/sunset.css') !!}
    {!! Html::style('backend/css/main.css') !!}

    <style>
        @media (max-width: 767px) {
            .main-card {
                width: 95%;
                margin: auto;
                margin-top: 20%;
            }
        }
        @media (min-width: 767px) {
            .main-card {
                width: 33%;
                margin: auto;
                margin-top: 10%;
            }
        }

        body {
            background-image: url({{ asset('backend/assets/images/login_background.jpg') }})
        }
        .form-group {
            margin-bottom: 15px !important
        }
        .form-group label {
            width: 80px
        }
        .form-group input {
            max-width: 100%
        }
        button{
            margin: auto
        }
    </style>
</head>
<body>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">identificateurs</h5>
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                {!! Form::open([
                    'method' => 'POST',
                    'url'    => route('backend.login'),
                    'class'  => 'form-inline'
                ]) !!}
                    <div class="col-md-12 position-relative form-group">
                        <label for="exampleEmail22" class="mr-sm-2">Email</label>
                        <input name="email" id="exampleEmail22" placeholder="something@idk.cool" type="email" class="form-control">
                    </div>
                    <div class="col-md-12 position-relative form-group">
                        <label for="examplePassword22" class="mr-sm-2">Password</label>
                        <input name="password" id="examplePassword22" placeholder="don't tell!" type="password" class="form-control">
                    </div>
                    <button class="btn btn-primary">Se connecter</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    {!! Html::script('node_modules/jquery/dist/jquery.min.js') !!}
    {!! Html::script('node_modules/noty/lib/noty.min.js') !!}
    <script>
        $(document).ready(function(){
            @if(!empty(session()->has('success')))
                @if(session('success') == true)
                    new Noty({
                        type: 'success',
                        theme: 'sunset',
                        text: "{{ session('message') }}"
                    }).show();
                @elseif(session('success') == false)
                    new Noty({
                            type: 'error',
                            theme: 'sunset',
                            text: "{{ session('message') }}"
                        }).show();
                @endif
            @elseif(session()->has('error'))
                new Noty({
                        type: 'error',
                        theme: 'sunset',
                        text: "Une erreur est survenue"
                    }).show();
            @endif
        });
    </script>
</body>
</html>
