<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>Nathan_Port端口扫描</title>
<link href="/Static/css/bootstrap.min.css" rel="stylesheet">
<link href="/Static/css/materialdesignicons.min.css" rel="stylesheet">
<link href="/Static/css/style.min.css" rel="stylesheet">
    <style>
        .site-content {
            margin: 0 20%;
            width: 60%;
        }
        @media (max-width: 769px) {
            .site-content {
                margin: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid p-t-15 site-content">
  <div class="row">
      <div class="col-md-12">
          <div class="card">
              <div class="card-body">
                  <div class="form-group">
                      <label>IP：</label>
                      <input class="form-control" placeholder="请输入您需要扫描的IP（无http(s)://）" type="text" name="ip">
                  </div>
                  <div class="form-group">
                      <label>起始端口号：</label>
                      <input class="form-control" placeholder="请输入您需要扫描的起始端口号" type="text" name="start_port">
                  </div>
                  <div class="form-group">
                      <label>结束端口号：</label>
                      <input class="form-control" placeholder="请输入您需要扫描的结束端口号" type="text" name="end_port">
                  </div>
                  <div class="form-group">
                      <label>超时时间（毫秒）：</label>
                      <input class="form-control" placeholder="请输入您需要扫描的超时时间（毫秒）" type="text" name="timeout_ms">
                  </div>
                  <div class="form-group text-center">
                      <button type="submit" id="nathan" class="btn btn-label btn-info"><label><i class="mdi mdi-checkbox-marked-circle-outline"></i></label> 立即扫描</button>
                  </div>
              </div>
          </div>
      </div>
    </div>
    <script type="text/javascript" src="/Static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Static/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/Static/js/main.min.js"></script>
    <script src="/Static/layer/layer.js"></script>
    <script>
        $('#nathan').click(function () {
            var ip = $("input[name='ip']").val();
            var start_port = $("input[name='start_port']").val();
            var end_port = $("input[name='end_port']").val();
            var timeout_ms = $("input[name='timeout_ms']").val();
            if(ip.length < 1 || start_port.length < 1 || end_port.length < 1 || timeout_ms.length < 1){
                layer.msg('请确保必填项不为空', {icon: 5, anim: 6});
                return false;
            }
            var load = layer.load('2', { shade: 0.2 });
            $.ajax({
                type:'POST',
                url:'Ajax.php',
                data: {
                    ip:ip,
                    start_port:start_port,
                    end_port:end_port,
                    timeout_ms:timeout_ms,
                },
                dataType:'json',
                success:function (data){
                    layer.close(load);
                    var content = '';
                    $.each(data, function(index, item) {
                        content += '<div style="text-align: center"><span class="btn btn-xs btn-success">端口：' + item.port + '</span>&nbsp;&nbsp;<span class="btn btn-xs btn-danger"> 状态：' + item.status + '</span><br></div>';
                    });
                    layer.open({
                        type: 1,
                        title: '端口扫描结果',
                        shadeClose: true,
                        shade: 0.5,
                        area: ['90%', '90%'],
                        content: content
                    });
                }
            });
        });
    </script>
</body>
</html>