<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
.container {
        max-width: 1200px;
    }
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
        }

        input[type="text"], input[type="password"] {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #error-message {
            text-align: center;
            margin-top: 10px;
        }

        .register-container {
            text-align: center;
            margin-top: 20px;
        }

        .register-text {
            margin-bottom: 10px;
        }

        .register-btn {
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }

        .register-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Đăng nhập</h1>
        <span id="success-message" style="display: none; color: green;"></span>
        <br>
        <form onsubmit="event.preventDefault(); loginUser();">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Đăng nhập">
        </form>
        <span id="error-message" style="display: none; color: red;"></span>
    </div>
    <div class="register-container">
        <p class="register-text">Bạn chưa có tài khoản? Vui lòng đăng ký</p>
        <a href="register.php" class="register-btn">Đăng ký</a>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
    if (window.location.search === "?registered=true") {
        document.getElementById("success-message").innerText = "Đăng ký thành công! Vui lòng đăng nhập.";
        document.getElementById("success-message").style.display = "block";
}
});

           function loginUser() {
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "login_user.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText === "success") {
                    location.href = "manage_links.php";
                } else {
                    document.getElementById("error-message").innerText = "Tên đăng nhập hoặc mật khẩu không đúng.";
                    document.getElementById("error-message").style.display = "block";
                }
            }
        };
        xhr.send("username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password));
    }
</script>

</body>
</html>
