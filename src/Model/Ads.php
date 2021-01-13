<?php

namespace App\Model;

use App\Exception\ValidationException;
use App\Traits\DB;

class Ads extends Model
{
    public const TITLE_LENGTH = 100;
    public const BODY_LENGTH = 1000;
    public const TABLE_NAME = 'adds';

    private string $title;
    private string $body;
    private string $created_at;

    public function __construct(string $title, string $body)
    {
        $this->setTitle($title);
        $this->setBody($body);
        $this->setCreatedAt();
    }


    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $givenLength = strlen($title);
        if (empty($title) || $givenLength > self::TITLE_LENGTH) {
            throw new \Exception();
        }
        $this->title = $title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $givenLength = strlen($body);
        if (empty($body) || $givenLength > self::BODY_LENGTH) {
            throw new \Exception();
        }
        $this->body = $body;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(): void
    {
        $this->created_at = date("Y-m-d H:i:s");
    }

    public static function findByTitle($title)
    {
        $db = self::getDb();
        $stm = $db->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE title = ?');
        $stm->execute([$title]);
        $ad = $stm->fetch(\PDO::FETCH_ASSOC);
        return $ad ? $ad : [];
    }

    public static function save(Ads $ad)
    {
        $db = self::getDb();


        $check = self::findByTitle($ad->getTitle());
        if ($check) {
            throw new ValidationException(['title' => 'Title already exists']);
        }

        $stm = $db->prepare('INSERT INTO adds(`title`, description, created_at) VALUE (?, ?, ?)');
        $stm->execute([
            $ad->getTitle(),
            $ad->getBody(),
            $ad->getCreatedAt()
        ]);
    }


}