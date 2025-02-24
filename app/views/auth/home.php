<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signin Template · Bootstrap v5.3</title>

    <link href="<?= ROOT ?>/asset/css/main.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;

            height: 100vh;
            background-color: #f8f9fa;
            margin: auto;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            
            background-color:rgb(25, 65, 105);
            padding: 10px 20px;
            height: 50px;
        }
        .header a {
            text-decoration: none;
            padding: 0 10px;
            color: #f8f9fa;
        }
        .auth-links a:first-child {
            border-right: 1px solid white;;
        }
        .main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding: 30px;
        }

    </style>


</head>

<body >
    <div class="header">
        <a href='<?= ROOT ?>auth/home'>MyWeb</a>
        <div class="auth-links">
        <a href="<?= ROOT ?>auth/login">Login</a>
        <a href="<?= ROOT ?>auth/register">Register</a>
        </div>
       
    </div>
    <div class="main">
        <div class="h3 mb-3 fw-normal">Welcome to MyWeb</div>
        <div class="h3 mb-3 fw-normal">Hi, User</div>
        <div class="h3 mb-3 fw-normal">Cover for building simple and beautiful home pages. Download, edit the text, and add your own fullscreen background photo to make it your own.</div>
        <div class="">Learn more</div>           
    </div>

</body>

</html>