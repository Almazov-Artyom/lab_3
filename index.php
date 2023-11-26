<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth</title>
    <style>
    body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        .auth-form {
            width: 300px;
            padding: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 300px; /* Установите фиксированную высоту формы */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .auth-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .auth-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: border-color 0.3s ease-in-out;
        }

        .auth-form input:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .auth-form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .auth-form button:hover {
            background-color: #45a049;
        }
        .welcome-message {
            color: #4CAF50;
            font-size: 16px;
            margin-top: 10px;
            text-align: center; /* Центрируем текст приветствия */
        }
        
        .logout-button {
            background-color: #ddd;
            color: #333;
            margin-top: 10px;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
        }

        .logout-button:hover {
            background-color: #333;
            color: white;
        }
</style>
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap">
</head>
<body>
<?php
session_start();

// Подключение к базе данных MySQL/MariaDB
$host = 'localhost';
$db_name = 'Passwords';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

if (isset($_COOKIE['username'])) {
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['password'] = $_COOKIE['password'];
}


// Регистрация пользователя
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Сохранение пользователя в базе данных
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);

    echo "Пользователь зарегистрирован!";
}

// Вход пользователя
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    setcookie("username", $username, time() + (86400 * 30), "/");
    setcookie("password", $password, time() + (86400 * 30), "/");

    // Проверка пользователя в базе данных
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit();
    }

    echo "Неверное имя пользователя или пароль";
}

// Выход пользователя
if (isset($_POST['logout'])) {
    session_destroy();
    setcookie("username", "", time() + (86400 * 30), "/");
    setcookie("password", "", time() + (86400 * 30), "/");
    header('Location: index.php');
    exit();
}
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
// Проверяем, вошел ли пользователь в систему
if (isset($_SESSION['username'])) {
    echo '<div class="welcome-message">Добро пожаловать, ' . htmlspecialchars($username) . '!</div>';
    echo "<br><form method='post' action=''><div class='logout-container'><button class='logout-button' type='submit' name='logout'>Выйти</button></div></form>";
} else {
    // Если не вошел, показываем форму входа или регистрации в зависимости от действия пользователя
    ?>
    <div class="auth-form">
        <?php
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        if ($action == 'register') {
            ?>
            <h2>Регистрация</h2>
            <form method="post" action="">
                <label for="username">Имя пользователя:</label>
                <input type="text" name="username" required>
                <br>
                <label for="password">Пароль:</label>
                <input type="password" name="password" required>
                <br>
                <button type="submit" name="register">Зарегистрироваться</button>
            </form>
            <p>Уже есть аккаунт? <a href="?action=login">Войдите</a></p>
            <?php
        } else {
            ?>
            <h2>Вход</h2>
            <form method="post" action="">
                <label for="username">Имя пользователя:</label>
                <input type="text" name="username" required>
                <br>
                <label for="password">Пароль:</label>
                <input type="password" name="password" required>
                <br>
                <button type="submit" name="login">Войти</button>
            </form>
            <p>Нет аккаунта? <a href="?action=register">Зарегистрируйтесь</a></p>
            <?php
        }
        ?>
    </div>
    <?php
}
?>

</body>
</html>