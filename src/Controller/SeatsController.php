<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Controller\Ipet\SeatsController as IpetSeatsController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry; //追加
use Cake\Routing\Router; //追加

//API実行用
use Cake\Http\Client;
use Cake\Http\Client\Response as ClientResponse;
use Cake\Http\Response;

/**
 * Seats Controller
 *
 * @property \App\Model\Table\SeatsTable $Seats
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeatsController extends AppController{

    private function isIpetSeatView(): bool
    {
        $base = rtrim((string)Configure::read('App.base', ''), '/');
        return strtolower($base) === '/ipet_seatviewer';
    }

    public function initialize(): void{
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
        $session = $this->request->getSession();

        $sessionId = $session->read('sessionId');

        if (empty($sessionId)){
            //セッションエラー
            $this->Flash->error(__('セッションエラー'));
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
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
            $response = $this->autoReLogin($id, $pass);
            if ($response !== null) {
                return $response;
            }
            $sessionId = $session->read('sessionId');
        }

        //Calling Keep Alive API
        $this->keepAliveAPI($sessionId);

        if ($this->isIpetSeatView()) {
            $this->viewBuilder()->setTemplate('Ipet/index');
        }

        //Calling Rest API
        $this->restAPI($sessionId);

        //$this->setListValue();
    }
    public function ajax(){

        $this->autoRender = false;

        // Ajax通信でこのアクションが実行された時だけ処理を行う
        if ($this->request->is('ajax')) {

            //アメヨのセッションID
            $session = $this->request->getSession();
            $sessionId = $session->read('sessionId');
            //Calling Ping-Session API
            $res = $this->pingSessionAPI($sessionId);
            //セッション切れの場合は自動的に再ログインする
            if ($res == "error"){
                //debug("error");
                //debug($sessionId);
                $id = $session->read('id');
                $pass = $session->read('pass');
                $response = $this->autoReLogin($id, $pass);
                if ($response !== null) {
                    return $response;
                }
                $sessionId = $session->read('sessionId');
            }

            //Calling Keep Alive API
            $this->keepAliveAPI($sessionId);

            //Calling Rest API
            $data = $this->restAPI($sessionId);

            if ($this->isIpetSeatView()) {
                echo IpetSeatsController::render($data);
                return;
            }

            //HTMLを生成する
            $html = "";
            $html .= '<tr>';
                $html .= '<td style="padding:5px;font-weight:bold"></td>';
            $html .= '</tr>';

            $html .= '<tr>';
                $html .= '<td>';

                    $html .= '<table class="seatView">';
                        $html .= '<tr>';
                            $html .= '<th></th>';
                            $html .= '<th>1</th>';
                            $html .= '<th>2</th>';
                            
                        $html .= '</tr>';

                        $html .= '<tr>';
                            $html .= '<th>A</th>';
                            $html .= $this->getSeatValue("A1",$data);
                            $html .= $this->getSeatValue("A2",$data);
                            
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>B</th>';
                            $html .= $this->getSeatValue("B1",$data);
                            $html .= $this->getSeatValue("B2",$data);
                            
                        $html .= '</tr>';
					  $html .= '<tr>';
                            $html .= '<th>C</th>';
                            $html .= $this->getSeatValue("C1",$data);
                            $html .= $this->getSeatValue("C2",$data);
                            
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>B</th>';
                            $html .= $this->getSeatValue("D1",$data);
                            $html .= $this->getSeatValue("D2",$data);
                            
                        $html .= '</tr>';
                    $html .= '</table>';
                $html .= '</td>';
				
				
           
                $html .= '<td>';

                    $html .= '<table class="seatView">';
                        $html .= '<tr>';
                            $html .= '<th></th>';
                            $html .= '<th>1</th>';
                            $html .= '<th>2</th>';
                            
                        $html .= '</tr>';

                        $html .= '<tr>';
                            $html .= '<th>E</th>';
                            $html .= $this->getSeatValue("E1",$data);
                            $html .= $this->getSeatValue("E2",$data);
                            
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>F</th>';
                            $html .= $this->getSeatValue("F1",$data);
                            $html .= $this->getSeatValue("F2",$data);
                            
                        $html .= '</tr>';
					  $html .= '<tr>';
                            $html .= '<th>G</th>';
                            $html .= $this->getSeatValue("G1",$data);
                            $html .= $this->getSeatValue("G2",$data);
                            
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>H</th>';
                            $html .= $this->getSeatValue("H1",$data);
                            $html .= $this->getSeatValue("H2",$data);
                            
                        $html .= '</tr>';
                    $html .= '</table>';
                $html .= '</td>';
				 $html .= '<td>';

                    $html .= '<table class="seatView">';
                        $html .= '<tr>';
                            $html .= '<th></th>';
                            $html .= '<th>1</th>';
                            $html .= '<th>2</th>';
                            
                        $html .= '</tr>';

                        $html .= '<tr>';
                            $html .= '<th>I</th>';
                            $html .= $this->getSeatValue("I1",$data);
                            $html .= $this->getSeatValue("I2",$data);
                            
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>J</th>';
                            $html .= $this->getSeatValue("J1",$data);
                            $html .= $this->getSeatValue("J2",$data);
                            
                        $html .= '</tr>';
					  $html .= '<tr>';
                            $html .= '<th>K</th>';
                            $html .= $this->getSeatValue("K1",$data);
                            $html .= $this->getSeatValue("K2",$data);
                            
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>L</th>';
                            $html .= $this->getSeatValue("L1",$data);
                            $html .= $this->getSeatValue("L2",$data);
                            
                        $html .= '</tr>';
                    $html .= '</table>';
                $html .= '</td>';
				 $html .= '<td>';

                    $html .= '<table class="seatView">';
                        $html .= '<tr>';
                            $html .= '<th></th>';
                            $html .= '<th>1</th>';
                            $html .= '<th>2</th>';
                            
                        $html .= '</tr>';

                        $html .= '<tr>';
                            $html .= '<th>M</th>';
                            $html .= $this->getSeatValue("M1",$data);
                            $html .= $this->getSeatValue("M2",$data);
                            
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>N</th>';
                            $html .= $this->getSeatValue("N1",$data);
                            $html .= $this->getSeatValue("N2",$data);
                            
                        $html .= '</tr>';
					  $html .= '<tr>';
                            $html .= '<th>O</th>';
                            $html .= $this->getSeatValue("O1",$data);
                            $html .= $this->getSeatValue("O2",$data);
                            
                        $html .= '</tr>';
                        $html .= '<tr>';
                            $html .= '<th>P</th>';
                            $html .= $this->getSeatValue("P1",$data);
                            $html .= $this->getSeatValue("P2",$data);
                            
                        $html .= '</tr>';
                    $html .= '</table>';
                $html .= '</td>';
				
				
            $html .= '</tr>';
/*
            $html .= '<tr>';
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
	$queue= "";
        $time = "";
        $class = "";

        $edit_url = Router::url(['controller' => 'Seats', 'action' => 'edit'], false)."/";

		//ユーザID
        $Locations = \Cake\ORM\TableRegistry::getTableLocator()->get('Locations');
        $userOpt = $Locations->find('list', keyField: 'location', valueField: 'user_id')->where(['deleted is null'])->toArray();

		//内線番号
        $extOpt = $Locations->find('list', keyField: 'location', valueField: 'extension')->where(['deleted is null'])->toArray();

        //ユーザ名
        $Users = \Cake\ORM\TableRegistry::getTableLocator()->get('Users');
        $userNameOpt = $Users->find('list', keyField: 'user_id', valueField: 'user_name')->where(['deleted is null'])->toArray();

        $arr['editUrl'] = $edit_url;
        $arr['class'] = $class;
        $arr['extension'] = $extension;
        $arr['userId'] = "";
        $arr['userName'] = $userName;
        $arr['status'] = $status;
        $arr['queue'] = $queue;
        $arr['time'] = $time;
        $arr['location'] = $location;

        $keyIndex = -1; //初期値

        if (isset($userOpt[$location])){

            $userId = $userOpt[$location]; 

            if (isset($extOpt[$location])){
                $extension = $extOpt[$location]; 
            }

            if (isset($userNameOpt[$userId])){
                $userName = mb_substr($userNameOpt[$userId],0,10); 
            }else{
                $userName = $userId;
            }

            if ($userId == ''){
                return '<td ondblclick="window.open(\''.$arr['editUrl'].$arr['location'].'\',null,\'width=400,height=320\');"'.$arr['class'].' >'.$arr['extension'].'<br>'.$arr['userName'].'<br><span>'.$arr['status'].'</span><br>'.$arr['queue'].'<br>'.$arr['time'].'</td>';
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
                $arr['userId'] = $userId;
                $arr['userName'] = $userName;
                $arr['status'] = $status;
                $arr['queue'] = $queue;

                $arr['time'] = $time;

                return '<td ondblclick="window.open(\''.$arr['editUrl'].$arr['location'].'\',null,\'width=400,height=320\');"'.$arr['class'].' >'.$arr['extension'].'<br>'.$arr['userName'].'<br><span>'.$arr['status'].'</span><br>'.$arr['queue'].'<br>'.$arr['time'].'</td>';
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
				$queue = $data[$keyIndex]['queueName'];
				$isOnAutoCall = $data[$keyIndex]['isOnAutoCall'];
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
                $arr['userId'] = $userId;
                $arr['userName'] = $userName;
                $arr['status'] = $status;
                $arr['queue'] = $queue;
                $arr['time'] = $time;
            }
        }
        //debug($arr);
        return '<td ondblclick="window.open(\''.$arr['editUrl'].$arr['location'].'\',null,\'width=400,height=320\');"'.$arr['class'].' >'.$arr['extension'].'<br>'.$arr['userName'].'<br><span>'.$arr['status'].'</span><br>'.$arr['queue'].'<br>'.$arr['time'].'</td>';
        //return $arr;
    }
    public function list(){
        //リストビュー画面

        //アメヨのセッションID
        $session = $this->request->getSession();
        $sessionId = $session->read('sessionId');
        if (empty($sessionId)) {
            $this->Flash->error(__('セッションエラー'));
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        }

        //Calling Ping-Session API
        $res = $this->pingSessionAPI($sessionId);

        //セッション切れの場合は自動的に再ログインする
        if ($res === "error"){
            $id = $session->read('id');
            $pass = $session->read('pass');
            $response = $this->autoReLogin($id, $pass);
            if ($response !== null) {
                return $response;
            }
            $sessionId = $session->read('sessionId');
        }

        //Calling Rest API
        $this->restAPI($sessionId);

        //$this->setListValue();
    }

    //アメヨユーザ情報を取得
    public function restAPI($sessionId = null){

        $campaignId = (string)\Cake\Core\Configure::read('Ameyo.campaignId', '1');
        $campaignId = rawurlencode($campaignId);

        $url = $this->ameyoApiUrl('/ameyorestapi/voice/userVoiceCampaignRuntimes/getByCampaign?campaignId=' . $campaignId);

        $http = new Client();
        $response = $http->get($url, [], ['headers' => ['sessionId' => $sessionId]]);
        $data = $this->decodeAmeyoListResponse($response, 'userVoiceCampaignRuntimes');

        if ($this->isIpetSeatView()) {
            $agentListURL = $this->ameyoApiUrl('/ameyorestapi/cc/userCCPresences');
            $response2 = $http->get($agentListURL, [], ['headers' => ['sessionId' => $sessionId]]);
            $data2 = $this->decodeAmeyoListResponse($response2, 'userCCPresences');
            foreach ($data as $key => $value) {
                $data[$key]['isOnAutoCall'] = false;
                foreach ($data2 as $presence) {
                    if (($presence['sessionId'] ?? null) === ($value['sessionId'] ?? null)) {
                        $data[$key]['isOnAutoCall'] = $presence['isOnAutoCall'] ?? false;
                        break;
                    }
                }
            }
        } else {
            $queueListURL = $this->ameyoApiUrl('/ameyorestapi/cc/agentQueues/getByCampaign?campaignId=' . $campaignId);
            $response1 = $http->get($queueListURL, [], ['headers' => ['sessionId' => $sessionId]]);
            $data1 = $this->decodeAmeyoListResponse($response1, 'agentQueues');
            foreach ($data as $key => $value) {
                $data[$key]['queueName'] = '';
                $filterBy = $value['currentCallAgentQueueId'] ?? null;
                if ($filterBy === null) {
                    continue;
                }
                foreach ($data1 as $queue) {
                    if (($queue['agentQueueId'] ?? null) == $filterBy) {
                        $data[$key]['queueName'] = $queue['queueName'] ?? '';
                        break;
                    }
                }
            }
        }


        $this->set(compact('data'));
        //debug($data);
        return $data;
    }

    private function decodeAmeyoListResponse(ClientResponse $response, string $endpoint): array
    {
        if (!$response->isSuccess()) {
            $this->log(sprintf(
                'Ameyo API endpoint "%s" returned HTTP %d; Seat Viewer data will be empty.',
                $endpoint,
                $response->getStatusCode()
            ), 'error');
            return [];
        }

        $data = json_decode($response->getStringBody(), true);
        if (!is_array($data) || !array_is_list($data)) {
            $this->log(sprintf(
                'Ameyo API endpoint "%s" returned an unexpected response; expected a JSON list of records.',
                $endpoint
            ), 'error');
            return [];
        }

        foreach ($data as $record) {
            if (!is_array($record)) {
                $this->log(sprintf(
                    'Ameyo API endpoint "%s" returned a record with an unexpected format.',
                    $endpoint
                ), 'error');
                return [];
            }
        }

        return $data;
    }

    //セッションタイマーを延長させる
    public function keepAliveAPI($sessionId = null){

        $url = $this->ameyoApiUrl('/ameyorestapi/session/keepAlive');

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

        $url = $this->ameyoApiUrl('/ameyowebaccess/command?command=ping-session&data={' . '"sessionId":"' . $sessionId . '"}');

        $http = new Client();
        $response = $http->get($url, [], []);
        $data = json_decode($response->getStringBody(), true);

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
    public function autoReLogin($id, $pass): ?\Cake\Http\Response{
        $url = $this->ameyoApiUrl('/ameyorestapi/session/login');

        if (empty($id) || empty($pass)){
            $this->request->getSession()->destroy();
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        }

        $option = [
                'token' => $pass,
                'forceLogin' => true,
                'terminalInfo' => 'sheetviewer',
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
                $this->Flash->error(__('AmeyoJからセッション情報が取得できませんでした'));
                return $this->redirect(['controller' => 'users', 'action' => 'login']);
            }else{
                return null;
            }
        }else{
            $this->request->getSession()->destroy();
            $this->Flash->error(__('AmeyoJからセッション情報が取得できませんでした'));
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        }

    }
	public function edit($location = null) {
		//編集子画面
        
        $session = $this->request->getSession();
        $sessionId = $session->read('sessionId');

        if (empty($sessionId)){
            //セッションエラー
            $this->Flash->error(__('セッションエラー'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        
        //$locationの存在チェック
        $Locations = \Cake\ORM\TableRegistry::getTableLocator()->get('locations');
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
                $session = $this->request->getSession();
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
        $this->viewBuilder()->setLayout(null);
	}
    public function setListValue(){
		//権限
		//$authOpt = ['1'=>'General','9'=>'Administrator'];

		//ユーザID
        $Locations = \Cake\ORM\TableRegistry::getTableLocator()->get('Locations');
        $userOpt = $Locations->find('list',
        keyField: 'location',
        valueField: 'user_id')
        ->where(['deleted is null'])
        ->toArray();

		//内線番号
        $extOpt = $Locations->find('list',
        keyField: 'location',
        valueField: 'extension')
        ->where(['deleted is null'])
        ->toArray();

        $extOptById = $Locations->find('list',
        keyField: 'user_id',
        valueField: 'extension')
        ->where(['deleted is null'])
        ->whereNotNull('user_id')
        ->toArray();

        //ユーザ名
        $Users = \Cake\ORM\TableRegistry::getTableLocator()->get('Users');
        $userNameOpt = $Users->find('list',
        keyField: 'user_id',
        valueField: 'user_name')
        ->where(['deleted is null'])
        ->toArray();

        //有効無効
        //$isActiveOpt = ['0'=>'Enabled','1'=>'Disabled'];

		$this->set(compact('userOpt','extOpt','extOptById','userNameOpt'));

    }
}
