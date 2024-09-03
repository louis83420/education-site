<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Joy自學中心</title>
    <!-- 引入Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f0e6d6;
            font-family: 'Georgia', serif;
            color: #333;
            margin: 0;
            padding: 0;
            background-image: url('path-to-your-background-image.jpg');
            background-size: cover;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
            font-size: 3em;
        }

        .btn {
            margin: 10px;
            padding: 15px 30px;
            font-size: 1.2em;
            border-radius: 8px;
        }

        .container {
            text-align: center;
        }

        .content {
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome to Joy自學中心</h1>
        <div class="d-flex justify-content-center">
            <a href="{{ url('/home') }}" class="btn btn-primary">進入主頁</a>
            <a href="{{ url('/products') }}" class="btn btn-secondary">查看產品列表</a>
        </div>

        <div class="content mt-5">
            <p>
                在 Joy 自學中心，裡面有我的自学资源，幫助您在旅程中取得進步。
            </p>
        </div>
    </div>

    <!-- 引入Bootstrap JS和Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>