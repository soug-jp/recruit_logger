<?php

class CompaniesController extends AppController 
{
	public $uses = array('Company', 'User', 'State');
    public $components = array('Auth');

    public function index()
    {
        $this->redirect('all');
    }

    public function all()
    {
        $list = $this->Company->findAllByUserId($this->Auth->user('id'));
        $this->set('list', $list);
    }

    public function add()
    {
        $twusr = $this->Auth->user();
        $twusr = $this->User->findByTwitterId($twusr['User']['twitter_id']);
        $this->set('user_id', $twusr['User']['id']);
        $sids = $this->State->find('list', array(
            'fields' => array(
                'id', 'state'
            ),
        ));
        $this->set('state_id_list', $sids);
        if ($this->request->is('post')) {
            if ($this->Company->save($this->data)) {
                $this->Session->setFlash(__('add success'));
                $this->redirect(array('action'=>'view',$this->Company->id));
            } else {
                $this->Session->setFlash(__('invalid parameter'));
            }
        } 
    }

    public function view($companyId)
    {
        $co = $this->Company->findById($companyId);
        if ($co) {
            $this->set('company', $co);
        } else {
            $this->Session->setFlash(__('invalid id requested!'));
            $this->redirect('/');
        }
    }

    public function edit($companyId)
    {
        if ($this->request->is('put')) {
            if ($this->Company->save($this->data)) {
                $this->Session->setFlash(__('Company info updated.'));
                $this->redirect(array('action'=>'view', $companyId));
            } else {
                $this->Session->setFlash(__('CAN NOT UPDATE COMPANY INFO'));
            }
        } else {
            $co = $this->Company->findById($companyId);
            $this->data = $co;
            $state_list = $this->State->find('list', array(
                'fields' => array(
                    'State.id', 'State.state',
                ),
            ));
            $this->set('state_list', $state_list);
        }
    }
    
    public function delete($companyId)
    {
        if (!$this->request->is('post')) {
            $this->Session->setFlash(__('YOU CAN NOT DELETE WITHOUT POST METHOD'));
            $this->redirect(array('action'=>'view', $companyId));
        } else {
            if ($this->Company->delete($companyId)) {
                $this->Session->setFlash(__('delete success'));
                $this->redirect('list');
            } else {
                $this->Session->setFlash(__('CAN NOT DELETE. Please contact to the administrator.'));
            }
        }
    }

    public function state($companyId)
    {
        if ($this->request->is('post')) {
            $co = $this->Company->findById($companyId);
            $co->state_id = $this->data->state_id;
            if ($this->Company->update($co)) {
                $this->Session->setFlash(__('update success.'));
                $this->redirect(array('action'=>'view', $companyId));
            } else {
                $this->Session->setFlash(__('CAN NOT UPDATE. Please contact to the administrator.'));
            }
        }
    }

}
