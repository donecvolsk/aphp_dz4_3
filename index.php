<?php
declare(strict_types=1);
// require_once 'Measurements.php';

include 'autoloader.php';
spl_autoload_register('autoloader');

try {
    // Подключение к базе данных SQLite
    $dsn = 'sqlite:newDB.db'; // Укажите путь к вашей базе данных
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    $pdo = new PDO($dsn, null, null, $options);

    // Создаем объекты для работы с таблицами
    $shop = new Shop($pdo);
    $order = new Order($pdo);
    $client = new Client($pdo);

    // Добавляем новый магазин
    echo "Добавление нового магазина:\n";
    $newShop = $shop->insert(['name', 'address'], ['Новый магазин', 'Новый адрес']);
    print_r($newShop);

    // Обновляем существующий магазин
    echo "\nОбновление существующего магазина:\n";
    $updatedShop = $shop->update(1, ['name' => 'Измененное название', 'address' => 'Измененный адрес']);
    print_r($updatedShop);

    // Поиск магазина по ID
    echo "\nПоиск магазина по ID:\n";
    $foundShop = $shop->find(1);
    print_r($foundShop);

    // Удаление магазина по ID
    echo "\nУдаление магазина по ID:\n";
    $deleted = $shop->delete(1);
    var_dump($deleted); // Должно вернуть true, если удаление прошло успешно

    // Аналогично работаем с другими таблицами...

} catch (Exception $e) {
    echo 'Произошла ошибка: ', $e->getMessage(), "\n";
}













