<?php

namespace App\Utils;

use App\Exception\Exception404;
use App\Exception\ValidationException;
use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;


class Router
{
    public const STREAM = __DIR__ . '/../../my_app.log';
    public function process()
    {
        try {
            $logger = new Logger('name');
            $logger->pushHandler(new StreamHandler(self::STREAM, Logger::WARNING));

            $action = $this->getAction();
            $controller = $action[0];
            $method = $action[1];
            $object = new $controller;
            $object->$method();
            unset($_SESSION['errors']);
            unset($_SESSION['data']);
        } catch (Exception404 $exception) {
            $logger->warning($exception->getMessage());
            return view('404');
        } catch (ValidationException $exception) {
            $logger->warning($exception->getMessage());
            $this->handleValidationException($exception);
        } catch (Exception $exception) {
            $logger->warning($exception->getMessage());
            return view('wrong');
        }
    }

    private function getAction() : array
    {
        // Получаем PATH от ссылки
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // Разбиваем ссылку на массив по элементам
        $url = explode('/', $url);

        // Формируем полный неймспейс класса
        if (empty($url[1])) {
            $controller = '\App\Controller\HomeController';
        } else {
            $controller = '\App\Controller\\' . ucfirst($url[1]) . 'Controller';
            if (!class_exists($controller)) {
                throw new Exception404('Error 404');
            }
        }

        if (empty($url[2])) {
            $method = 'index';
        } else {
            $method = $url[2];
        }

        if (!method_exists($controller, $method)) {
            throw new Exception404('Error 404');
        }
        return [$controller, $method];
    }

    private function handleValidationException(ValidationException $exception)
    {
        $referer = parse_url($_SERVER['HTTP_REFERER']);
        $url = 'http://' . $referer['host'] . $referer['path'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_SESSION['errors'] = $exception->getErrors();
            $_SESSION['data'] = $_POST;
        }

        header('Location: ' . $url);
        exit;
    }
}