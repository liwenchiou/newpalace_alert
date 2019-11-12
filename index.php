<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>新天地網路設備監測記錄</title>
        <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<style>
			body {padding:10px 0 0;}
			.paging {text-align:center;}
		</style>

    </head>
    <body>
    <div class="container text-center">
    <h2>新天地網路設備監測記錄</h2>
    <input type="button" class="btn btn-info" value="全部"  onclick="javascript:location.href='index.php'">
    <input type="button" class="btn btn-danger" value="ALERT"  onclick="javascript:location.href='?type=ALERT'">
    <input type="button" class="btn btn-success" value="DEBUG"  onclick="javascript:location.href='?type=DEBUG'">
    </div>
    <br>
		<?php
    require_once 'func_pdo.php';
    require_once 'fun_paging.php';

    if (@$_GET['type']) {
        $type = 'type=\''.$_GET['type'].'\'';
    } else {
        $type = '';
    }

    $pdo = connect('newpalace_alert', 'mysql', '192.168.2.19', 'utf8', '3306', 'root', 'admin123');
        // 获取总记录数
    $total = find($pdo, 'data_log', 'count(*) as total', $type);
    $record = $total['total'];
    $pagesize = 20;
        // 获取总页数
    $page = ceil($record / $pagesize);
    $p = isset($_GET['p']) ? intval($_GET['p']) : 1;
    $staffs = select($pdo, 'data_log', ['datetime', 'type', 'text'], $type, 'ID desc limit '.($p - 1) * $pagesize.','.$pagesize);
    ?>
        <div class="container">
            <table id="tbl" class="table table-striped table-bordered table-hover">
                <tr style="text-align:center;">
                    <td><b>記錄時間</b></td>
                    <td><b>紀錄類別</b></td>
                    <td><b>紀錄內容</b></td>
                </tr>
				<?php
    if (!empty($staffs)) {
        foreach ($staffs as $v) {
            ?>
						<tr style="text-align:center;">
							<td><?php echo $v['datetime']; ?></td>
							<td><?php echo $v['type']; ?></td>
							<td><?php echo $v['text']; ?></td>
						</tr>	
						<?php
        }
    }
?>
            </table> 
        </div>
		<div class="paging">
			<?php echo paging($p, $page); ?>
		</div> 
    </body>
</html>