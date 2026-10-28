<?php
namespace App\Controller\Ipet;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class SeatsController extends AppController
{
    private const GRID = [
        'aomori' => ['title' => '【青森】', 'rows' => 6, 'columns' => 10, 'startRow' => 1],
        'tokyo' => ['title' => '【東京】', 'rows' => 4, 'columns' => 6, 'startRow' => 8],
        'scsk' => ['title' => '【SCSK】', 'rows' => 4, 'columns' => 3, 'startRow' => 8],
        'others' => ['title' => '', 'rows' => 3, 'columns' => 10, 'startRow' => 14],
    ];

    public static function render(array $data): string
    {
        $html = self::styles();
        $html .= '<div class="seat-viewer-container"><table class="mainSeatLayout">';
        $html .= self::renderSection('aomori', $data);
        $html .= '<tr class="section-spacer"><td colspan="10">&nbsp;</td></tr>';
        $html .= self::renderTokyoScsk($data);
        $html .= '<tr class="section-spacer"><td colspan="10"></td></tr>';
        $html .= self::renderSection('others', $data);
        return $html . '</table></div>';
    }

    private static function renderSection(string $section, array $data): string
    {
        $grid = self::GRID[$section];
        $html = sprintf('<tr class="section-header"><td colspan="%d" style="background-color:#98FB98">%s</td></tr>', $grid['columns'], $grid['title']);
        for ($row = 0; $row < $grid['rows']; $row++) {
            $html .= '<tr>';
            for ($col = 1; $col <= $grid['columns']; $col++) {
                $location = sprintf('%s_R%dC%d', $section, $grid['startRow'] + $row, $col);
                $html .= self::getSeatValue($location, $data);
            }
            $html .= '</tr>';
        }
        return $html;
    }

    private static function renderTokyoScsk(array $data): string
    {
        $html = '<tr class="section-header"><td colspan="6" style="background-color:#98FB98">【東京】</td><td></td><td colspan="3" style="background-color:#98FB98">【SCSK】</td></tr>';
        for ($row = 0; $row < 4; $row++) {
            $html .= '<tr>';
            for ($col = 1; $col <= 6; $col++) {
                $html .= self::getSeatValue(sprintf('tokyo_R%dC%d', 8 + $row, $col), $data);
            }
            $html .= '<td>&nbsp;</td>';
            for ($col = 9; $col <= 11; $col++) {
                $html .= self::getSeatValue(sprintf('scsk_R%dC%d', 8 + $row, $col), $data);
            }
            $html .= '</tr>';
        }
        return $html;
    }

    public static function getSeatValue(string $location, array $data): string
    {
        $editUrl = Router::url(['controller' => 'Seats', 'action' => 'edit'], false) . '/';
        $seat = ['class' => '', 'extension' => '', 'userName' => '&nbsp;&nbsp;&nbsp;', 'status' => '&nbsp;&nbsp;&nbsp;', 'time' => '&nbsp;&nbsp;&nbsp;'];

        $locations = TableRegistry::getTableLocator()->get('Locations');
        $locationData = $locations->find()->where(['location' => $location, 'deleted is null'])->first();
        if ($locationData && !empty($locationData->user_id)) {
            $users = TableRegistry::getTableLocator()->get('Users');
            $userData = $users->find()->where(['user_id' => $locationData->user_id, 'deleted is null'])->first();
            if ($userData) {
                $seat['userName'] = mb_substr((string)$userData->user_name, 0, 10);
                $seat['extension'] = (string)$locationData->extension;
                foreach ($data as $apiData) {
                    if (($apiData['userId'] ?? null) === $userData->user_id) {
                        $seat = self::updateStatus($seat, $apiData);
                        break;
                    }
                }
            }
        }

        return sprintf('<td class="seat-cell" ondblclick="window.open(\'%s%s\',null,\'width=400,height=320\');" %s><div class="seat-content"><p class="user-name">%s</p><p class="status">%s</p><p class="time">%s</p></div></td>', $editUrl, $location, $seat['class'], $seat['userName'], $seat['status'], $seat['time']);
    }

    private static function updateStatus(array $seat, array $api): array
    {
        $statusChange = isset($api['statusChangeTime']) ? (int)substr((string)$api['statusChangeTime'], 0, 10) : 0;
        $seconds = $statusChange > 0 ? max(0, time() - $statusChange) : 0;
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seat['time'] = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds % 60);

        $status = $api['status'] ?? '';
        $working = $api['isWorking'] ?? false;
        $hold = $api['isOnHold'] ?? false;
        $autoCall = $api['isOnAutoCall'] ?? false;

        if ($status === 'inactive' && $working) {
            $seat['status'] = $autoCall ? '利用可能' : '音声OFF';
            $seat['class'] = $autoCall ? '' : 'style="background-color:#F8CBAD"';
        } elseif ($status === 'inactive' && !$working) {
            $seat['status'] = $autoCall ? '利用不可' : '音声OFF';
            $seat['class'] = 'style="background-color:#C9C9C9;color:#fff"';
        } elseif ($status === 'ringing') {
            $seat['status'] = '呼出中';
            $seat['class'] = 'style="background-color:#87cefa"';
        } elseif ($status === 'connected') {
            $seat['status'] = '通話中';
            $seat['class'] = $minutes < 5 ? 'style="background-color:#00B0F0"' : ($minutes < 15 ? 'style="background-color:#FFFF00"' : 'style="background-color:#FF0000;color:#fff"');
        } elseif ($status === 'hungup') {
            $seat['status'] = '後処理中';
            $seat['class'] = $minutes < 5 ? 'style="background-color:#EDEDED"' : ($minutes < 10 ? 'style="background-color:#FFFF00"' : 'style="background-color:#FF0000;color:#fff"');
        } elseif ($hold) {
            $seat['status'] = '保留中';
            $seat['class'] = 'style="background-color:#87cefa"';
        }
        return $seat;
    }

    private static function styles(): string
    {
        return '<style>.seat-viewer-container{padding:20px;background-color:white}.mainSeatLayout{width:100%;border-collapse:collapse;table-layout:fixed}.section-header{height:30px;font-weight:bold}.section-header td{padding:5px;border:1px solid #ccc}.section-spacer{height:20px}.seat-cell{border:1px solid #ccc;padding:8px;text-align:center;vertical-align:middle;height:80px}.seat-content{display:flex;flex-direction:column;gap:4px;justify-content:center;align-items:center;height:100%}.user-name{font-weight:bold;margin:0;font-size:12px}.status{font-size:11px;margin:0}.time{font-size:10px;color:#666;margin:0}</style>';
    }
}
