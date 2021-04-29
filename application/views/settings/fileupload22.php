<?php $this->load->view('header');?>
<!-- Set 
render engine for 360 
browser -->
<meta name="renderer" content="webkit">
<!-- No 
Baidu Siteapp-->
<meta http-equiv="Cache- Control" content="no-siteapp"/>
<!-- Add 
to homescreen for 
Chrome on Android -->
<meta name="mobile-web-app-capable" content="yes">
<!-- Add 
to homescreen for 
Safari on iOS -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>statics/lib/webuploader/css/webuploader.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>statics/lib/webuploader/css/style.css"/>

<script type="text/javascript">
var DOMAIN = document.domain;
var WDURL = "";
var SCHEME= "<?php echo sys_skin()?>";
try{
	document.domain = '<?php echo base_url()?>';
}catch(e){
}
</script>

<style>
.container{position:relative;}
#progress{position: absolute;top:0;left:0;width:100%}
.uploading #progress{z-index:1001;}
.content{padding: 10px;width: 730px;
margin: 0 auto;}
.content li{float: left;width: 20%;}
.content li img{padding:2px;width: 97%;cursor: pointer;}
.content .hover img{border:2px solid rgb(0, 235, 255);padding:0;}
.bar {height:30px;background:#5EC29A;}
.img-warp{
height:444px;
overflow-y:auto;
}
.fileinput-button{
overflow: hidden;
position: fixed;
bottom: 0;
background: #BBB;
color: #ffffff;
display: inline-block;
padding: 4px 0;
margin-bottom: 0;
font-size: 14px;
height: 22px;
line-height: 22px;
text-align: center;
vertical-align: middle;
cursor: pointer;
font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
width:100%;
}
.fileinput-button i{display: inline-block;
vertical-align: middle;
margin: 4px;
height: 16px;
width: 16px;
line-height: 14px;
z-index: 999;
position: relative;
}
.fileinput-button p{
position: absolute;
left: 0;
top: 0;
width:100%;
z-index: 999;
font-size: 16px;
line-height:30px;
}
.fileinput-button.uploading p{z-index: 1002;}
.fileinput-button input{cursor: pointer;
direction: ltr;
font-size: 1000px;
margin: 0;
opacity: 0;
filter: alpha(opacity=0);
position: absolute;
right: 0;
top: 0;
height: 30px;
line-height: 30px;
width: auto;
vertical-align: middle;
z-index: 1000;
}
.imgDiv{
position: relative;
}
.imgDiv .imgControl{
display:none;
width: 100%;
}
.imgDiv.hover .imgControl{
display:block;
position: absolute;
top: 0;
}
.imgDiv.hover .imgControl .del{background: rgb(0, 235, 255);
font-size: 14px;
padding: 0 6px;
position: absolute;
top: 2px;
color: #fff;
right: 2px;
cursor: pointer;
}
.icon-plus{
background: url(<?php echo base_url()?>statics/css/img/ui-icons.png) -210px -17px;
}
</style>
</head>
<body>
<!--<div id="wrapper">
	<div id="container">
		<div id="uploader">
			<div class="queueList" >
				<div id="dndArea" class="placeholder">
					<div id="filePicker">
					</div>
					<p>
						或將照片拖到這裡，單次最多可選300張
					</p>
				</div>
				 
			</div>
			<div class="statusBar" style="display:none;">
				<div class="progress">
					<span class="text">0%</span>
					<span class="percentage"></span>
				</div>
				<div class="info"></div>
				<div class="btns">
					<div id="filePicker2"></div>
					<div class="uploadBtn">
						開始上傳
					</div>
				</div>
			</div>
		</div>
	</div>
</div>-->






<div id="wrapper">
	<div id="container">
		<div id="uploader">
			<div class="queueList">
				<div id="dndArea" class="placeholder element-invisible">
					<div id="filePicker" class="webuploader-container">
						<div class="webuploader-pick">
							點選選擇圖片
						</div>
						<div id="rt_rt_19nlgvkeicf41srs13ql1n8r16sg1" style="position: absolute; top: 20px; left: 75px; width: 168px; height: 44px; overflow: hidden; bottom: auto; right: auto;">
							<input class="webuploader-element-invisible" type="file" name="file" accept="image/*">
							<label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255) none repeat scroll 0% 0%;"></label>
						</div>
					</div>
					<p>
						 或將照片拖到這裡，單次最多可選300張
					</p>
				</div>
				<ul class="filelist">
				    <li id="WU_FILE_0">
						<p class="title"></p>
						<p class="imgWrap">
						<img src="<?php echo base_url()?>data/upfile/goods/7/201506131318121029.png"> 
						<p class="progress">
							<span></span>
						</p>
						<div class="file-panel" style="height: 0px;">
							<span class="cancel">刪除</span>
							<span class="rotateRight">向右旋轉</span>
							<span class="rotateLeft">向左旋轉</span>
						</div>
					</li> 
				</ul>
			</div>
			<div class="statusBar" style="">
				<div class="progress" style="display: none;">
					<span class="text">100%</span>
					<span class="percentage" style="width: 100%;"></span>
				</div>
				<div class="info">
					共1張（40.87K），已上傳1張
				</div>
				<div class="btns">
					<div id="filePicker2" class="webuploader-container">
						<div class="webuploader-pick">
							繼續新增
						</div>
						<div id="rt_rt_19nlgvkjs1lpv13qh1fkd1ie53rc6" style="position: absolute; top: 0px; left: 10px; width: 94px; height: 42px; overflow: hidden; bottom: auto; right: auto;">
							<input class="webuploader-element-invisible" type="file" name="file" multiple="multiple" accept="image/*">
							<label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255) none repeat scroll 0% 0%;"></label>
						</div>
					</div>
					<div class="uploadBtn state-finish">
						開始上傳
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript" src="<?php echo base_url()?>statics/lib/webuploader/js/jquery.js?ver=20150320"></script>
<script type="text/javascript" src="<?php echo base_url()?>statics/lib/webuploader/js/base.js?ver=20150320"></script>
<!--<script type="text/javascript" src="<?php echo base_url()?>statics/lib/webuploader/js/upload.js?ver=20150320"></script>-->
<script src="<?php echo base_url()?>statics/js/common/plugins/fileupload/js/vendor/jquery.ui.widget.js?ver=20150320"></script>
<script src="<?php echo base_url()?>statics/js/common/plugins/fileupload/js/jquery.iframe-transport.js?ver=20150320"></script>
<script>
(function( $ ){

    // 當domReady的時候開始初始化
    $(function() {
	    var a = {
				fileList: {},
				api: frameElement.api,
				page: {
					$container: $(".container"),
					$upfile: $("#upfile"),
					$content: $(".content"),
					$progress: $("#progress"),
					$fileinputButton: $("#fileinput-button"),
					uploadLock: !1
		}};
	
	
        var $wrap = $('#uploader'),

            // 圖片容器
            $queue = $( '<ul class="filelist"></ul>' )
                .appendTo( $wrap.find( '.queueList' ) ),

            // 狀態列，包括進度和控制按鈕
            $statusBar = $wrap.find( '.statusBar' ),

            // 檔案總體選擇資訊。
            $info = $statusBar.find( '.info' ),

            // 上傳按鈕
            $upload = $wrap.find( '.uploadBtn' ),

            // 沒選擇檔案之前的內容。
            $placeHolder = $wrap.find( '.placeholder' ),

            $progress = $statusBar.find( '.progress' ).hide(),

            // 新增的檔案數量
            fileCount = 0,

            // 新增的檔案總大小
            fileSize = 0,

            // 優化retina, 在retina下這個值是2
            ratio = window.devicePixelRatio || 1,

            // 縮圖大小
            thumbnailWidth = 110 * ratio,
            thumbnailHeight = 110 * ratio,

            // 可能有pedding, ready, uploading, confirm, done.
            state = 'pedding',

            // 所有檔案的進度資訊，key為file id
            percentages = {},
            // 判斷瀏覽器是否支援圖片的base64
            isSupportBase64 = ( function() {
                var data = new Image();
                var support = true;
                data.onload = data.onerror = function() {
                    if( this.width != 1 || this.height != 1 ) {
                        support = false;
                    }
                }
                data.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
                return support;
            } )(),

            // 檢測是否已經安裝flash，檢測flash的版本
            flashVersion = ( function() {
                var version;

                try {
                    version = navigator.plugins[ 'Shockwave Flash' ];
                    version = version.description;
                } catch ( ex ) {
                    try {
                        version = new ActiveXObject('ShockwaveFlash.ShockwaveFlash')
                                .GetVariable('$version');
                    } catch ( ex2 ) {
                        version = '0.0';
                    }
                }
                version = version.match( /\d+/g );
                return parseFloat( version[ 0 ] + '.' + version[ 1 ], 10 );
            } )(),

            supportTransition = (function(){
                var s = document.createElement('p').style,
                    r = 'transition' in s ||
                            'WebkitTransition' in s ||
                            'MozTransition' in s ||
                            'msTransition' in s ||
                            'OTransition' in s;
                s = null;
                return r;
            })(),

            // 實例
            uploader;

        if ( !WebUploader.Uploader.support('flash') && WebUploader.browser.ie ) {

            // flash 安裝了但是版本過低。
            if (flashVersion) {
                (function(container) {
                    window['expressinstallcallback'] = function( state ) {
                        switch(state) {
                            case 'Download.Cancelled':
                                alert('您取消了更新！')
                                break;

                            case 'Download.Failed':
                                alert('安裝失敗')
                                break;

                            default:
                                alert('安裝已成功，請重新整理！');
                                break;
                        }
                        delete window['expressinstallcallback'];
                    };

                    var swf = './expressInstall.swf';
                    // insert flash object
                    var html = '<object type="application/' +
                            'x-shockwave-flash" data="' +  swf + '" ';

                    if (WebUploader.browser.ie) {
                        html += 'classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ';
                    }

                    html += 'width="100%" height="100%" style="outline:0">'  +
                        '<param name="movie" value="' + swf + '" />' +
                        '<param name="wmode" value="transparent" />' +
                        '<param name="allowscriptaccess" value="always" />' +
                    '</object>';

                    container.html(html);

                })($wrap);

            // 壓根就沒有安轉。
            } else {
                $wrap.html('<a href="http://www.adobe.com/go/getflashplayer" target="_blank" border="0"><img alt="get flash player" src="http://www.adobe.com/macromedia/style_guide/images/160x41_Get_Flash_Player.jpg" /></a>');
            }

            return;
        } else if (!WebUploader.Uploader.support()) {
            alert( '系統不支援您的瀏覽器！');
            return;
        }

        // 實例化
		var b = a.api.data || {};
        uploader = WebUploader.create({
            pick: {
                id: '#filePicker',
                label: '點選選擇圖片',
				multiple:false
            },
            formData: {
                uid: 123
            },
            dnd: '#dndArea',
            paste: '#uploader',
            swf: './Uploader.swf',
            chunked: false,
            chunkSize: 512 * 1024,
            server: '../basedata/inventory/uploadimages?invid='+b.id,
            // runtimeOrder: 'flash',

             accept: {
                title: 'Images',
                 extensions: 'gif,jpg,jpeg,bmp,png',
                 mimeTypes: 'image/*'
             },
			 sendAsBinary:true,
             compress:false,
            // 禁掉全域性的拖拽功能。這樣不會出現圖片拖進頁面的時候，把圖片打開。
            disableGlobalDnd: true,
            fileNumLimit: 300,
            fileSizeLimit: 200 * 1024 * 1024,    // 200 M
            fileSingleSizeLimit: 50 * 1024 * 1024    // 50 M
        });

        // 拖拽時不接受 js, txt 檔案。
        uploader.on( 'dndAccept', function( items ) {
            var denied = false,
                len = items.length,
                i = 0,
                // 修改js型別
                unAllowed = 'text/plain;application/javascript ';

            for ( ; i < len; i++ ) {
                // 如果在列表裡面
                if ( ~unAllowed.indexOf( items[ i ].type ) ) {
                    denied = true;
                    break;
                }
            }

            return !denied;
        });

        uploader.on('dialogOpen', function() {
            console.log('here');
        });

        // uploader.on('filesQueued', function() {
        //     uploader.sort(function( a, b ) {
        //         if ( a.name < b.name )
        //           return -1;
        //         if ( a.name > b.name )
        //           return 1;
        //         return 0;
        //     });
        // });

        // 新增「新增檔案」的按鈕，
        uploader.addButton({
            id: '#filePicker2',
            label: '繼續新增'
        });

        uploader.on('ready', function() {
            window.uploader = uploader;
        });

        // 當有檔案新增進來時執行，負責view的建立
        function addFile( file ) {
            var $li = $( '<li id="' + file.id + '">' +
                    '<p class="title">' + file.name + '</p>' +
                    '<p class="imgWrap"></p>'+
                    '<p class="progress"><span></span></p>' +
                    '</li>' ),

                $btns = $('<div class="file-panel">' +
                    '<span class="cancel">刪除</span>' +
                    '<span class="rotateRight">向右旋轉</span>' +
                    '<span class="rotateLeft">向左旋轉</span></div>').appendTo( $li ),
                $prgress = $li.find('p.progress span'),
                $wrap = $li.find( 'p.imgWrap' ),
                $info = $('<p class="error"></p>'),

                showError = function( code ) {
                    switch( code ) {
                        case 'exceed_size':
                            text = '檔案大小超出';
                            break;

                        case 'interrupt':
                            text = '上傳暫停';
                            break;

                        default:
                            text = '上傳失敗，請重試';
                            break;
                    }

                    $info.text( text ).appendTo( $li );
                };

            if ( file.getStatus() === 'invalid' ) {
                showError( file.statusText );
            } else {
                // @todo lazyload
                $wrap.text( '預覽中' );
                uploader.makeThumb( file, function( error, src ) {
                    var img;

                    if ( error ) {
                        $wrap.text( '不能預覽' );
                        return;
                    }

                    if( isSupportBase64 ) {
                        img = $('<img src="'+src+'">');
                        $wrap.empty().append( img );
                    } else {
                        $.ajax('./preview.php', {
                            method: 'POST',
                            data: src,
                            dataType:'json'
                        }).done(function( response ) {
                            if (response.result) {
                                img = $('<img src="'+response.result+'">');
                                $wrap.empty().append( img );
                            } else {
                                $wrap.text("預覽出錯");
                            }
                        });
                    }
                }, thumbnailWidth, thumbnailHeight );

                percentages[ file.id ] = [ file.size, 0 ];
                file.rotation = 0;
            }

            file.on('statuschange', function( cur, prev ) {
                if ( prev === 'progress' ) {
                    $prgress.hide().width(0);
                } else if ( prev === 'queued' ) {
                    $li.off( 'mouseenter mouseleave' );
                    $btns.remove();
                }

                // 成功
                if ( cur === 'error' || cur === 'invalid' ) {
                    console.log( file.statusText );
                    showError( file.statusText );
                    percentages[ file.id ][ 1 ] = 1;
                } else if ( cur === 'interrupt' ) {
                    showError( 'interrupt' );
                } else if ( cur === 'queued' ) {
                    percentages[ file.id ][ 1 ] = 0;
                } else if ( cur === 'progress' ) {
                    $info.remove();
                    $prgress.css('display', 'block');
                } else if ( cur === 'complete' ) {
                    $li.append( '<span class="success"></span>' );
                }

                $li.removeClass( 'state-' + prev ).addClass( 'state-' + cur );
            });

            $li.on( 'mouseenter', function() {
                $btns.stop().animate({height: 30});
            });

            $li.on( 'mouseleave', function() {
                $btns.stop().animate({height: 0});
            });

            $btns.on( 'click', 'span', function() {
                var index = $(this).index(),
                    deg;

                switch ( index ) {
                    case 0:
                        uploader.removeFile( file );
                        return;

                    case 1:
                        file.rotation += 90;
                        break;

                    case 2:
                        file.rotation -= 90;
                        break;
                }

                if ( supportTransition ) {
                    deg = 'rotate(' + file.rotation + 'deg)';
                    $wrap.css({
                        '-webkit-transform': deg,
                        '-mos-transform': deg,
                        '-o-transform': deg,
                        'transform': deg
                    });
                } else {
                    $wrap.css( 'filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation='+ (~~((file.rotation/90)%4 + 4)%4) +')');
                    // use jquery animate to rotation
                    // $({
                    //     rotation: rotation
                    // }).animate({
                    //     rotation: file.rotation
                    // }, {
                    //     easing: 'linear',
                    //     step: function( now ) {
                    //         now = now * Math.PI / 180;

                    //         var cos = Math.cos( now ),
                    //             sin = Math.sin( now );

                    //         $wrap.css( 'filter', "progid:DXImageTransform.Microsoft.Matrix(M11=" + cos + ",M12=" + (-sin) + ",M21=" + sin + ",M22=" + cos + ",SizingMethod='auto expand')");
                    //     }
                    // });
                }


            });

            $li.appendTo( $queue );
        }

        // 負責view的銷燬
        function removeFile( file ) {
            var $li = $('#'+file.id);

            delete percentages[ file.id ];
            updateTotalProgress();
            $li.off().find('.file-panel').off().end().remove();
        }

        function updateTotalProgress() {
            var loaded = 0,
                total = 0,
                spans = $progress.children(),
                percent;

            $.each( percentages, function( k, v ) {
                total += v[ 0 ];
                loaded += v[ 0 ] * v[ 1 ];
            } );

            percent = total ? loaded / total : 0;


            spans.eq( 0 ).text( Math.round( percent * 100 ) + '%' );
            spans.eq( 1 ).css( 'width', Math.round( percent * 100 ) + '%' );
            updateStatus();
        }

        function updateStatus() {
            var text = '', stats;

            if ( state === 'ready' ) {
                text = '選中' + fileCount + '張圖片，共' +
                        WebUploader.formatSize( fileSize ) + '。';
            } else if ( state === 'confirm' ) {
                stats = uploader.getStats();
                if ( stats.uploadFailNum ) {
                    text = '已成功上傳' + stats.successNum+ '張照片至XX相簿，'+
                        stats.uploadFailNum + '張照片上傳失敗，<a class="retry" href="#">重新上傳</a>失敗圖片或<a class="ignore" href="#">忽略</a>'
                }

            } else {
                stats = uploader.getStats();
                text = '共' + fileCount + '張（' +
                        WebUploader.formatSize( fileSize )  +
                        '），已上傳' + stats.successNum + '張';

                if ( stats.uploadFailNum ) {
                    text += '，失敗' + stats.uploadFailNum + '張';
                }
            }

            $info.html( text );
        }

        function setState( val ) {
            var file, stats;

            if ( val === state ) {
                return;
            }

            $upload.removeClass( 'state-' + state );
            $upload.addClass( 'state-' + val );
            state = val;

            switch ( state ) {
                case 'pedding':
                    $placeHolder.removeClass( 'element-invisible' );
                    $queue.hide();
                    $statusBar.addClass( 'element-invisible' );
                    uploader.refresh();
                    break;

                case 'ready':
                    $placeHolder.addClass( 'element-invisible' );
                    $( '#filePicker2' ).removeClass( 'element-invisible');
                    $queue.show();
                    $statusBar.removeClass('element-invisible');
                    uploader.refresh();
                    break;

                case 'uploading':
                    $( '#filePicker2' ).addClass( 'element-invisible' );
                    $progress.show();
                    $upload.text( '暫停上傳' );
                    break;

                case 'paused':
                    $progress.show();
                    $upload.text( '繼續上傳' );
                    break;

                case 'confirm':
                    $progress.hide();
                    $( '#filePicker2' ).removeClass( 'element-invisible' );
                    $upload.text( '開始上傳' );

                    stats = uploader.getStats();
                    if ( stats.successNum && !stats.uploadFailNum ) {
                        setState( 'finish' );
                        return;
                    }
                    break;
                case 'finish':
                    stats = uploader.getStats();
                    if ( stats.successNum ) {
                        alert( '上傳成功' );
                    } else {
                        // 沒有成功的圖片，重設
                        state = 'done';
                        location.reload();
                    }
                    break;
            }

            updateStatus();
        }

        uploader.onUploadProgress = function( file, percentage ) {
            var $li = $('#'+file.id),
                $percent = $li.find('.progress span');

            $percent.css( 'width', percentage * 100 + '%' );
            percentages[ file.id ][ 1 ] = percentage;
            updateTotalProgress();
        };

        uploader.onFileQueued = function( file ) {
            fileCount++;
            fileSize += file.size;

            if ( fileCount === 1 ) {
                $placeHolder.addClass( 'element-invisible' );
                $statusBar.show();
            }

            addFile( file );
            setState( 'ready' );
            updateTotalProgress();
        };

        uploader.onFileDequeued = function( file ) {
            fileCount--;
            fileSize -= file.size;

            if ( !fileCount ) {
                setState( 'pedding' );
            }

            removeFile( file );
            updateTotalProgress();

        };

        uploader.on( 'all', function( type ) {
            var stats;
            switch( type ) {
                case 'uploadFinished':
                    setState( 'confirm' );
                    break;

                case 'startUpload':
                    setState( 'uploading' );
                    break;

                case 'stopUpload':
                    setState( 'paused' );
                    break;

            }
        });

        uploader.onError = function( code ) {
            alert( 'Eroor: ' + code );
        };

        $upload.on('click', function() {
            if ( $(this).hasClass( 'disabled' ) ) {
                return false;
            }

            if ( state === 'ready' ) {
                uploader.upload();
            } else if ( state === 'paused' ) {
                uploader.upload();
            } else if ( state === 'uploading' ) {
                uploader.stop();
            }
        });

        $info.on( 'click', '.retry', function() {
            uploader.retry();
        } );

        $info.on( 'click', '.ignore', function() {
            alert( 'todo' );
        } );

        $upload.addClass( 'state-' + state );
        updateTotalProgress();
		
		
		
		var b = a.api.data || {};
		b.id && Public.ajaxPost("../basedata/inventory/getImagesById", {
					id: b.id
		}, function(b) {
				200 == b.status ? a.addImgDiv(b.files) : parent.parent.Public.tips({
						type: 1,
						content: "獲取商品圖片失敗！"
			})
		})
	
		
    });
	
	

})( jQuery );
</script>
<!--<div class="container">
	
	<div class="img-warp">
		<ul class="content">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
	<div class="btn btn-success fileinput-button bar" id="fileinput-button">
		<div id="progress">
	    	<div class="bar" style="width: 100%;"></div>
		</div>
        <p><i class="icon-plus"></i><span>新增圖片</span></p>
        <input id="upfile" type="file" name="files[]" multiple>
	</div>
</div>-->

<!--<script src="<?php echo base_url()?>statics/js/common/plugins/fileupload/js/jquery.fileupload.js?ver=20150320"></script>-->
<!--<script src="<?php echo base_url()?>statics/js/dist/fileUpload.js?2"></script>-->

</body>
</html>