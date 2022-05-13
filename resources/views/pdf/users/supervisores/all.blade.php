<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Styles -->
    <link href="{{ public_path('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <title>Document</title>
</head>

<body>
    <center>
        <strong style="font-size:20px">Reporte de Supervisores</strong>
    </center>
    <br>

    <div class="header-horizontal">
        <div class="container-fluid" style="background-color: #ffd700">
            <a class="d-flex flex-row-reverse" href="#"></a>
            <img src="{{ public_path('/assets/media/logos/favicon.png') }}" alt="logo" width="65px" height="50px">
        </div>
    </div>

    <div class="container-fluid">

        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle">Cédula <br>(10 Dígitos)</th>
                    <th class="align-middle">Nombre</th>
                    <th class="align-middle">Apellido</th>
                    <th class="align-middle">Teléfono</th>
                    <th class="align-middle">Email</th>
                    <th class="align-middle">Parroquia</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($supervisores as $value)
                    <tr>
                        <td align="center">{{ $value->dni }}</td>
                        <td align="center">{{ $value->first_name }}</td>
                        <td align="center">{{ $value->last_name }}</td>
                        <td align="center">{{ $value->phone }}</td>
                        <td align="center">{{ $value->email }}</td>
                        <td align="center">{{ Str::title(Str::of($value->parroquia->nombre_parroquia)->lower()) }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
