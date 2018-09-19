<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lotto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-7">
                <a role="button" class="btn btn-primary" href="<?php echo base_url('lotto/random'); ?>">ดำเนินการสุ่มรางวัล</a>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>ประเภทรางวัล</th>
                            <th>หมายเลข</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($lottos as $lotto): ?>
                        <tr>
                            <td><?php echo $lotto['type']; ?></td>                            
                            <td><?php echo $lotto['lotto']; ?></td>                            
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-5">
            <div class="jumbotron">
                <h3 class="success">ตรวจสลากรางวัล</h3>
                <form id="search-lotto" class="form-inline" action="<?php echo base_url('lotto/search'); ?>">
                    <input type="text" class="form-control mb-2 mr-sm-2" name="lotto" placeholder="ใส่เลขของคุณ...">                                       
                    <button type="button" class="btn btn-primary mb-2 btn-submit">ตรวจรางวัล</button>
                </form>
            </div>     
            <div id="message"></div>           
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>        
        $(function () {
            var checkLot = function (){
                $.ajax({
                    type: 'get',
                    url: $('#search-lotto').attr('action'),
                    data: {
                        lotto: $('input[name=lotto]').val()
                    },
                    success: function (response) {                        
                        var json = JSON.parse(response);
                        var inMessage = '';
                        if(json.length > 0){
                           
                            inMessage += '<div class="alert alert-primary" role="alert">ดีใจด้วย... คุณถูกรางวัล';
                            json.forEach(function(value){
                                inMessage += '<br/> - ' + value.type;
                            });
                            inMessage += '</div>';                                                   
                        } else {
                            inMessage = '<div class="alert alert-danger" role="alert">เสียใจด้วย! คุณไม่ถูกรางวัล</div>';
                        }
                        $('#message').html(inMessage);
                    }
                });
            }

            $('.btn-submit').on('click', function(){
                checkLot();
            });
            $('input[name=lotto]').on('keypress', function(e){
                if(e.keyCode === 13) {
                    e.preventDefault();
                    checkLot();
                }
            });
        });
    </script>
</body>

</html>