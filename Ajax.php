<?php
$target = $_POST['ip'];
$target = str_replace(array('http://','https://','/'), '', $target);
$start_port = $_POST['start_port'];  // 起始端口号
$end_port = $_POST['end_port']; // 结束端口号
$timeout_ms = $_POST['timeout_ms']; // 每个端口扫描的超时时间（毫秒）
//判断是否都填写了
if (empty($target) || empty($start_port) || empty($end_port) || empty($timeout_ms)) {
    $result = array(
        'msg' => '请确保必填项不为空'
    );
    exit(json_encode($result, JSON_UNESCAPED_UNICODE));
}
$result = array();
for ($port = $start_port; $port <= $end_port; $port++) {
    if (scan_port($target, $port, $timeout_ms)) {
        $result[] = array(
            'port' => $port,
            'status' => '开启'
        );
    } else {
        $result[] = array(
            'port' => $port,
            'status' => '关闭'
        );
    }
}
header('Content-Type: application/json');
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
function scan_port($ip, $port, $timeout_ms) {
    $socket = @fsockopen($ip, $port, $errno, $errstr, $timeout_ms / 1000); // 将毫秒转换为秒
    if ($socket) {
        fclose($socket);
        return true;
    } else {
        return false;
    }
}
?>