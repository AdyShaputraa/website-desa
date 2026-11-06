<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-light">
        <main class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h1 class="h3 mb-1">Laravel</h1>
                            <p class="text-body-secondary mb-4">Installation verification page</p>

                            <ul class="list-group list-group-flush mb-4">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Laravel</span>
                                    <strong>{{ app()->version() }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>PHP</span>
                                    <strong>{{ PHP_VERSION }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Bootstrap</span>
                                    <strong id="bootstrap-version">checking...</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>jQuery</span>
                                    <strong id="jquery-version">checking...</strong>
                                </li>
                            </ul>

                            <p class="mb-0">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                If this page is styled and the versions above are filled in, the setup is working.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script>
            $(function () {
                $('#bootstrap-version').text(window.bootstrap ? window.bootstrap.Tooltip.VERSION : 'not loaded');
                $('#jquery-version').text(window.jQuery ? window.jQuery.fn.jquery : 'not loaded');
            });
        </script>
    </body>
</html>
