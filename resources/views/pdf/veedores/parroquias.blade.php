<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <center>
        <strong style="font-size:20px">Reporte de veedores por parroquia</strong>
    </center>
    <br>
    <table border="1" width="100" style="width:100%;border-collapse: collapse">
        <thead>
            <tr>
                <th>Dni</th>
                <th>Apellidos y Nombres Completos</th>
                <th>Parroquia</th>
                <th>Responsable</th>

            </tr>
        </thead>
        <tbody>
            @foreach($veedores as $value )
            <tr>
            <td align="center">{{ $value->dni }}</td>
            <td align="center">{{ $value->first_name . " " . $value->last_name }}</td>
            <td align="center">{{ $value->nombre_parroquia }}</td>

            <td align="center">{{ $users->first_name . " " . $users->last_name}}</td>
            </tr>
            @endforeach

        </tbody>
    </table>
</body>
</html>
