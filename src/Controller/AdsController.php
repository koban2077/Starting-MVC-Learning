<?php


namespace App\Controller;


use App\Exception\ValidationException;
use App\Model\Ads;
use Valitron\Validator;

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
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = [
                'title' => 'Ads Creation',
            ];
            return view('ads.ad_creation', $data);
        }

        $data = $_POST;
        $v = new Validator($data);
        $v->rule('required', ['title', 'description']);
        $v->rule('lengthMax', ['title'], 100);
        $v->rule('lengthMax', ['description'], 1024);
        if (!$v->validate()) {
            throw new ValidationException('validation error', $v->errors());
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