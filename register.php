<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    $user = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $pass_confirm = $_POST['password_confirm'] ?? '';

    if (empty($user) || empty($email) || empty($pass) || empty($pass_confirm)) {
        echo "Please fill in all fields.";
        exit();
    }
    if (!preg_match('/^[\p{Arabic}a-zA-Z0-9_]{3,30}$/u', $user)) {
        echo "Username must be 3-30 characters and contain only Arabic, English letters, numbers, or _.";
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit();
    }
    if (strlen($pass) < 8) {
        echo "Password must be at least 8 characters.";
        exit();
    }
    if ($pass !== $pass_confirm) {
        echo "Passwords do not match.";
        exit();
    }

    
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $user, $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "Username or email is already taken.";
        exit();
    }
    $stmt->close();

    
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    $role = "user";
    $stmt_insert = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt_insert->bind_param("ssss", $user, $email, $hashed_password, $role);
    
    
    if ($stmt_insert->execute()) {
        setcookie('remember_email', $email, time() + (86400 * 30), "/");
        $_SESSION['user_id'] = $stmt_insert->insert_id;
        $_SESSION['username'] = $user;
        $_SESSION['role'] = $role;
        echo "success";
    } else {
        echo "An error occurred during registration. Please try again later.";
    }
    $stmt_insert->close();
    exit();
}

//AJAX WITH GET
if (isset($_GET['q'])) {
    $query = trim($_GET['q']);
    $emails = [];
    if (strlen($query) > 0) {
        $stmt = $conn->prepare("SELECT DISTINCT email FROM users WHERE email LIKE CONCAT(?, '%') LIMIT 5");
        $stmt->bind_param("s", $query);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $emails[] = $row['email'];
        }
        $stmt->close();
    }
    echo implode(',', $emails);
    exit();
}


if (isset($_GET['username'])) {
    $username = trim($_GET['username']);
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    echo $stmt->num_rows > 0 ? "username_taken" : "username_available";
    $stmt->close();
    exit();
}
if (isset($_GET['email'])) {
    $email_check = trim($_GET['email']);
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email_check);
    $stmt->execute();
    $stmt->store_result();
    echo $stmt->num_rows > 0 ? "email_taken" : "email_available";
    $stmt->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Register New Account - TAJ RESTAURANT</title>
    <style>
        body {
            background: linear-gradient(to right, rgb(42, 42, 42), rgb(44, 44, 44));
            font-family: 'Cairo', sans-serif;
            color: #fff;
            margin: 0; padding: 0;
            direction: ltr;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: rgba(255, 255, 255, 0.05);
            padding: 40px 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 25px rgba(0,0,0,0.4);
            backdrop-filter: blur(6px);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 28px;
            color: #FFD700;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #f8f8f8;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            margin-bottom: 20px;
            background-color: #f3f3f3;
            color: #333;
            font-size: 16px;
        }
        input:focus {
            outline: none;
            border: 2px solid #FFD700;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #FFD700;
            border: none;
            border-radius: 8px;
            color: #000;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #e5c100;
        }
        .message {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        .error {
            background-color: #330000;
            color: #ff9999;
        }
        .success {
            background-color: #003300;
            color: #99ff99;
        }
        p {
            text-align: center;
            margin-top: 20px;
        }
        a {
            color: #FFD700;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .check-message {
            font-size: 14px;
            margin-top: -15px;
            margin-bottom: 15px;
            color: #ff9999;
        }
        .check-message.valid {
            color: #99ff99;
        }
    </style>
</head>
<body>
    <form id="registerForm" autocomplete="off">
        <h2>Create New Account</h2>
        <div id="formMessage" class="message" style="display:none;"></div>

        <label for="username">Username</label>
        <input type="text" id="username" name="username" required minlength="3" maxlength="30" pattern="^[\u0600-\u06FFa-zA-Z0-9_]+$" title="Username must contain only Arabic, English letters, numbers, and _">
        <div id="usernameCheck" class="check-message"></div>

        <label for="email">Email</label>
        <input type="text" id="email" name="email" required list="email-list" autocomplete="off">
        <datalist id="email-list"></datalist>
        <div id="emailCheck" class="check-message"></div>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required minlength="8" autocomplete="new-password">

        <label for="password_confirm">Confirm Password</label>
        <input type="password" id="password_confirm" name="password_confirm" required minlength="8" autocomplete="new-password">

        <button type="submit">Register</button>

        <p>Already have an account? <a href="login.php">Login</a></p>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(function(){
        $('#email').on('input', function(){
            let query = $(this).val();
            if(query.length > 0){
                $.get('register.php', {q: query}, function(data){
                    let emails = data.split(',');
                    let datalist = $('#email-list');
                    datalist.empty();
                    emails.forEach(function(email){
                        if(email.trim() !== '') {
                            datalist.append('<option value="'+email.trim()+'"></option>');
                        }
                    });
                });
            }
        });

        
        $('#username').on('input', function(){
            let username = $(this).val();
            if(username.length >= 3){
                $.get('register.php', {username: username}, function(response){
                    if(response === 'username_taken'){
                        $('#usernameCheck').text('Username is already taken').removeClass('valid').addClass('error');
                    } else if(response === 'username_available'){
                        $('#usernameCheck').text('Username is available').removeClass('error').addClass('valid');
                    } else {
                        $('#usernameCheck').text('');
                    }
                });
            } else {
                $('#usernameCheck').text('');
            }
        });

        
        $('#email').on('input', function(){
            let email = $(this).val();
            if(email.length > 3){
                $.get('register.php', {email: email}, function(response){
                    if(response === 'email_taken'){
                        $('#emailCheck').text('Email is already taken').removeClass('valid').addClass('error');
                    } else if(response === 'email_available'){
                        $('#emailCheck').text('Email is available').removeClass('error').addClass('valid');
                    } else {
                        $('#emailCheck').text('');
                    }
                });
            } else {
                $('#emailCheck').text('');
            }
        });

        $('#registerForm').submit(function(e){
            e.preventDefault();
            $('#formMessage').hide().removeClass('error success').text('');

            $.ajax({
                url: '',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response){
                    if(response.trim() === 'success'){
                        $('#formMessage').show().addClass('success').text('Account created successfully! Redirecting...');
                        setTimeout(function(){
                            window.location.href = 'index.php';
                        }, 2000);
                    } else {
                        $('#formMessage').show().addClass('error').text(response);
                    }
                },
                error: function(){
                    $('#formMessage').show().addClass('error').text('Connection error.');
                }
            });
        });
    });
    </script>
</body>
</html>
