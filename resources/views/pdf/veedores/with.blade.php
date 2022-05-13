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
        <strong>Reporte de Veedores</strong>
    </center>
    <br>

    <div class="header-horizontal">
        <div class="container-fluid" style="background-color: #ffd700">
            <a class="d-flex flex-row-reverse" href="#"></a>
            <img src="{{ public_path('/assets/media/logos/favicon.png') }}" alt="logo" width="65px" height="50px">
        </div>
    </div>

    <div class="container-fluid">

        <div class="card">
            <div class="card-body">
                @foreach ($veedores as $responsable)
                    <strong>Responsable:</strong> {{ $responsable->responsable }}
                @endforeach
            </div>
        </div>

        <div class="grid-margin">
            <table class="table table-bordered"> {{-- border="1" width="100" style="width:100%;border-collapse: collapse" --}}
                <thead class="thead-light">
                    <tr>
                        <th class="align-middle">Cédula <br>(10 Dígitos)</th>
                        <th class="align-middle">Apellidos y Nombres Completos</th>
                        <th class="align-middle">Cantón</th>
                        <th class="align-middle">Lugar de Votación</th>
                        <th class="align-middle">Recinto Electoral <br>Donde va a cuidar el voto</th>
                        <th class="align-middle">Celular</th>
                        <th class="align-middle">Correo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($veedores as $value)
                        <tr>
                            <td align="center">{{ $value->dni }}</td>
                            <td align="center">{{ $value->nombres }}</td>
                            <td align="center">{{ Str::title(Str::of($value->canton)->lower()) }}</td>
                            <td align="center">{{ Str::title(Str::of($value->origen)->lower()) }}</td>
                            <td align="center">{{ Str::title(Str::of($value->trabajo)->lower()) }}</td>
                            <td align="center">{{ $value->phone }}</td>
                            <td align="center">{{ $value->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
