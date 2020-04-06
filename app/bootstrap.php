<?php
// Loading config
require_once 'config/config.php';
// Loading helpers
require_once 'helpers/url_helper.php';
require_once 'helpers/session_flash_message.php';

// Loading libraries
// require_once 'libs/core.php';
// require_once 'libs/controller.php';
// require_once 'libs/database.php';

// Autoload core libraries
spl_autoload_register(function ($className) {
    require_once 'libs/' . $className . '.php';
});