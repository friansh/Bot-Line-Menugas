<?php

require_once(__DIR__ . '/Library/LINEBotTiny.php');
require_once(__DIR__ . '/Library/LINEMsgParams.php');
require_once(__DIR__ . '/Library/Database.php');
require_once(__DIR__ . '/Config/Env.php');

Database::prepare(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
Database::connect();