<?php
/**
 * Created by JetBrains PhpStorm.
 * User: A140980
 * Date: 28/10/12
 * Time: 15:46
 * To change this template use File | Settings | File Templates.
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity;

class User
{
    public $login;
    public $password;

    /**
     * @param $login
     * @param $password
     */
    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }
}
