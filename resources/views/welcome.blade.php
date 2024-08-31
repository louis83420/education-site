<!DOCTYPE html>
<html lang="en">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>

<body>
    <h1>Welcome to Joy自學中心</h1>
    <a href="{{ url('/home') }}" class="btn btn-primary">進入主頁</a>
    <a href="{{ url('/products') }}" class="btn btn-secondary">查看產品列表</a>
</body>

</html>