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
        <strong style="font-size:20px">Reporte de veedores</strong>
    </center>
    <br>
    <table border="1" width="100" style="width:100%;border-collapse: collapse">
        <thead>
            <tr>
                <th>Dni</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Coordinador</th>
                <th>Trabajo</th>
                <th>Parroquia</th>
            </tr>
        </thead>
        <tbody>
            @foreach($veedores as $value )
            <tr>
            <td align="center">{{$value->dni}}</td>
            <td align="center">{{$value->first_name}}</td>
            <td align="center">{{$value->last_name}}</td>
            <td align="center">{{$value->phone}}</td>
            <td align="center">{{$value->email}}</td>
            <td align="center">{{$value->user}}</td>
            <td align="center">{{$value->nombre_recinto}}</td>
            <td align="center">{{$value->nombre_parroquia}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>