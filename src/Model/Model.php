<?php


namespace App\Model;


use App\Exception\ValidationException;
use PDO;

abstract class Model
{
    public static function findAll()
    {
        $db = self::getDb();
        $stm = $db->query('SELECT * FROM ' . static::TABLE_NAME);
        $result = $stm->fetchAll(\PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    public static function remove($id){
        $db = self::getDb();
        $stm = $db->prepare('DELETE FROM '. static::TABLE_NAME .' WHERE id = ?');
        $stm->execute([$id]);
    }

    public static function findById($id){
        $db = self::getDb();
        $stm = $db->prepare('SELECT * FROM ' . static::TABLE_NAME . ' WHERE id = ?');
        $stm->execute([$id]);
        $result = $stm->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result : [];

    }

    public static function getDb() {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s',
            '192.168.10.10',
            'testdb'
        );
        $pdo = new PDO($dsn, 'testuser', 'qwerty');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}