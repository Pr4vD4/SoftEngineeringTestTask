<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<p>User id: {{ $data['user_id'] }}</p>
<p>Note id: {{ $data['note']['id'] }}</p>
<p>{{ $data['note']['title'] }}</p>
<p>{{ $data['note']['note_body'] }}</p>

</body>
</html>
