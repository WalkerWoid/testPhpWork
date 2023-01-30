<?php

namespace Felix\StudyProject;

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
        $page = '';

        switch ($page) {
            case 'form':
                $result = $this->formAction();
                break;
            case 'list':
                $result = $this->listAction();
                break;
            case 'send':
                $result = $this->sendAction();
                break;
            default:
                header('Location: /form');
                $result = null;
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
        // селект из базы $database->query()
    }

    /**
     * Вызывается на запрос POST /send
     *
     * todo Обработка и сохранение данных формы, ответ в формате json с обработкой на js
     *
     * @return string
     */
    protected function sendAction(): string
    {
        // запись в базу $database->query()
    }
}
