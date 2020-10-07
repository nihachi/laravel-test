<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Laravel Test</title>

        <!-- Fonts -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script>
            WebFont.load({
                google:{ 
                    "families": ["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]
                },
                active: function() {
                    sessionStorage.fonts = true;
                }
            });
        </script>
        <!-- CSS -->
        <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
    </head>
    <body>
        <div class="main-wrapper" id="app">
            <main-app></main-app>
        </div>
        <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    </body>
</html>
