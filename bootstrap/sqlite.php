<?php

$tmpDbPath = '/tmp/database.sqlite';

if (!file_exists($tmpDbPath)) {
    touch($tmpDbPath); // Create empty SQLite file
}
