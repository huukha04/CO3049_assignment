
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
        .label {
            display: flex;
            flex-direction: column;
            margin: 5px;
        }
        button {
            margin: 5px;
        }

    </style>

    <script src="https://code.jquery.com/jquery-latest.min.js"></script>

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
        <form method="POST" class="auth-form" action="">
            <div class="h3 mb-3 fw-normal">Please sign up</div>
            <div id="message" style="color: red; height: 30px;">
                <?php if (!empty($errors)) : ?> 
                    <?= implode("<br>", $errors) ?>
                <?php endif; ?>
            </div>
            <div class = "label">
                Tên tài khoản:
                <input id="user_name" type="text" name="user_name" required>
            </div>
            <div class = "label">
                Email:
                <input id="email" type="email" name="email" required>
            </div>
            <button id="getOtpBtn" type="button" onclick="getOTP()">Lấy mã OTP</button>
            <div class = "label">
                OTP:
                <input id="code" type="text" name="code" required>
            </div>
            

            <button id="button" type="submit">Sign Up</button>
            <div>
                Have you an account?
                <a href="<?= ROOT ?>auth/login">Sign In</a>
            </div>
        </form>
</body>
<script>
    function getOTP() {
    let message = document.getElementById("message");

    $.ajax({
        type: "POST",
        url: "<?= ROOT ?>auth/get_otp_forgot",
        data: { email: document.getElementById('email').value,
                user_name: document.getElementById('user_name').value
         },
        dataType: "json",  // Đảm bảo nhận JSON
        success: function(res) {
            message.textContent = res.message;
        },
        error: function(xhr, status, error) {
            console.error("Lỗi AJAX:", xhr.responseText);
            message.textContent = "Có lỗi xảy ra, vui lòng thử lại!";
        }
    });
}


</script>
</html>