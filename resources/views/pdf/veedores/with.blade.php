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
                <th>Apellidos y Nombres Completos</th>
                <th>Cantón</th>
                <th>Lugar de Origen</th>
                <th>Recinto de Trabajo</th>
                <th>Celular</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($veedores as $value )
            <tr>
            <td align="center">{{$value->dni}}</td>
            <td align="center">{{$value->nombres}}</td>
            <td align="center">{{$value->canton}}</td>
            <td align="center">{{$value->origen}}</td>
            <td align="center">{{$value->trabajo}}</td>
            <td align="center">{{$value->phone}}</td>
            <td align="center">{{$value->email}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
