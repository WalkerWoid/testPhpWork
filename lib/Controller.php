<?php

namespace Felix\StudyProject;

use Felix\StudyProject\Render;

class Controller
{
    /**
     * Обработка запроса от пользователя
     *
     * todo Распарсить $_REQUEST['REQUEST_URI'] и понять какую страницу показывать
     * todo Проверку надо усложнить, чтобы учитывался http метод
     * todo Подключать хедер и футер
     *
     * @return void
     */


    public function process(): void
    {
        $page = explode('/', $_SERVER['REQUEST_URI'])[1];

        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            switch ($page) {
                case 'form':
                    $result = $this->formAction();
                    break;
                case 'list':
                    $result = $this->listAction();
                    break;
                default:
                    header("Location: http://localhost:8080/form");
                    $result = null;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            switch ($page) {
                case 'send':
                    $result = $this->sendAction();
                    break;
                default:
                    header("Location: http://localhost:8080/send");
                    $result = null;
            }
        }

        if (!is_null($result)) {
            echo $result;
        }
    }

    /**
     * Вызывается на запрос GET /form
     *
     * todo Показ формы
     *
     * @return string
     */
    protected function formAction(): string {
        $render = new Render();

        return $render->renderTemp(
            'mainTemplate',
            ['nav'=>$render->renderTemp('nav'),
                'header'=>$render->renderTemp('header'),
                'form'=>$render->renderTemp('form'),
                'footer'=>$render->renderTemp('footer')]);
    }

    /**
     * Вызывается на запрос GET /list
     *
     * todo Показ списка сохранённых в базу форм
     *
     * @return string
     */
    protected function listAction(): string
    {

        $render = new Render();

        return $render->renderTemp(
            'mainTemplate',
            ['nav'=>$render->renderTemp('nav'),
                'header'=>$render->renderTemp('header'),
                'form'=>$render->renderTemp('list'),
                'footer'=>$render->renderTemp('footer')]);

        // селект из базы $database->query()
    }

    /**
     * Вызывается на запрос POST /send
     *
     * todo Обработка и сохранение данных формы, ответ в формате json с обработкой на js
     *
     * @return string
     */


    protected function sendAction()
    {
        $data = json_decode(file_get_contents('php://input'));

        $database = new Database();

        $name = strip_tags(htmlspecialchars($database->escapeString($data->name)));
        $email = strip_tags(htmlspecialchars($database->escapeString($data->email)));
        $site = strip_tags(htmlspecialchars($database->escapeString($data->site)));

        $database->query("INSERT INTO dataBase (inputName, inputEmail, inputSite) VALUES ('$name', '$email', '$site')");
        $database->close();

        header('Content-Type: application/json', false);

        $response = [
            'responseText' => 'send data was successful',
            'name' => strip_tags(htmlspecialchars($data->name)),
            'email' => strip_tags(htmlspecialchars($data->email)),
            'site' => strip_tags(htmlspecialchars($data->site))
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);

        // запись в базу $database->query()
    }
}

