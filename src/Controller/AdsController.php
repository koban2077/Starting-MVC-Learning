<?php


namespace App\Controller;


use App\Exception\ValidationException;
use App\Model\Ads;

class AdsController
{
    public function index()
    {
        $adds = Ads::findAll('ads');
        $data = [
            'title' => 'Ads',
            'adds' => $adds
        ];
        return view('ads.ads_list', $data);
    }

    public function create(): string
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
            $data = [
                'title' => 'Ads Creation',
            ];
            return view('ads.ad_creation', $data);
        }

        $errors = [];
        $data = $_POST;
        if (empty($data['title'])) {
            $errors['title'] = 'Cannot be empty';
        }

        if (empty($data['description'])) {
            $errors['description'] = 'Cannot be empty';
        }

        if ($errors) {
            throw new ValidationException($errors);
        }

        $add = new Ads($data['title'], $data['description']);
        Ads::save($add);
        header('Location: /ads');
        exit;
    }
}