<?php
App::import('Vendor', 'OAuth/OAuthClient');

class UsersController extends AppController
{
    public $uses = array('User', 'Twitter');

    public function beforeFilter() 
    {
        $this->Auth->allow('index', 'login', 'twcallback', 'twauth', 'create', 'logout');
        $this->Auth->loginRedirect = '/companies/';
        parent::beforeFilter();
    }
    
    public function index()
    {$this->Session->write('tuid',false);
        //$this->redirect('login');
    }

    public function login() 
    {
        if ($tuid=$this->Session->read('tuid')) {
            $tw = $this->Twitter->findById($tuid);
            if ($this->User->findByTwitterId($tuid)) {
                $client = $this->createClient();
                $ret = json_decode($client->get($tw['Twitter']['atoken_key'], $tw['Twitter']['atoken_sec'], 'https://api.twitter.com/1.1/accounts/verify_credentials.json'),true);
                if (is_null($ret)) { //failure
                    $tw->atoken_key = null;
                    $tw->atoken_sec = null;
                    $tw->save();
                    $this->redirect('twauth');
                } else {
                    $user['User']['atoken_key'] = $tw['Twitter']['atoken_key'];
                    $user['User']['atoken_sec'] = $tw['Twitter']['atoken_sec'];
                    $user['User']['twitter_id'] = $tw['Twitter']['id'];
                    if ($this->Auth->login($user)) 
                        $this->redirect($this->Auth->redirect());
                }
            } else { //non-registered user
                $this->redirect('create');
            }
        } else
            $this->redirect('twauth');
    }

    public function twauth()
    {
        $client = $this->createClient();
        $requestToken = $client->getRequestToken('https://api.twitter.com/oauth/request_token', 'http://'.$_SERVER['HTTP_HOST'] . '/Users/twcallback');

        if ($requestToken) {
            $this->Session->write('twitter_request_token', $requestToken);
            $this->redirect('https://api.twitter.com/oauth/authorize?oauth_token=' . $requestToken->key);
        } else {
        var_dump($requestToken,$client);
            die('CAN NOT RETRIEVE TWITTER_REQUEST_TOKEN');
        }
    }

    public function twcallback() 
    {
        $requestToken = $this->Session->read('twitter_request_token');
        $client = $this->createClient();
        $accessToken = $client->getAccessToken('https://api.twitter.com/oauth/access_token', $requestToken);

        if ($accessToken) {
            $data = json_decode($client->get($accessToken->key, $accessToken->secret, 'https://api.twitter.com/1.1/account/verify_credentials.json'), true);
            if (!is_null($data)) {
                $screenName = $data['name'];
                $tuid = $data['id'];
                $pict = $data['profile_image_url'];
                $this->Twitter->create();
                $this->Twitter->set(array(
                    'id' => $tuid,
                    'screen_name' => $screenName,
                    'pict' => $pict,
                    'atoken_key' => $accessToken->key,
                    'atoken_sec' => $accessToken->secret,
                ));
                $this->Twitter->save();
                $this->Session->write('tuid', $tuid);
                $this->redirect('login');
            }
        }
        die('CAN NOT RETRIEVE ACCESS TOKEN');
    }

    private function createClient() 
    {
        return new OAuthClient('q4UqWiz2KlPt7XtrLqAQQ', 'ZLeuuT0kuXUK3KUT3QGsW3b0C0rCFl9ZGx16VE1md8');
    }

    public function logout()
    {
        $this->Session->delete('tuid');
        $this->redirect($this->Auth->logout());
    }

    public function create()
    {
        if ($this->request->is('post')) { //create new user
            if ($this->User->save($this->data)) {
                $this->Session->setFlash(__('Registration Success.'));
                $this->redirect('login');
            } else {
                $this->Session->setFlash(__('Registration Failure. Please contact the administrator.'));
            }
        } else { //show registration form
            $tw = $this->Twitter->findById($tuid=$this->Session->read('tuid'));
            $this->set('twitter_id', $tuid);
            $this->set('twname', $tw['Twitter']['screen_name']);
        }
    }

    public function info($user_id)
    {
        if (is_numeric($user_id)) {
            $user =  $this->User->findById($user_id);
            if (is_null($user)) $this->redirect('.');
            $auth_user = $this->Auth->user();
            $auth_user = $auth_user['User'];
            $auth_user = $auth_user['twitter_id'];
            $cu = $this->User->findByTwitterId($auth_user);
            $uid = $cu['User']['id'];

            $this->set('uid', is_numeric($uid)?$uid:0);
            if ($user['User']['visibility'])
                $this->set('user', $user);
            else
                $this->set('user', false);
        } else {
            $this->redirect('/');
        }
    }

    public function edit()
    {
        if ($this->request->is('put')) {
            if ($this->User->save($this->data)) {
                $this->Session->setFlash('更新完了ｂ');
                $this->redirect(array(
                    'action'=>'info',
                    $this->data['User']['id']));
            } else {
                $this->Session->setFlash('Unable to update. Please contact to the administrator.');
            }
        } else {
            $auth_user = $this->Auth->user();
            $auth_user = $this->User->findByTwitterId($auth_user['User']['twitter_id']);
            $this->data = $auth_user;
            $this->set('twitter_id',$auth_user['User']['twitter_id']);
        }
    }
}
