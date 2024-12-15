<?php
declare(strict_types=1);

// Класс для работы с таблицей магазинов
class Shop extends BaseTable {
    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'shop');
    }
}