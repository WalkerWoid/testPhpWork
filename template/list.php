<?php
use Felix\StudyProject\Database;

    $database = new Database();

    $id = 1;
    $line = '';

    while ($database->query("SELECT * FROM dataBase WHERE id=$id")->fetchArray()) {
        $result = $database->query("SELECT * FROM dataBase WHERE id=$id")->fetchArray();

        $name = $result['inputName'];
        $email = $result['inputEmail'];
        $site = $result['inputSite'];

        $row = "
            <li class='list__user'>
                <span class='list__user_span'>Имя посетителя: <span>{$name}</span>;</span> 
                <span class='list__user_span'>Email посетителя: <span>{$email}</span>;</span>
                <span class='list__user_span'>Сайт посетителя: <span>{$site}</span>;</span></li>";
        $line .= $row;
        $id += 1;
    }
    $database->close();
?>

<section class="list-container">
    <h2>Список посетителей:</h2>

    <div class="list">
        <ul class="users__list">
            <?=$line?>
        </ul>
    </div>
</section>
