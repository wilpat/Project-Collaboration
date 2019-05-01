<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laracasts</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="/css/app.css">
        <style>
           
        </style>
    </head>
    <body>
        <div id="app">
            <div class="container mx-auto">
                <header>
                    Laracasts
                </header>
                <main>
                    <aside>
                        <router-link :to="{ name: 'home' }">Home</router-link>
                        <router-link :to="{ name: 'about' }">About</router-link>
                    </aside>

                    <div class="primary">
                        <router-view></router-view>
                    </div>
                </main>
            </div>

        </div>
        <script type="text/javascript" src="/js/app.js"></script>
    </body>
</html>
