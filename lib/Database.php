<?php

namespace Felix\StudyProject;

use SQLite3;

class Database extends SQLite3
{
    protected string $databaseDir = __DIR__ . '/../db/sqlite.db';

    function __construct()
    {
        parent::__construct($this->databaseDir, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
    }
}
