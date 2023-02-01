<?php


namespace Felix\StudyProject;


/**

 */
class Render
{
    public function renderTemp($page, array $content = []){
        ob_start();

        extract($content);
        require_once "template/$page.php";

        return ob_get_clean();
    }
}