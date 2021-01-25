<?php


namespace App\Model;


use App\Utils\Config;
use PDO;
use PDOException;

abstract class Model
{

    protected static PDO $db;
    protected string $table;

    public function __construct(string $table)
    {
        $this->table = $table;
        self::$db = $this->db();
    }

    public function getAll(): array
    {
        $stm = $this->db()->query('SELECT * FROM ' . $this->table);
        return $stm->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function remove(int $id): void
    {
        $sql = sprintf('DELETE FROM %s WHERE id = ?', $this->table);
        $stm = $this->db()->prepare($sql);
        $stm->execute([$id]);
    }

    public function db(): PDO
    {
        if (!isset(self::$db)) {
            try {
                $dsn = sprintf('mysql:host=%s;dbname=%s;port=%s;',Config::get('DB_HOST'), Config::get('DB_NAME')
                    ,Config::get('DB_PORT'));
                self::$db = new PDO($dsn, Config::get('DB_USER'), Config::get('DB_PASS'));
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                exit('Connection to database failed');
            }
        }
        return self::$db;
    }
}