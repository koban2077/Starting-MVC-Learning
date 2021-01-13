<?php

namespace App\Model;

use App\Exception\ValidationException;
use App\Traits\DB;
use DateTime;

class User extends Model
{

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;
    public const TABLE_NAME = 'users';

    private string $name;
    private string $email;
    private string $password;
    private int $status;
    private DateTime $created_at;

    public function __construct(
        string $name,
        string $email,
        string $password
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->status = self::STATUS_ACTIVE;
        $this->created_at = new DateTime();
    }

    public static function findByEmail($email) : array
    {
        $db = self::getDb();

        $stm = $db->prepare('SELECT * FROM users WHERE email = ?');
        $stm->execute([$email]);
        $user = $stm->fetch(\PDO::FETCH_ASSOC);
        return $user ? $user : [];
    }

    public static function save(User $user)
    {
        $db = self::getDb();


        $check = self::findByEmail($user->getEmail());
        if ($check) {
            throw new ValidationException(['email' => 'Email already exists']);
        }

        $stm = $db->prepare('INSERT INTO users(`name`, email, password, status, created_at) VALUE (?, ?, ?, ?, ?)');
        $stm->execute([
            $user->getName(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getStatus(),
            $user->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        if (is_string($hash)) {
            $this->password = $hash;
        }
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }


}