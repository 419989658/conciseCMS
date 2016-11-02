/**
 * Created by lq884 on 2016/10/19.
 */
// 文件上传
jQuery(function() {
    var $ = jQuery,
        $list = $('#thelist'),
        $btn = $('#ctlBtn1'),
        $btns = $('.btns'),
        state = 'pending',
        uploader,
        fileMd5
        ;
    //注册断点上传和秒传文件的处理函数
    WebUploader.Uploader.register({
            'before-send' : 'beforeSend'         //断点续传
        },
        {
            beforeSend:function(block){
                console.log(block);
                var task = new $.Deferred();
                $.ajax({
                    type:"POST",
                    url:CHECK_CHUNK_SERVICE,
                    data:{
                        status:"checkChunk"
                        ,hashMD5: fileMd5
                        , chunkIndex: block.chunk
                        , chunks:block.chunks
                        , size: block.end - block.start
                        , type:block.file.ext
                    }
                    ,cache:false
                    ,timeout:5000 //超时就认为该分片没有上传过
                    ,dataType:"json"
                }).then(function(data ,textStatus, jqXHR){
                    if(data.ifExist){   //若存在，返回失败给WebUploader，表明该分块不需要上传
                        task.reject();
                    }else{
                        task.resolve();
                    }
                },function(jqXHR, textStatus, errorThrown){    //任何形式的验证失败，都触发重新上传
                    task.resolve();
                });
                return $.when(task);
            }
        });
    uploader = WebUploader.create({
        // swf文件路径
        swf: '/js/Uploader.swf',

        chunked:true,
        chunkSize:1024*1024,
        prepareNextFile: true,
        // 文件接收服务端。
        server:UPLOAD_SERVICE,

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: {
            id:'#picker',
            label:'添加您要上传的文件',
            multiple:false

        },
        disableGlobalDnd: true,
        fileSizeLimit: 500 * 1024 * 1024,    // 500 M
        fileSingleSizeLimit: 500 * 1024 * 1024    // 500 M
    });
    // 当有文件添加进来的时候,开始计算文件的MD5
    uploader.on( 'fileQueued', function( file ) {
            $list.html("");//清空原有的文件信息
            $btns.fadeOut();
         //   console.log(uploader.Queue);
        console.log();
        $list.append( '<div id="' + file.id + '" class="item">' +
            '<h4 class="info">' + file.name + '</h4>' +
            '<p class="state"></p>' +
            '</div>' );
        var $li = $( '#'+file.id );
        var start =  +new Date();
        this.md5File(file).progress(function(percentage){
            //MD5计算的进度;
            $percent = $li.find('.progress .progress-bar');
            // 避免重复创建
            if ( !$percent.length ) {
                $percent = $('<div class="progress progress-striped active">' +
                    '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                    '</div>' +
                    '</div>').appendTo( $li ).find('.progress-bar');
            }
            $li.find('p.state').text('正在计算文件的MD5值');
            console.log(percentage * 100 + '%');
            $percent.css( 'width', (percentage * 100) + '%' );
        }).then(function(ret){
            //$("#"+file.id).remove();
            //ret为计算后的MD5值
            var end = +new Date();
            $btns.fadeIn();
            console.log(ret);
            console.log(end-start);
            $li.find('p.state').text('文件的MD5值计算完毕,用时:'+((end - start)/1000).toFixed(1) + '秒');
            $( '#'+file.id ).find('.progress').fadeOut();
           // $li.find('.progress .progress-bar').css( 'width', 0+ '%' );
            fileMd5 = ret;
            file.fileMd5 = ret;
            console.log(file);
        });

    });

    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress .progress-bar');
            if($li.find('.progress').css('display') == 'none'){
               $li.find('.progress').fadeIn();
            }

        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<div class="progress progress-striped active">' +
                '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                '</div>' +
                '</div>').appendTo( $li ).find('.progress-bar');
        }

        $li.find('p.state').text('上传中');

        $percent.css( 'width', percentage * 100 + '%' );
    });

    uploader.on( 'uploadSuccess', function( file ,reason) {
        $( '#'+file.id ).find('p.state').text('已上传');
        console.log(file);
        console.log(reason);
    });

    uploader.on( 'uploadError', function( file,reason ) {
        $( '#'+file.id ).find('p.state').text('上传出错');
        console.log(file);
        console.log(reason);
    });

    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').fadeOut();
    });

    uploader.on('stopUpload',function(file){
        uploader.stop(true);
    });

    uploader.on( 'all', function( type ) {
        if ( type === 'startUpload' ) {
            state = 'uploading';
        } else if ( type === 'stopUpload' ) {
            state = 'paused';
        } else if ( type === 'uploadFinished' ) {
            state = 'done';
        }

        if ( state === 'uploading' ) {
            $btn.text('暂停上传');
        } else {
            $btn.text('开始上传');
        }
    });
    /**
     * 上传之前的处理
     */
   uploader.on('uploadBeforeSend',function(object ,data ,headers ){
        //data.fileMd5 = fileMd5;
       data.hashMD5 =  fileMd5;
       data.status = 'upload';
    });

    $btn.on( 'click', function() {
        if ( state === 'uploading' ) {
            uploader.stop(true);
        } else {
            uploader.upload();
        }
    });

});