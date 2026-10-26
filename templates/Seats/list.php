<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompanyStaff[]|\Cake\Collection\CollectionInterface $companyStaffs
 */
?>
<?php //debug($data); 

?>


<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>


<script>
    $(function(){
        $('td[data-href]', 'table.seatView').on('dblclick', function(){
            //location.href = $(this).data('href');
            window.open($(this).data('href'),null,'width=400,height=320');
        });
    });
</script>

<?php
$href = $this->Url->build(['controller'=>'Seats', 'action'=>'edit'])."/";
?>
<div class="bs-docs-section clearfix">
	<div class="panel panel-primary filterable">
		<div class="panel-heading">
			<h3 class="panel-title">AmeyoJ User List Viewer</h3>
        </div>
		<table id="dt" style="font-size:15px" class="table table-striped table-hover ">
			<thead>
				<tr height="35" style="vertical-align:middle;color:#ffffff;" bgcolor="#000080">
                    <td width="10%" style="vertical-align:middle;color:#ffffff;" bgcolor="#000080">内線番号</td>
					<td width="10%" style="vertical-align:middle;color:#ffffff;" bgcolor="#000080">ユーザID</td>
					<td width="10%" style="vertical-align:middle;color:#ffffff;" bgcolor="#000080">ユーザ名</td>
					<td width="10%" style="vertical-align:middle;color:#ffffff;" bgcolor="#000080">ステータス</td>
					<td width="10%" style="vertical-align:middle;color:#ffffff;" bgcolor="#000080">経過時間</td>
				</tr>
			</thead>
			<tbody>	
				<?php foreach ($data as $row): ?>

                <?php
                    $statusChangeTime = intVal(substr($row['statusChangeTime'],0,10));
                    $seconds = time() - $statusChangeTime;
                    $h = floor($seconds / 3600);
                    $m = floor(($seconds / 60) % 60);
                    $s = $seconds % 60;
                    $time = substr("0".$h,-2).':'.substr("0".$m,-2).':'.substr("0".$s,-2);

                    $status = $row['status'];
                    $isWorking = $row['isWorking'];
                    $isOnHold = $row['isOnHold'];
                    $color = "";

                    $user_id = $row['userId'];
                    if (!empty($extOptById[$user_id])){
                        $extension = $extOptById[$user_id];
                    }else{
                        $extension = "";
                    }
                    if (!empty($userNameOpt[$user_id])){
                        $user_name = $userNameOpt[$user_id];
                    }else{
                        $user_name = "";
                    }

                    if ($status == "inactive" && $isWorking == true){
                        $status = "待機中";
                        $color = "background-color:#98fb98";
                    }else if ($status == "inactive" && $isWorking == false){
                        $status = "離席中";
                        $color = "background-color:#696969;color:#fff";
                    }else if ($status == "ringing"){
                        $status = "呼出中";
                    }else if ($status == "connected"){
                        $status = "通話中";
                        $color = "background-color:#87cefa";
                    }else if ($status == "hungup" && $m < 5){
                        $status = "後処理中";
                        $color = "background-color:#ffff00";
                    }else if ($status == "hungup" && $m >= 5 && $m < 10){
                        $status = "後処理中";
                        $color = "background-color:#ff7f50";
                    }else if ($status == "hungup" && $m >= 10){
                        $status = "後処理中";
                        $color = "background-color:#dc143c;color:#fff";
                    }else if ($isOnHold == true){
                        $status = "保留中";
                        $color = "background-color:#87cefa";
                    }else{
                        $color = "";
                    }
                ?>
				<tr>
                    <td><?= $extension ?>&nbsp;</td>
					<td><?= $user_id ?>&nbsp;</td>
                    <td><?= $user_name ?>&nbsp;</td>
                    <td style="<?= $color ?>"><?= $status ?>&nbsp;</td>
                    <td><?= $time ?>&nbsp;</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>



        <br><br>
        <!--<div align="center">
            <a href="<?= $this->Url->build(['controller'=>'homes', 'action'=>'index']); ?>">
                <input type="button" style="width:130px;cursor:pointer" class="btn btn-dark" value="Back">
            </a>
        </div>-->
        <br><br>
    </div>
</div>
<?php
function createSeat($location,$userOpt,$extOpt,$userNameOpt,$data,$href){

    $extension = "";
    $user_name = "";
    $status = "";
    $time = "";

    if (isset($userOpt[$location])){
        $userId = $userOpt[$location]; 
        if (isset($extOpt[$location])){
            $extension = $extOpt[$location]; 
        }
        if (isset($userNameOpt[$userId])){
            $user_name = mb_substr($userNameOpt[$userId],0,5); 
        }else{
            $user_name = $userId;
        }

        $keyIndex = array_search($userId, array_column($data, 'userId'));

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
                $class = "background-color:#98fb98";
            }else if ($status == "inactive" && $isWorking == false){
                $status = "離席中";
                $class = "background-color:#696969;color:#fff";
            }else if ($status == "ringing"){
                $status = "呼出中";
            }else if ($status == "connected"){
                $status = "通話中";
                $class = "background-color:#87cefa";
            }else if ($status == "hungup" && $m < 5){
                $status = "後処理中";
                $class = "background-color:#ffff00";
            }else if ($status == "hungup" && $m > 5 && $m < 10){
                $status = "後処理中";
                $class = "background-color:#ff7f50";
            }else if ($status == "hungup" && $m > 10){
                $status = "後処理中";
                $class = "background-color:#dc143c;color:#fff";
            }else if ($isOnHold == true){
                $status = "保留中";
                $class = "background-color:#87cefa";
            }else{
                $class = "";
            }

        }


        echo "<td style=\"".$class."\" data-href=\"".$href.$location."\">".$extension."<br>".$user_name."<br><span>".$status."</span><br>".$time."</td>";
    }else{
        echo "<td data-href=\"".$href.$location."\"><br><br><span style=\"background-color:cyan\"></span><br></td>";
    }



}

?>

	<script>
		var dt = new Date();
		$(document).ready(function() {
			var dt = $('#dt').DataTable( {
					autoWidth: false,
					pageLength: 20,
					lengthChange: false,
					language: 
						{
							url: "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Japanese.json"
						},
					//dom : "<'header_area'<'#header_left'B>f>t<'footer_area'<'#footer_left'i>p>",
					//dom : "<lBf<t>ip>",
					dom: '<"pull-left"f><"pull-right"Bl>ti<"pull-left"p>',
					order: [[ 1, "asc" ]], //「表示順」の昇順
					columnDefs: [
						{ type: 'currency', targets: [0] }, // targetsにはCurrencyでソートしたい列のインデックスを渡します
						/*{
							"targets": [1],
							"visible": false,
							"searchable": true,
							"orderData": [12]
						}*/
					]
				} )

		});
	</script>
