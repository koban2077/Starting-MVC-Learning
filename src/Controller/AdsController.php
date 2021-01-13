<?php


namespace App\Controller;


use App\Exception\ValidationException;
use App\Model\Ads;

class AdsController
{

    private Ads $adModel;

    public function __construct()
    {
        $this->adModel = new Ads('adds');
    }
    public function index()
    {
        $adds = $this->adModel->getAll();
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

        $this->adModel->create(
            [
                'title' => $data['title'],
                'description' => $data['description'],
            ]
        );
        header('Location: /ads');
        exit;
    }
}