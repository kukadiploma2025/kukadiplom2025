<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['Phone']);
    $message = htmlspecialchars($_POST['message']);

    // Проверка на валидность номера (дополнительно в PHP)
    if (!preg_match('/^(\+?7|8)747[0-9]{7}$/', $phone)) {
        die('Неверный формат номера телефона');
    }

    // Подключение к базе данных
    $host = 'localhost';
    $dbname = 'test_database';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Сохранение в базу данных
        $stmt = $pdo->prepare("INSERT INTO contacts (name, phone, message) VALUES (:name, :phone, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':message', $message);

        if ($stmt->execute()) {
            echo "Данные успешно сохранены!";
        } else {
            echo "Ошибка сохранения данных.";
        }
    } catch (PDOException $e) {
        echo "Ошибка базы данных: " . $e->getMessage();
    }
}
?>
