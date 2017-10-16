<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tic Tac Toe</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ elixir('css/app.css') }}" media="all">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>;
            document.cookie='resolution='+Math.max(screen.width,screen.height)+'; path=/';
        </script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div id="app" class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Tic Tac Toe
                </div>
                <tictactoe></tictactoe>
                <div class="links">
                    <a href="https://github.com/mrjusti/tictactoe">GitHub</a>
                    <a href="https://www.linkedin.com/in/hkleiman/">LinkedIn</a>
                </div>
            </div>
        </div>
        @include ('footer')
        <script src="{{ elixir('js/app.js') }}"></script>
    </body>
</html>
