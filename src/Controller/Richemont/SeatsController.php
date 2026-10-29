<?php
namespace App\Controller\Richemont;

use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class SeatsController
{
    public static function render(array $data): string
    {
        $html = self::styles();
        $html .= '<tr><td style="padding:5px;font-weight:bold"></td></tr><tr><td>';
        $html .= '<table class="seatView"><tr><th></th><th>1</th><th>2</th><th>3</th><th class="space"></th><th>4</th><th>5</th></tr>';
        $html .= '<tr><th>A</th>';
        foreach (["I1", "I2", "I3"] as $location) { $html .= self::getSeatValue($location, $data); }
        $html .= '<td class="space"></td>' . self::getSeatValue('I4', $data) . self::getSeatValue('I5', $data) . '</tr>';
        $html .= '<tr><th>B</th>';
        foreach (["J1", "J2", "J3"] as $location) { $html .= self::getSeatValue($location, $data); }
        $html .= '<td class="space"></td>' . self::getSeatValue('J4', $data) . self::getSeatValue('J5', $data) . '</tr>';
        $html .= '<tr><th>C</th>';
        foreach (["K1", "K2"] as $location) { $html .= self::getSeatValue($location, $data); }
        $html .= '<td class="space"></td><td class="space"></td>' . self::getSeatValue('K3', $data) . self::getSeatValue('K4', $data);
        return $html . '</tr></table></td></tr>';
    }

    public static function getSeatValue(string $location, array $data): string
    {
        $editUrl = Router::url(['controller' => 'Seats', 'action' => 'edit'], false) . '/';
        $seat = ['class' => '', 'extension' => '', 'userId' => '', 'userName' => '', 'status' => '', 'time' => ''];
        $locations = TableRegistry::getTableLocator()->get('Locations');
        $locationData = $locations->find()->where(['location' => $location, 'deleted is null'])->first();
        if ($locationData && !empty($locationData->user_id)) {
            $seat['userId'] = (string)$locationData->user_id;
            $seat['extension'] = (string)$locationData->extension;
            $users = TableRegistry::getTableLocator()->get('Users');
            $userData = $users->find()->where(['user_id' => $seat['userId'], 'deleted is null'])->first();
            if ($userData) { $seat['userName'] = mb_substr((string)$userData->user_name, 0, 10); }
            foreach ($data as $apiData) {
                if ((string)($apiData['userId'] ?? '') === (string)$seat['userId']) {
                    $seat = self::updateStatus($seat, $apiData);
                    break;
                }
            }
        }
        return sprintf('<td style="min-width:300px" ondblclick="window.open(\'%s%s\',null,\'width=400,height=300\');" %s>%s<br>%s<br>%s<br><span>%s</span><br>%s</td>', $editUrl, $location, $seat['class'], $seat['extension'], $seat['userName'], $seat['userId'], $seat['status'], $seat['time']);
    }

    private static function updateStatus(array $seat, array $api): array
    {
        $statusChange = isset($api['statusChangeTime']) ? (int)substr((string)$api['statusChangeTime'], 0, 10) : 0;
        $seconds = $statusChange > 0 ? max(0, time() - $statusChange) : 0;
        $h = floor($seconds / 3600); $m = floor(($seconds / 60) % 60); $s = $seconds % 60;
        $seat['time'] = sprintf('%02d:%02d:%02d', $h, $m, $s);
        $status = $api['status'] ?? ''; $working = $api['isWorking'] ?? false; $hold = $api['isOnHold'] ?? false;
        if ($status === 'inactive' && $working) { $seat['status'] = '待機中'; $seat['class'] = 'style="background-color:#98fb98;min-width:300px;"'; }
        elseif ($status === 'inactive' && !$working) { $seat['status'] = '離席中'; $seat['class'] = 'style="background-color:#696969;color:#fff;min-width:300px;"'; }
        elseif ($status === 'ringing') { $seat['status'] = '呼出中'; $seat['class'] = 'style="background-color:#87cefa;min-width:300px;"'; }
        elseif ($status === 'connected') { $seat['status'] = '通話中'; $seat['class'] = 'style="background-color:#87cefa;min-width:300px;"'; }
        elseif ($status === 'hungup' && $m < 3) { $seat['status'] = '後処理中'; $seat['class'] = 'style="background-color:#ffff00;min-width:300px;"'; }
        elseif ($status === 'hungup' && $m >= 3 && $m < 6) { $seat['status'] = '後処理中'; $seat['class'] = 'style="background-color:#ff7f50;min-width:300px;"'; }
        elseif ($status === 'hungup' && $m >= 6) { $seat['status'] = '後処理中'; $seat['class'] = 'style="background-color:#dc143c;color:#fff;min-width:300px;"'; }
        elseif ($hold) { $seat['status'] = '保留中'; $seat['class'] = 'style="background-color:#87cefa;min-width:300px;"'; }
        return $seat;
    }

    private static function styles(): string
    {
        return '<style>.seatView{border-collapse:collapse}.seatView th,.seatView td{border:1px solid #ddd;padding:4px}.seatView .space{border:none!important}</style>';
    }
}
