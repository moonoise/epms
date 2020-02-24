<?php
class GlobalConf
{
    public $conf;
    public static $attempts;
    public function __construct()
    {
        
        $this->ip_address = $GLOBALS['ip_address'];
        $this->login_timeout = $GLOBALS['login_timeout'];
        $this->timeout_minutes = $GLOBALS['timeout_minutes'];
        $this->base_url = $GLOBALS['base_url'];
        $this->signin_url = $GLOBALS['signin_url'];
        $this->max_attempts = $GLOBALS['max_attempts'];
    }

  
}
