<?php
class MyController extends AppController
{
    public $uses = array('User', 'Company', 'State', 'Twitter');
    public $helpers = array('Html', 'Form');

    public function beforeFilter()
    {
        $this->Auth->deny();
        parent::beforeFilter();
    }

    public function index()
    {
        $auth_user = $this->Auth->user();
        $auth_user = $this->User->findByTwitterId($auth_user['User']['twitter_id']);
        $company = $this->Company->find('all', array(
            'conditions' => array(
                'user_id' => $auth_user['User']['id'],
            ),
            'fields' => array(
                'id',
                'name',
                'state_id',
            ),
        ));
        $states = $this->State->find('list',array('fields'=>array('State.id','State.state')));
        $st_count = array();
        $stMax=0;
        foreach ($states as $k=>$v) {
            $cp = $this->Company->find('count', array(
                'conditions' => array(
                    'user_id' => $auth_user['User']['id'],
                    'state_id' => $k,
                ),
                'fields' => array(
                    'Count(*) as count',
                ),
            ));
            $states[$k] = array('state' => $v, 'count' => $cp);
            $st_count[] = $cp;
            $stMax = $stMax<$cp ? $cp : $stMax;
        }
        $this->set('companies', $company);
        $this->set('states', $states);
        $this->set('st', $st_count);
        $this->set('range', $stMax+$stMax%5);
    }

}
