<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
<form action="process.php" enctype="multipart/form-data" method="post">
    <input type="file" id="file" name="file" multiple="multiple" accept="image/*"><br/>
    <input type="submit" value="提交">
    <a href="###" id="upload">上传</a>
    <h2 id="output"></h2>
</form>

<div id="status"></div>

<script>
    var page = {
        init:function(){
            $("#upload").click($.proxy(this.upload,this));
        },
        upload:function(){
            var file = $("#file")[0].files[0],
                name = file.name,
                size = file.size,
                succeed = 0;
            var shardSize = 2*1024*1024, //2MB为一个分片
                shardCount = Math.ceil(size/shardSize);//总分片数

            for(var i = 0;i < shardCount;i++){
                var start = i* shardSize,
                    end = Math.min(size,start+shardSize);
                var form = new FormData();
                var blob = file.slice(start,end);
                var render = new FileReader();
                console.log(file);
                console.log(start+'___'+end);
                console.log(blob);
                console.log(render.readAsBinaryString(blob));
                form.append('data',blob);
                form.append('name',name);
                form.append('total',shardCount);
                form.append('index',i+1); //显示当前上传的是第几片

                $.ajax({
                    url:"process.php",
                    type:"POST",
                    data:form,
                    async:true,
                    processData: false,  //很重要，告诉jquery不要对form进行处理
                    contentType: false,  //很重要，指定为false才能形成正确的Content-Type
                    success:function(data){
                        ++succeed;
                        $("#output").text(succeed + " / " + shardCount);
                        $("#output").append(data);
                    }
                });
            }
        }
    };

    $(function(){
        page.init();
    });
</script>
</body>
</html>