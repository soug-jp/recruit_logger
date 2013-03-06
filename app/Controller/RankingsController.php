<?php
class RankingsController extends AppController 
{
    public $uses = array('User', 'Company', 'State');
    public $components = 'Auth';

    public function state($id)
    {
        if (is_numeric($id)) {
            $ranking = $this->Company->find('all', array(
                'conditions' => array(
                    'Company.state_id' => $id,
                ),
                'fields' => array(
                    'Company.user_id',
                    'Count(Company.id) as count',
                ),
                'group' => 'Company.user_id',
                'order' => 'count',
            ));
        } else if (is_string($id)) {
            $state = $this->State->find('first', array(
                'state' => $id,
                'OR' => array(
                    'slug' => $id,
                ),
            ));
            $id = $state->id;
            $ranking = $this->Company->find('all', array(
                'conditions' => array(
                    'state_id' => $id,
                ),
                'fields' => array(
                    'Company.user_id',
                    'Count(Company.id) as count',
                ),
                'group' => 'Company.user_id',
                'order' => 'count',
            ));
        } else {
            $this->setFlash(__('Invalid argument supplied'));
            $this->redirect('/');
        }
        $this->set('ranking', $ranking);
    }
}
