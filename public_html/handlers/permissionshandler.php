<?php

namespace Bosbar\Handlers;

use Bosbar\Handlers\DatabaseHandler;

class PermissionHandler {

    protected $_db;
    /**
     * Constructor.
     */
    public function __construct() {
        $this->_db = new DatabaseHandler();
    }
}