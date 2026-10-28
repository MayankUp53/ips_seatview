<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry; //追加

//API実行用

use Cake\Http\Client;
use Cake\Http\Response;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController{

    public function initialize(): void{
        $this->loadComponent('Flash');
        $this->setListValue();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index(){

        $session = $this->request->getSession();
        $sessionId = $session->read('sessionId');

        if (empty($sessionId)){
            //セッションエラー
            $this->Flash->error(__('セッションエラー'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        $usersQuery = $this->Users->find()
            ->where(['Users.deleted IS' => null])
            ->orderBy(['Users.id' => 'ASC']);

        $users = $this->paginate($usersQuery, ['limit' => 20]);

        $this->set(compact('users'));
        //$this->setListValue();
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(){

        $session = $this->request->getSession();
        $sessionId = $session->read('sessionId');

        if (empty($sessionId)){
            //セッションエラー
            $this->Flash->error(__('セッションエラー'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {

            //ログインユーザのID
            $loginUserId = $this->request->getSession()->read('id');

            $timestamp = date('Y-m-d H:i:s');
            $user->created = $timestamp;
            $user->created_user_id = $loginUserId;
            $user->updated = $timestamp;
            $user->updated_user_id = $loginUserId;

            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('ユーザが登録されました'));
                return $this->redirect(['action' => 'index']);
            }else{
                //エラーログ出力
                $this->log($user->errors(), "error");
                $this->Flash->error(__('ユーザの登録に失敗しました'));
            }
        }
        //$this->setListValue();
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit($id = null){

        $session = $this->request->getSession();
        $sessionId = $session->read('sessionId');

        if (empty($sessionId)){
            //セッションエラー
            $this->Flash->error(__('セッションエラー'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        
        $user = $this->Users->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {

            //ログインユーザのID
            $loginUserId = $this->request->getSession()->read('id');

            $timestamp = date('Y-m-d H:i:s');
            $user->id = $id;
            $user->updated = $timestamp;
            $user->updated_user_id = $loginUserId;

            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('ユーザが更新されました'));
                return $this->redirect(['action' => 'index']);
            }else{
                //エラーログ出力
                $this->log($user->errors(), "error");
                $this->Flash->error(__('ユーザの更新に失敗しました'));
            }

        }

        $data = $user;
        //$this->setListValue();
        $this->set(compact('id','data'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null){

        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        //ログインユーザのID
        $loginUserId = $this->request->getSession()->read('Auth.User.id');

        $timestamp = date('Y-m-d H:i:s');
        $user->id = $id;
        $user->deleted = $timestamp;
        $user->deleted_user_id = $loginUserId;


        $user = $this->Users->patchEntity($user, $this->request->getData());

        if ($this->Users->save($user)) {
            $this->Flash->success(__('ユーザが削除されました'));
            return $this->redirect(['action' => 'index']);
        }else{
            //エラーログ出力
            $this->log($user->errors(), "error");
            $this->Flash->error(__('ユーザの削除に失敗しました'));
        }
    }
    public function loginAPI($id,$pass){
        $url = $this->ameyoApiUrl('/ameyorestapi/session/login');

        $option = [
                'token' => $pass,
                'forceLogin' => true,
                'terminalInfo' => 'seatviewer',
                'userId' => $id
            ];

        $http = new Client();
        $response = $http->post($url,json_encode($option),['type' => 'json']);
        $data = json_decode($response->getStringBody(), true);

        if (isset($data['userId']) == true){

            $session = $this->request->getSession();
            $session->write([
                'id' => $id,
                'pass' => $pass,
                'userId'=> $data['userId'],
                'terminalInfo'=> $data['terminalInfo'],
                'sessionId'=> $data['sessionId'],
                'loginTime'=> $data['loginTime'],
                'userType'=> $data['userType']
            ]);
            if (empty($session->read('sessionId'))){
                return "error";
            }else{
                return "ok";
            }
        }else{
            return "error";
        }

    }

    public function login(){
        $this->viewBuilder()->disableAutoLayout();
        
        if ($this->request->is('post')) {

            $id = $this->request->getData('loginid');
            $pass = $this->request->getData('password');
            $res = $this->loginAPI($id,$pass);

            if ($res == "ok"){
                return $this->redirect(['controller' => 'seats', 'action' => 'index']);
            }else{
                $session = $this->request->getSession();
                $session->destroy();

                $this->Flash->error(__('ユーザIDまたはパスワードに誤りがあります'));

                //return $this->redirect(array('controller' => 'users', 'action' => 'login'));
            }
            
        }

    }
	public function logoutAPI($sessionId){
			//echo "Hi"; die;
        $url = $this->ameyoApiUrl('/ameyorestapi/session/userLogout');
        $header = [
            'sessionId' => $sessionId,
            'Content-Type' => "application/json"
        ];
        $option = [
                'sessionId' => $sessionId,
                'reason' => "Logout from Seatviewer UI"
            ]; 
        $http = new Client();
        $response = $http->post($url,json_encode($option),['headers' => $header]); 
        //$data = json_decode($response->body(),true); die;
		if ($response =='ok')       
                return "ok";   
        else
            return "error";   
    }
    public function logout(){
		 $session = $this->request->getSession();
		 //print_r($session); die;
        $session->destroy();

        return $this->redirect('/');
        //return $this->redirect($this->Auth->logout());
        /*$session = $this->request->getSession();

		$sessionId = $session->read('sessionId');  
		$res = $this->logoutAPI($sessionId); 
		if($res == 'ok'){
			$session->destroy();
			return $this->redirect(array('controller' => 'users', 'action' => 'login'));
		}
		else {
		return $this->redirect(array('controller' => 'seats', 'action' => 'index'));
		}*/
			//$this->viewBuilder()->layout(false);
    }
    public function setListValue(){
		//権限
		$authOpt = ['1'=>'General','9'=>'Administrator'];

		//カテゴリ
		$categoryOpt = ['1'=>'Company','2'=>'Deck','3'=>'Engine'];

		//ユーザ
        $Users = \Cake\ORM\TableRegistry::getTableLocator()->get('Users');
        $userOpt = $Users->find('list',
        keyField: 'id',
        valueField: 'name')
        ->where(['deleted is null'])
        ->toArray();

        //有効無効
        $isActiveOpt = ['0'=>'Enabled','1'=>'Disabled'];

		$this->set(compact('authOpt','categoryOpt','userOpt','isActiveOpt'));

    }

}
