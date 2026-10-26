<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry; //追加
use Cake\Routing\Router; //追加

//API実行用
use Cake\Network\Http\Client;
use Cake\Http\Response;

/**
 * Seats Controller
 *
 * @property \App\Model\Table\SeatsTable $Seats
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeatsController extends AppController{

    public function initialize(){
        //$this->loadComponent('RequestHandler'); // Ajax用コンポーネント
        $this->loadComponent('Flash');
        $this->setListValue();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index(){
        //シートビュー画面

        //アメヨのセッションID
        $session = $this->request->session();
        $sessionId = $session->read('sessionId');

        if (empty($sessionId)){
            //セッションエラー
            $this->Flash->error(__('セッションエラー'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

		//セッション（ページリダイレクト後に子画面を閉じる為に使用）を削除する
		$session->delete('edit_submit');

        //debug($sessionId);

        //Calling Ping-Session API
        $res = $this->pingSessionAPI($sessionId);

        //debug($res);

        //セッション切れの場合は自動的に再ログインする
        if ($res == "error"){
            $id = $session->read('id');
            $pass = $session->read('pass');
            $this->autoReLogin($id,$pass); //Re-Create New SessionId
            $sessionId = $session->read('sessionId');
        }

        //Calling Keep Alive API
        $this->keepAliveAPI($sessionId);

        //Calling Rest API
        $this->restAPI($sessionId);

        //$this->setListValue();
    }
    public function ajax(){

        $this->autoRender = false;

        // Ajax通信でこのアクションが実行された時だけ処理を行う
        if ($this->request->is('ajax')) {

            //アメヨのセッションID
            $session = $this->request->session();
            $sessionId = $session->read('sessionId');

            //Calling Ping-Session API
            $res = $this->pingSessionAPI($sessionId);

            //セッション切れの場合は自動的に再ログインする
            if ($res == "error"){
                //debug("error");
                //debug($sessionId);
                $id = $session->read('id');
                $pass = $session->read('pass');
                $this->autoReLogin($id,$pass); //Re-Create New SessionId
                $sessionId = $session->read('sessionId');
            }

            //Calling Keep Alive API
            $this->keepAliveAPI($sessionId);

            //Calling Rest API
            $data = $this->restAPI($sessionId);

            //HTMLを生成する
            $html = "";
            $html .= '<tr>';
                $html .= '<td style="padding:5px;font-weight:bold">・東京</td>';
            $html .= '</tr>';

            $html .= '<tr>';
                $html .= '<td>';

                    $html .= '<table class="seatView">';
                        $html .= '<tr>';
                            $html .= '<th></th>';
                            $html .= '<th>1</th>';
                            $html .= '<th>2</th>';
                            $html .= '<th>3</th>';
                            $html .= '<th>4</th>';
                        $html .= '</tr>';

                        $html .= '<tr>';
                            $html .= '<th>A</th>';
                            $html .= $this->getSeatValue("A1",$data);
                            $html .= $this->getSeatValue("A2",$data);
                            $html .= $this->getSeatValue("A3",$data);
                            $html .= $this->getSeatValue("A4",$data);
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>B</th>';
                            $html .= $this->getSeatValue("B1",$data);
                            $html .= $this->getSeatValue("B2",$data);
                            $html .= $this->getSeatValue("B3",$data);
                            $html .= $this->getSeatValue("B4",$data);
                        $html .= '</tr>';
                    $html .= '</table>';
                $html .= '</td>';
                $html .= '<td>';
                    $html .= '<table class="seatView">';
                        $html .= '<tr>';
                            $html .= '<th></th>';
                            $html .= '<th>1</th>';
                            $html .= '<th>2</th>';
                            $html .= '<th>3</th>';
                            $html .= '<th>4</th>';
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>C</th>';
                            $html .= $this->getSeatValue("C1",$data);
                            $html .= $this->getSeatValue("C2",$data);
                            $html .= $this->getSeatValue("C3",$data);
                            $html .= $this->getSeatValue("C4",$data);
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>D</th>';
                            $html .= $this->getSeatValue("D1",$data);
                            $html .= $this->getSeatValue("D2",$data);
                            $html .= $this->getSeatValue("D3",$data);
                            $html .= $this->getSeatValue("D4",$data);
                        $html .= '</tr>';
                    $html .= '</table>';
                $html .= '</td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<td>';
                    $html .= '<table class="seatView">';
                        $html .= '<tr>';
                            $html .= '<th></th>';
                            $html .= '<th>1</th>';
                            $html .= '<th>2</th>';
                            $html .= '<th>3</th>';
                            $html .= '<th>4</th>';
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>E</th>';
                            $html .= $this->getSeatValue("E1",$data);
                            $html .= $this->getSeatValue("E2",$data);
                            $html .= $this->getSeatValue("E3",$data);
                            $html .= $this->getSeatValue("E4",$data);
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>F</th>';
                            $html .= $this->getSeatValue("F1",$data);
                            $html .= $this->getSeatValue("F2",$data);
                            $html .= $this->getSeatValue("F3",$data);
                            $html .= $this->getSeatValue("F4",$data);
                        $html .= '</tr>';
                    $html .= '</table>';
                $html .= '</td>';
                $html .= '<td>';
                    $html .= '<table class="seatView">';
                        $html .= '<tr>';
                            $html .= '<th></th>';
                            $html .= '<th>1</th>';
                            $html .= '<th>2</th>';
                            $html .= '<th>3</th>';
                            $html .= '<th>4</th>';
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>G</th>';
                            $html .= $this->getSeatValue("G1",$data);
                            $html .= $this->getSeatValue("G2",$data);
                            $html .= $this->getSeatValue("G3",$data);
                            $html .= $this->getSeatValue("G4",$data);
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>H</th>';
                            $html .= $this->getSeatValue("H1",$data);
                            $html .= $this->getSeatValue("H2",$data);
                            $html .= $this->getSeatValue("H3",$data);
                            $html .= $this->getSeatValue("H4",$data);
                        $html .= '</tr>';                         
                    $html .= '</table>';
                $html .= '</td>';
            $html .= '</tr>';

            /*$html .= '<tr>';
                $html .= '<td style="padding:5px;font-weight:bold">・沖縄</td>';
            $html .= '</tr>';

            $html .= '<tr>';
                $html .= '<td>';
                    $html .= '<table class="seatView">';
                        $html .= '<tr>';
                            $html .= '<th></th>';
                            $html .= '<th>1</th>';
                            $html .= '<th>2</th>';
                            $html .= '<th>3</th>';
                            $html .= '<th>4</th>';
                            $html .= '<th>5</th>';
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>I</th>';
                            $html .= $this->getSeatValue("I1",$data);                            
                            $html .= $this->getSeatValue("I2",$data);     
                            $html .= $this->getSeatValue("I3",$data);   
                            $html .= $this->getSeatValue("I4",$data);   
                            $html .= $this->getSeatValue("I5",$data);                          
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>J</th>';
                            $html .= $this->getSeatValue("J1",$data);                            
                            $html .= $this->getSeatValue("J2",$data);     
                            $html .= $this->getSeatValue("J3",$data);   
                            $html .= $this->getSeatValue("J4",$data);   
                            $html .= $this->getSeatValue("J5",$data);                              
                        $html .= '</tr>';
                    $html .= '</table>';
                $html .= '</td>';
                $html .= '<td>';
                    $html .= '<table class="seatView">';
                        $html .= '<tr>';
                            $html .= '<th></th>';
                            $html .= '<th>1</th>';
                            $html .= '<th>2</th>';
                            $html .= '<th>3</th>';
                            $html .= '<th>4</th>';
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>K</th>';
                            $html .= $this->getSeatValue("K1",$data);                            
                            $html .= $this->getSeatValue("K2",$data);     
                            $html .= $this->getSeatValue("K3",$data);   
                            $html .= $this->getSeatValue("K4",$data);                           
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>L</th>';
                            $html .= $this->getSeatValue("L1",$data);                            
                            $html .= $this->getSeatValue("L2",$data);     
                            $html .= $this->getSeatValue("L3",$data);   
                            $html .= $this->getSeatValue("L4",$data);                              
                        $html .= '</tr>';
                    $html .= '</table>';
                $html .= '</td>';
            $html .= '</tr>';*/
            //echo json_encode($data);
            echo $html;
		}
    }
    function getSeatValue($location,$data){

        $arr = [];
        $extension = "";
        $userName = "";
        $status = "";
        $time = "";
        $class = "";
	$queueList="";
        $edit_url = Router::url(['controller' => 'Seats', 'action' => 'edit'], false)."/";

		//ユーザID
        $Locations = TableRegistry::get('Locations');
        $userOpt = $Locations->find('list', ['keyField' => 'location','valueField' => 'user_id'])->where(['deleted is null'])->toArray();

		//内線番号
        $extOpt = $Locations->find('list', ['keyField' => 'location','valueField' => 'extension'])->where(['deleted is null'])->toArray();
        $queueListOpt = $Locations->find('list', ['keyField' => 'location','valueField' => 'queue_list'])->where(['deleted is null'])->toArray();

        //ユーザ名
        $Users = TableRegistry::get('Users');
        $userNameOpt = $Users->find('list', ['keyField' => 'user_id','valueField' => 'user_name'])->where(['deleted is null'])->toArray();

        $arr['editUrl'] = $edit_url;
        $arr['class'] = $class;
        $arr['extension'] = $extension;
        $arr['userId'] = "";
        $arr['userName'] = $userName;
        $arr['status'] = $status;
        $arr['time'] = $time;
        $arr['location'] = $location;
        $arr['queueList'] = $queueList;

        $keyIndex = -1; //初期値

        if (isset($userOpt[$location])){

            $userId = $userOpt[$location]; 

            if (isset($extOpt[$location])){
                $extension = $extOpt[$location]; 
            }
	   if (isset($queueListOpt[$location])){
                $queueList = $queueListOpt[$location]; 
            }


            if (isset($userNameOpt[$userId])){
                $userName = mb_substr($userNameOpt[$userId],0,5); 
            }else{
                $userName = $userId;
            }

            if ($userId == ''){
                return '<td ondblclick="window.open(\''.$arr['editUrl'].$arr['location'].'\',null,\'width=400,height=320\');"'.$arr['class'].' >'.$arr['extension'].'<br>'.$arr['userName'].'<br><span>'.$arr['status'].'</span><br>'.$arr['time'].'<br>'.$arr['queueList'].'</td>';
            }

            if (array_search($userId, array_column($data, 'userId')) != false){
                //debug(array_search($userId, array_column($data, 'userId')));
                $keyIndex = array_search($userId, array_column($data, 'userId'));

            }else if (array_search($userId, array_column($data, 'userId')) === 0){
                //debug(array_search($userId, array_column($data, 'userId')));
                $keyIndex = array_search($userId, array_column($data, 'userId'));

            /*
            }else if ($keyIndex == -1){

                return '<td ondblclick="window.open(\''.$arr['editUrl'].$arr['location'].'\',null,\'width=400,height=320\');"'.$arr['class'].' >'.$arr['extension'].'<br>'.$arr['userName'].'<br><span>'.$arr['status'].'</span><br>'.$arr['time'].'</td>';
            */

            }else{ //$userId がログインしてない時

                $arr['class'] = $class;
                $arr['extension'] = $extension;
        	$arr['queueList'] = $queueList;
                $arr['userId'] = $userId;
                $arr['userName'] = $userName;
                $arr['status'] = $status;
                $arr['time'] = $time;

                return '<td ondblclick="window.open(\''.$arr['editUrl'].$arr['location'].'\',null,\'width=400,height=320\');"'.$arr['class'].' >'.$arr['extension'].'<br>'.$arr['userName'].'<br><span>'.$arr['status'].'</span><br>'.$arr['time'].'<br>'.$arr['queueList'].'</td>';
                //return $arr;
            }

            //debug($keyIndex);
            //debug(isset($data[$keyIndex]));

            if (isset($data[$keyIndex])){

                $statusChangeTime = intVal(substr($data[$keyIndex]['statusChangeTime'],0,10));
                $seconds = time() - $statusChangeTime;
                $h = floor($seconds / 3600);
                $m = floor(($seconds / 60) % 60);
                $s = $seconds % 60;
                $time = substr("0".$h,-2).':'.substr("0".$m,-2).':'.substr("0".$s,-2);

                $status = $data[$keyIndex]['status'];
                $isWorking = $data[$keyIndex]['isWorking'];
                $isOnHold = $data[$keyIndex]['isOnHold'];
                
                if ($status == "inactive" && $isWorking == true){
                    $status = "待機中";
                    $class = "style=\"background-color:#98fb98\"";
                }else if ($status == "inactive" && $isWorking == false){
                    $status = "離席中";
                    $class = "style=\"background-color:#696969;color:#fff\"";
                }else if ($status == "ringing"){
                    $status = "呼出中";
                    $class = "style=\"background-color:#87cefa\"";
                }else if ($status == "connected"){
                    $status = "通話中";
                    $class = "style=\"background-color:#87cefa\"";
                }else if ($status == "hungup" && $m < 5){
                    $status = "後処理中";
                    $class = "style=\"background-color:#ffff00\"";
                }else if ($status == "hungup" && $m >= 5 && $m < 10){
                    $status = "後処理中";
                    $class = "style=\"background-color:#ff7f50\"";
                }else if ($status == "hungup" && $m >= 10){
                    $status = "後処理中";
                    $class = "style=\"background-color:#dc143c;color:#fff\"";
                }else if ($isOnHold == true){
                    $status = "保留中";
                    $class = "style=\"background-color:#87cefa\"";
                }else{
                    $class = "";
                }

                $arr['class'] = $class;
                $arr['extension'] = $extension;
        	$arr['queueList'] = $queueList;
                $arr['userId'] = $userId;
                $arr['userName'] = $userName;
                $arr['status'] = $status;
                $arr['time'] = $time;
            }
        }
        debug($arr);
        return '<td ondblclick="window.open(\''.$arr['editUrl'].$arr['location'].'\',null,\'width=400,height=320\');"'.$arr['class'].' >'.$arr['extension'].'<br>'.$arr['userName'].'<br><span>'.$arr['status'].'</span><br>'.$arr['time'].'<br>'.$arr['queueList'].'</td>';
        //return $arr;
    }
    public function list(){
        //リストビュー画面

        //アメヨのセッションID
        $session = $this->request->session();
        $sessionId = $session->read('sessionId');

        //Calling Ping-Session API
        $res = $this->pingSessionAPI($sessionId);

        //セッション切れの場合は自動的に再ログインする
        if ($res = "error"){
            $id = $session->read('id');
            $pass = $session->read('pass');
            $this->autoReLogin($id,$pass); //Re-Create New SessionId
            $sessionId = $session->read('sessionId');
        }

        //Calling Rest API
        $this->restAPI($sessionId);

        //$this->setListValue();
    }
    
    public function crmAPI($sessionId = null){
	$apiurl="http://c037.ameyoj.com/user_queue_api/index.php?campaignId=1";
	$response1 = $http->get($apiurl,null,['headers' => ['sessionId' => $sessionId]]);
        $data1= json_decode($response1->body(),true);
	$this->set(compact('data1'));
        return $data1;
    }
    //アメヨユーザ情報を取得
    public function restAPI($sessionId = null){

        $url = "http://c037.ameyoj.com:8888/ameyorestapi/voice/userVoiceCampaignRuntimes/getByCampaign?campaignId=1";

        $http = new Client();
        $response = $http->get($url,null,['headers' => ['sessionId' => $sessionId]]);
        $data = json_decode($response->body(),true);
	$apiurl="http://c037.ameyoj.com/user_queue_api/index.php?campaignId=1";
	$response1 = $http->get($apiurl,null,['headers' => ['sessionId' => $sessionId]]);
	$data1= json_decode($response1->body(),true);
	//print_r($data1);
        $this->set(compact('data'));
        //debug($data);
        return $data;
    }
    //セッションタイマーを延長させる
    public function keepAliveAPI($sessionId = null){

        $url = 'http://c037.ameyoj.com:8888/ameyorestapi/session/keepAlive';

        $header = [
            'sessionId' => $sessionId,
            'Content-Type' => "application/json"
        ];
        $option = [
                'sessionId' => $sessionId,
                'lastProcessedPushId' => ""
            ];
        $http = new Client();
        $response = $http->post($url,json_encode($option),['headers' => $header]);
        /*$data = json_decode($response->body(),true);
        
        debug($data);
        $this->set(compact('data'));

        return $data;*/
    }
    //SessionIdが有効であるか判定する
    public function pingSessionAPI($sessionId = null){

        $url = "http://c037.ameyoj.com:8888/ameyowebaccess/command?command=ping-session&data={\"sessionId\":\"".$sessionId."\"}";

        $http = new Client();
        $response = $http->get($url,null,[]);
        $data = json_decode($response->body(),true);

        //debug($response);
        //debug($data);

        //Session 有効の場合、
        //[ 'alive' => true, 'serverTime' => (int) 1526351640930 ]
        //Session 切れの場合、
        //[ 'status' => 'error', 'reason' => 'Invalid session Id: d877-5af19133-ses-seatviewer-8892-402', 
        //  'details' => 'Invalid session Id: d877-5af19133-ses-seatviewer-8892-402' ]

        if (isset($data['alive'])){
            return "success";
        }else{
            return "error";
        }

    }
    public function autoReLogin($id,$pass){
        $url = 'http://c037.ameyoj.com:8888/ameyorestapi/session/login';

        if (empty($id) || empty($pass)){
            $this->redirect(array('controller' => 'users', 'action' => 'logout'));
        }

        $option = [
                'token' => $pass,
                'forceLogin' => true,
                'terminalInfo' => 'sheetviewer',
                'userId' => $id
            ];

        $http = new Client();
        $response = $http->post($url,json_encode($option),['type' => 'json']);
        $data = json_decode($response->body(),true);

        if (isset($data['userId']) == true){

            $session = $this->request->session();
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
                $this->Flash->error(__('AmeyoJからセッション情報が取得できませんでした'));
                return $this->redirect(array('controller' => 'users', 'action' => 'login'));
            }else{
                //return "ok";
            }
        }else{
            return $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

    }
	public function edit($location = null) {
		//編集子画面
       print_r($location); 
        $session = $this->request->session();
        $sessionId = $session->read('sessionId');

        if (empty($sessionId)){
            //セッションエラー
            $this->Flash->error(__('セッションエラー'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        
        //$locationの存在チェック
        $Locations = TableRegistry::get('locations');
        $exists = $Locations->exists(['location' => $location]);
        if ($exists == false){

            $seat = $Locations->newEntity();
            $timestamp = date('Y-m-d H:i:s');

            $seat->location = $location;
            $seat->created = $timestamp;
            $seat->created_user_id = "system";
            $seat->updated = $timestamp;
            $seat->updated_user_id = "system";

            if ($Locations->save($seat)) {

            }else{
                //エラーログ出力
                $this->log($seat->errors(), "error");
                $this->Flash->error(__('予期せぬエラーが発生しました'));
                $this->redirect(array('controller' => 'users', 'action' => 'logout'));
            }
        }

        $seat = $Locations->find()->where(['location' => $location, 'deleted is null'])->toArray();
        $id = $seat[0]['id'];
        $seat = $seat[0];

        if ($this->request->is(['patch', 'post', 'put'])) {

            //ログインユーザのID
            $loginUserId = $this->request->getSession()->read('id');

            //$seat = $Locations->get($id);

            $timestamp = date('Y-m-d H:i:s');
            $seat->id = $id;
            $seat->updated = $timestamp;
            $seat->updated_user_id = $loginUserId;

            $seat = $Locations->patchEntity($seat, $this->request->getData());

            if ($Locations->save($seat)) {
                $this->Flash->success(__('シートビューが更新されました'));
                
                //セッション書き込み（ページリダイレクト後に子画面を閉じる為に使用）
                $session = $this->request->session();
				$session->write('edit_submit', 'yes');

                //return $this->redirect(['action' => 'index']);
            }else{
                //エラーログ出力
                $this->log($seat->errors(), "error");
                $this->Flash->error(__('シートビューの更新に失敗しました'));
            }

        }

        $data = $seat;
		$this->set(compact('id','data','location'));
		$this->setListValue();
        //Default.ctpを使わない
        $this->viewBuilder()->layout(false);
	}
    public function setListValue(){
		//権限
		//$authOpt = ['1'=>'General','9'=>'Administrator'];

		//ユーザID
        $Locations = TableRegistry::get('Locations');
        $userOpt = $Locations->find('list', [
            'keyField' => 'location',
            'valueField' => 'user_id'
        ])
        ->where(['deleted is null'])
        ->toArray();

		//内線番号
	$queueList = $Locations->find('list', [
            'keyField' => 'location',
            'valueField' => 'queue_list'
        ])
        ->where(['deleted is null'])
        ->toArray();
	$queueListById = $Locations->find('list', [
            'keyField' => 'user_id',
            'valueField' => 'queue_list'
        ])
        ->where(['deleted is null'])
        ->toArray();

        $extOpt = $Locations->find('list', [
            'keyField' => 'location',
            'valueField' => 'extension'
        ])
        ->where(['deleted is null'])
        ->toArray();

        $extOptById = $Locations->find('list', [
            'keyField' => 'user_id',
            'valueField' => 'extension'
        ])
        ->where(['deleted is null'])
        ->toArray();

        //ユーザ名
        $Users = TableRegistry::get('Users');
        $userNameOpt = $Users->find('list', [
            'keyField' => 'user_id',
            'valueField' => 'user_name'
        ])
        ->where(['deleted is null'])
        ->toArray();

        //有効無効
        //$isActiveOpt = ['0'=>'Enabled','1'=>'Disabled'];

		$this->set(compact('userOpt','extOpt','queueList','extOptById','userNameOpt','queueListById'));

    }
}
