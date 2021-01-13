<?php

namespace App\Model;

use App\Exception\ValidationException;
use DateTime;
use PDO;

class Ads extends Model
{
    public function findByTitle(string $title)
    {
        $stm = $this->db()->prepare('SELECT * FROM adds WHERE title = ?');
        $stm->execute([$title]);
        $ad = $stm->fetch(PDO::FETCH_ASSOC);
        return $ad ? $ad : [];
    }

    public function create(array $ad): void
    {

        $check = $this->findByTitle($ad['title']);
        if ($check) {
            throw new ValidationException(['title' => 'Title already exists']);
        }

        $stm = $this->db()->prepare('INSERT INTO adds(`title`, description, created_at) VALUE (?, ?, ?)');
        $stm->execute([
            $ad['title'],
            $ad['description'],
            (new DateTime())->format('Y-m-d H:i:s')
        ]);

    }


}