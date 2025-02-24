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

        .auth-form {
            display: flex;
            flex-direction: column;
            border: 1px solid black;
            border-radius: 5px;
            padding: 10px;
            width: 300px;
        }
        label {
            display: flex;
            flex-direction: column;
            margin: 5px;
        }
        button {
            margin: 5px;
        }

    </style>


</head>

<body>
    <div class="header">
        <a href='<?= ROOT ?>auth/home'>MyWeb</a>
        <div class="auth-links">
                    <a href="<?= ROOT ?>auth/login">Login</a>
                    <a href="<?= ROOT ?>auth/register">Register</a>
        </div>
       
    </div>

    <div class="main">
        <form method="POST" class="auth-form">
            <div class="h3 mb-3 fw-normal">Please sign in</div>
            <div id="errorMessage" style="color: red; height: 30px;">
                <?php if (!empty($errors)) : ?> 
                    <?= implode("<br>", $errors) ?>
                <?php endif; ?>
            </div>
            <label>
                Tài khoản:
                <input id="account" type="text" name="account">
            </label>
            <label>
                Mật khẩu:
                <input type="password" name="password">
            </label>
            <div>
                <a href="<?= ROOT ?>auth/forgot_password">forgot password</a>
            </div>
            <button type="submit">Sign In</button>
            <div>
                Don't have an account?
                <a href="<?= ROOT ?>auth/register">Sign Up</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById("account").addEventListener("input", function () {
            let accountInput = this.value.trim();
            let errorMessage = document.getElementById("errorMessage");

            let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            let usernameRegex = /^[a-zA-Z0-9_]+$/;

            if (emailRegex.test(accountInput)) {
                this.name = "email";
                errorMessage.textContent = "";
            } else if (usernameRegex.test(accountInput)) {
                this.name = "user_name"; 
                errorMessage.textContent = "";
            }
        });
    </script>
</body>


</html>