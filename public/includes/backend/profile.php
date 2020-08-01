<?php
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-load.php';
class OE_profile
{
    private $data;
    public function __construct()
    {
        $this->data = $_POST;
    }
}
new OE_profile();
