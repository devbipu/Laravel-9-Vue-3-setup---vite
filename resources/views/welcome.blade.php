<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
        <main>
            <div class="container pt-5">
                <table class="table table-hover table-striped border">
                    <thead class="bg-secondary text-white">
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">name</th>
                          <th scope="col">Email</th>
                          <th scope="col">Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>-1</td>
                            <th>Bipu</th>
                            <td>bipu@gmail.com</td>
                            <td>Meherpur</td>
                        </tr>
                    </tbody>
                    <tfoot class="bg-secondary text-white text-center">
                        <tr>
                            <td colspan="5">Data Table </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </main>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
