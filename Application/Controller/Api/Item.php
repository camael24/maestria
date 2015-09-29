<?php


namespace Application\Controller\Api;


use Application\Controller\Api;
use Application\Model\Domain;
use Application\Model\Theme;
use Application\Model\UserClass;

class Item extends Api
{

    public function domainActionAsync()
    {

        $d      = [];
        $domain = new Domain();
        $domain = $domain->all();

        foreach ($domain as $a) {
            /**
             * @var $a \Application\Entities\Domain
             */
            $d['domainHeader'][] = ['id' => $a->getId(), 'label' => $a->getLabel()];
            $d['domainData'][]   = $this->getUserNote(); // TODO change this behind
        }


        $this->data($d);

        echo $this->getApiJson();
    }


    public function themeActionAsync($theme) {

        $d      = [];
        $t = new Theme();
        $t = $t->getByRef($theme);

        foreach ($t as $a) {
            /**
             * @var $a \Application\Entities\Theme
             */
            $d['domainHeader'][] = ['id' => $a->getId(), 'label' => $a->getLabel()];
            $d['domainData'][]   = $this->getUserNote(); // TODO change this behind
        }

        $this->data($d);

        echo $this->getApiJson();
    }


    protected function getUserNote()
    {
        $classroom         = 1;
        $data              = [];
        $usersclass        = new UserClass();
        $users             = $usersclass->getAllBy('refClassroom', $classroom);
        $this->data->users = [];
        $this->data->uid   = [];

        foreach ($users as $u) {
            /**
             * @var $u \Application\Entities\UserClass
             */

            $data['u'.$u->getRefUser()] = [50, 'Foo'];

        }

        return $data;
    }

}