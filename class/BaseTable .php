<?php
declare(strict_types=1);

// Базовый класс для работы с таблицей
abstract class BaseTable implements DatabaseWrapper {
    protected string $tableName;
    protected PDO $pdo;
    
    public function __construct(PDO $pdo, string $tableName) {
        $this->pdo = $pdo;
        $this->tableName = $tableName;
    }

    public function insert(array $tableColumns, array $values): array {
        $columns = implode(', ', $tableColumns);
        $placeholders = rtrim(str_repeat('?,', count($values)), ','); // Используем позиционные параметры вместо именованных
        
        $stmt = $this->pdo->prepare("INSERT INTO {$this->tableName} ($columns) VALUES ($placeholders)");
        if (!$stmt->execute($values)) { // Передаем значения напрямую в execute()
            throw new Exception('Ошибка при вставке записи.');
        }
        
        return $this->find((int) $this->pdo->lastInsertId());
    }

    public function update(int $id, array $values): array {
        $setValues = [];
        foreach ($values as $column => $value) {
            $setValues[] = "$column = ?";
        }
        $setClause = implode(', ', $setValues);
        
        $params = array_values($values);
        $params[] = $id; // Добавляем id в конец массива параметров
        
        $stmt = $this->pdo->prepare("UPDATE {$this->tableName} SET $setClause WHERE id = ?");
        if (!$stmt->execute($params)) {
            throw new Exception('Ошибка при обновлении записи.');
        }
        
        return $this->find($id);
    }

    public function find(int $id): array {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE id = ?");
        $stmt->execute([$id]);
        if (!$stmt->execute()) {
            throw new Exception('Ошибка при поиске записи.');
        }
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->tableName} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}