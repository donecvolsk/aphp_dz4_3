<?php
declare(strict_types=1);

// Класс для работы с таблицей клиентов
class Client extends BaseTable {
    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'client');
    }
}