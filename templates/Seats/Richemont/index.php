<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompanyStaff[]|\Cake\Collection\CollectionInterface $companyStaffs
 */
?>
<?php //debug($data); 
/*
[
	'numCallsSinceLogin' => (int) 1,
	'dispositionSummary' => [
		'完了' => (int) 3
	],
	'isListeningVoiceLog' => false,
	'status' => 'hungup',
	'isWorking' => true,
	'isOnHold' => false,
	'currentCallAgentQueueId' => (int) 8,
	'userId' => 'saikusa',
	'sessionId' => 'd877-5af19133-ses-saikusa-2491-307',
	'crtObjectId' => 'd877-5af19133-ses-saikusa-2491-307-uce-31',
	'campaignId' => (int) 1,
	'ownerCRTObjectId' => 'd877-5af19133-vce-daf-3846',
	'name' => 'saikusa',
	'statusChangeTime' => (int) 1526280321954
]
*/
?>
<script>
    $(function(){
        /*$('td[data-href]', 'table.seatView').on('dblclick', function(){
            //location.href = $(this).data('href');
            window.open($(this).data('href'),null,'width=400,height=320');
        });*/

        //Ajax URL
        var url = "<?= $this->Url->build(['controller'=>'Seats', 'action'=>'ajax']) ?>";
        //Ajaxの処理を呼び出す
        execAjax(url);
        var interval = 5000;

        //繰り返し実行
        setInterval(
            function(){
                execAjax(url);
            },interval
        );

        var waitingUrl = "<?= $this->Url->build(['controller'=>'Seats', 'action'=>'waitingcalls']) ?>";
        execAjaxTarget(waitingUrl, '#waitingcalls');
        setInterval(function(){ execAjaxTarget(waitingUrl, '#waitingcalls'); }, 2000);

    });
    function execAjax(url) {
        //url = "https://oa.ameyoj.jp/seatviewer/seats/ajax";
        $.ajax({
            url: url,
            async: false,
            type: "GET",
            dataType: "text",
            error: function (jqXHR, textStatus, errorThrown) {},
            success: function (data, textStatus, jqXHR) {
                //console.log(jqXHR);
                //console.log(textStatus);
                result = data;

                //console.log(result);

                $("#ajax").empty();
                $('#ajax').append(result);
            }
        });
    }
    function execAjaxTarget(url, target) {
        $.ajax({
            url: url,
            async: false,
            type: "GET",
            dataType: "text",
            error: function () {},
            success: function (data) {
                $(target).empty().append(data);
            }
        });
    }
</script>

<?php
$href = $this->Url->build(['controller'=>'Seats', 'action'=>'edit'])."/";
?>
<div class="bs-docs-section clearfix">
	<div class="panel panel-primary filterable">
		<div class="panel-heading">
			<h3 class="panel-title">AmeyoJ Seat Viewer</h3>
        </div>
        <div id="waitingcalls"></div>
        <table id="ajax" class="table-clickable">
            <tr>
                <td style="padding:5px;font-weight:bold"></td>
            </tr>
            <tr>
                <td>
                    <table class="seatView">
                        <tr>
                            <th></th>
                            <th>1</th>
                            <th>2</th>

                        </tr>
                        <tr>
                            <th>A</th>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <th>B</th>
                            <td></td>
                            <td></td>

                        </tr>

                        <tr>
                            <th></th>
                            <th>1</th>
                            <th>2</th>

                        </tr>
                        <tr>
                            <th>C</th>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <th>D</th>
                            <td></td>
                            <td></td>

                        </tr>
                    </table>
                </td>
				<td>
                    <table class="seatView">
                        <tr>
                            <th></th>
                            <th>1</th>
                            <th>2</th>

                        </tr>
                        <tr>
                            <th>E</th>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <th>F</th>
                            <td></td>
                            <td></td>

                        </tr>

                        <tr>
                            <th></th>
                            <th>1</th>
                            <th>2</th>

                        </tr>
                        <tr>
                            <th>G</th>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <th>H</th>
                            <td></td>
                            <td></td>

                        </tr>
                    </table>
                </td>
				<td>
                    <table class="seatView">
                        <tr>
                            <th></th>
                            <th>1</th>
                            <th>2</th>

                        </tr>
                        <tr>
                            <th>I</th>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <th>J</th>
                            <td></td>
                            <td></td>

                        </tr>

                        <tr>
                            <th></th>
                            <th>1</th>
                            <th>2</th>

                        </tr>
                        <tr>
                            <th>K</th>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <th>L</th>
                            <td></td>
                            <td></td>

                        </tr>
                    </table>
                </td>
				<td>
                    <table class="seatView">
                        <tr>
                            <th></th>
                            <th>1</th>
                            <th>2</th>

                        </tr>
                        <tr>
                            <th>M</th>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <th>N</th>
                            <td></td>
                            <td></td>

                        </tr>

                        <tr>
                            <th></th>
                            <th>1</th>
                            <th>2</th>

                        </tr>
                        <tr>
                            <th>O</th>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <th>P</th>
                            <td></td>
                            <td></td>

                        </tr>
                    </table>
                </td>


            </tr>
            <!--tr>
                <td style="padding:5px;font-weight:bold">・沖縄</td>
            </tr>
            <tr>
                <td>
                    <table class="seatView">
                        <tr>
                            <th></th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                        </tr>
                        <tr>
                            <th>I</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>J</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table class="seatView">
                        <tr>
                            <th></th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                        </tr>
                        <tr>
                            <th>K</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>L</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr-->
        </table>
        <br><br>
    </div>
</div>
