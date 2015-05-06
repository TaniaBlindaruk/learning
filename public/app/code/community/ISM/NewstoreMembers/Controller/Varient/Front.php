<?php
/**
 * Created by PhpStorm.
 * User: tania
 * Date: 06.05.15
 * Time: 22:11
 */

class ISM_NewstoreMembers_Controller_Varient_Front{
    public function getRouterByRoute($routeName)
    {
        // empty route supplied - return base url
        if (empty($routeName)) {
            $router = $this->getRouter('standard');
        } elseif ($this->getRouter('admin')->getFrontNameByRoute($routeName)) {
            // try standard router url assembly
            $router = $this->getRouter('admin');
        } elseif ($this->getRouter('standard')->getFrontNameByRoute($routeName)) {
            // try standard router url assembly
            $router = $this->getRouter('standard');
        } elseif ($router = $this->getRouter($routeName)) {
            // try custom router url assembly
        } else {
            // get default router url
            $router = $this->getRouter('default');
        }

        return $router;
    }
}