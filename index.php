<?php
function main_handler($event, $context) {
    echo 'event:'.json_encode($event, JSON_PRETTY_PRINT).'
    context:'.json_encode($context, JSON_PRETTY_PRINT);

    // echo $event->{'headers'}->{'host'} ; // parameter is object. 传入的参数是object

    // convert parameters to array
    // 转换为数组
    $event = json_decode(json_encode($event), true);
    $context = json_decode(json_encode($context), true);

    // good choice to clean variables
    // SCF中使用全局的变量前最好清空
    unset($_GET);
    unset($_POST);

    // get the path in url
    // 取得链接中非域名部分的path值
    $function_name = $context['function_name'];
    $host_name = $event['headers']['host'];
    $serviceId = $event['requestContext']['serviceId'];
    if ( $serviceId === substr($host_name,0,strlen($serviceId)) ) {
        // using long url of API gateway
        // 使用API网关长链接时
        $path = substr($event['path'], strlen('/' . $function_name . '/')); 
    } else {
        // using custom domain
        // 使用自定义域名时
        $path = substr($event['path'], strlen($event['requestContext']['path']=='/'?'/':$event['requestContext']['path'].'/')); 
    }

    // get the queryString
    // 取得链接后?queryString提交的值
    $_GET = $event['queryString'];

    // get the POST values
    // 取得表格POST提交的值
    $_POSTbody = explode("&",$event['body']);
    foreach ($_POSTbody as $postvalues){
        $pos = strpos($postvalues,"=");
        $_POST[urldecode(substr($postvalues,0,$pos))]=urldecode(substr($postvalues,$pos+1));
    }
    $value = $_POST['key'];
	if ($value=='') $value = $path;
	

    $bvid = $_GET["bvid"];
    $sessdata = $_GET["sessdata"];
    $bili_jct = $_GET["bili_jct"];
    // start the web html
    // 网页开始
    @ob_start();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<title>封面上传 - 哔哩哔哩弹幕视频网 - ( ゜- ゜)つロ 乾杯~</title>
	<link rel="shortcut icon" href="https://static.hdslb.com/images/favicon.ico">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="referrer" content="no-referrer"/>
	<style type="text/css">
:root{--theme-color:#1F2323;--title-color:#051b35;--text-color:#333333;}html{scroll-behavior:smooth;}body,html{margin:0;padding:0;color:#585858;}*{box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;}.wrapper{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;}@media (min-width:576px){.wrapper{max-width:540px;}}@media (min-width:768px){.wrapper{max-width:720px;}}@media (min-width:992px){.wrapper{max-width:960px;}}@media (min-width:1200px){.wrapper{max-width:1140px;}}.d-grid{display:grid;}.d-flex{display:flex;display:-webkit-flex;flex-wrap:wrap;}.text-center{text-align:center;}.text-left{text-align:left;}.text-right{text-align:right;}button,input,select{-webkit-appearance:none;outline:none;}button,.btn,select{cursor:pointer;}a{text-decoration:none;}h1,h2,h3,h4,h5,h6,p,ul,ol{margin:0;padding:0;}.theme-button{min-width:130px;cursor:pointer;text-decoration:none;-webkit-appearance:none;display:inline-block;font-style:normal;font-weight:normal;font-size:15px;text-align:center;color:#fff;background:var(--theme-color);padding:14px 18px;border-radius:4px;transition:0.3s ease;border:1px solid var(--theme-color);}.theme-button:hover{background:#ffffff;color:#000000;}.form-36-mian{background-size:cover;background-image:linear-gradient(to right,rgba(0,0,0,0.85),rgba(255,255,255,0)),url(https://i0.hdslb.com/bfs/album/62ba415d1485ffafcda27c5f6e8325dfbe2f5a7b.jpg);background-attachment:fixed;min-height:100vh;display:grid;align-items:center;padding:2rem 0;}.form-inner-cont{max-width:370px;margin-right:auto;background:#fff;padding:2rem;border-radius:4px;}.form-inner-cont h3{font-size:25px;line-height:30px;color:var(--title-color);}.form-input input[type="text"],.form-input input[type="email"],.form-input input[type="password"]{background:transparent;border:none;outline:none;width:100%;font-size:16px;padding:0px 12px 0px 0px;color:var(--title-color);height:45px;-webkit-appearance:none;}.form-input{margin-top:20px;background:rgba(31,35,35,0.03);display:grid;grid-template-columns:.1fr 1fr;align-items:center;border:1px solid rgba(31,94,180,0.22);border-radius:4px;}.login-remember{grid-template-columns:auto auto;justify-content:space-between;align-items:center;margin-top:2rem;}.checkbox{width:16px;height:16px;color:#F5F9FC;background:#304659;float:left;}p.remember{font-size:13px;line-height:18px;color:var(--text-color);}.new-signup a{font-size:14px;margin-top:25px;display:block;color:#ff0000;text-decoration:underline;}.social-icons{align-items:center;border-top:1px solid #eee;border-bottom:1px solid #eee;padding:30px 0px 20px;margin-top:40px;position:relative;}.continue{text-align:center;display:inline-block;width:14%;position:absolute;top:-20px;left:43%;}.continue span{font-style:normal;font-weight:bold;font-size:13px;background:#f7f7f7;color:var(--title-color);text-align:center;display:inline-block;width:40px;border-radius:50%;height:40px;line-height:40px;}button.btn{line-height:40px;padding:0;min-width:100px;}p.signup{color:var(--text-color);font-size:15px;line-height:25px;display:block;margin-top:20px;}p.signup a{font-weight:bold;color:var(--theme-color);}p.signup a:hover{text-decoration:underline;}.social-login{display:flex;justify-content:center;}.check-remaind{display:block;position:relative;padding-left:25px;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;}.check-remaind input{position:absolute;opacity:0;cursor:pointer;height:0;width:0;}.checkmark{position:absolute;top:0px;left:0;height:17px;width:17px;background-color:#E1E9F0;}.check-remaind:hover input~.checkmark{background-color:#E1E9F0;}.check-remaind input:checked~.checkmark{background-color:var(--theme-color);}.checkmark:after{content:"";position:absolute;display:none;}.check-remaind input:checked~.checkmark:after{display:block;}.check-remaind .checkmark:after{left:5px;top:2px;width:4px;height:9px;border:solid white;border-width:0 2px 2px 0;-webkit-transform:rotate(45deg);-ms-transform:rotate(45deg);transform:rotate(45deg);}@media(max-width:414px){.social-icons{margin-top:30px;}}
</style>


</head>
<body>
	<div style="right:15%;bottom:100px;background: #FB7299;color:#ffffff;overflow: hidden;z-index: 9999;position: fixed;padding:5px;text-align:center;width: 30%;height: 80%;border-radius:2px;">
		<iframe height="100%" width="100%" src="//cover_doc.deginx.com" name="in" frameborder="0"></iframe>
	</div>
	<section class="w3l-form-36">
		<div class="form-36-mian section-gap">
			<div class="wrapper">
				<div class="form-inner-cont" id="form_div">
					<h3>封面上传</h3>
					</h3>
					<div class="form-input">
						<span aria-hidden="true"></span> <input onkeyup="update_url();" value="<?php echo $bvid; ?>" id="bvid" type="text" name="bvid" placeholder="BVID" required />
					</div>
					<div class="form-input">
						<span aria-hidden="true"></span> <input onkeyup="update_url();" type="password" value="<?php echo $sessdata; ?>" id="sessdata" name="sessdata" placeholder="SESSDATA" required />
					</div>
					<div class="form-input">
						<span aria-hidden="true"></span> <input onkeyup="update_url();" type="password" value="<?php echo $bili_jct; ?>" id="bili_jct" name="bili_jct" placeholder="bili_jct" required />
					</div>
					<br>
					<a>请上传图片(webp,jpeg,png类型，分辨率最好为960*600,文件大小5m以内):</a>
					<div class="form-input">
						<span></span> <input onchange="imgChange(this)" type="file" name="img" accept="image/webp,image/jpeg, image/jpg, image/png" required />
					</div>
					<!--<div class="form-input">
						<span aria-hidden="true"></span> <textarea style="border: none; resize: none;cursor: pointer;" rows="10" type="text" value="" id="img_base64" name="img_base64" placeholder="图片BASE64编码" required></textarea>
					</div>-->
					<br>
					<div class="d-grid">
						<button onclick="update()" class="btn theme-button">上传</button>
					</div>
					<p class="signup">不知道怎么用? <a href="https://space.bilibili.com/96876893" class="signuplink">去问UP</a></a></p>
					<br>
					<p class="signup">友情链接 <a href="https://space.bilibili.com/75940481" class="signuplink">林子MU</a></a></p>
				</div>
			</div>
		</div>
	</section>
	<script type="text/javascript">
	var dataURL;
	var Server_url="https://service-5lnsujvl-1304975305.sh.apigw.tencentcs.com/release/Bibili_Cover_Upload_Server";
		function imgChange(obj) {
			var image = obj.files[0];
			var size = image.size / 1024;    
      if(size>4500){  
		Server_url='http://bibili_cover_upload_server.deginx.com/';}else{Server_url="https://service-5lnsujvl-1304975305.sh.apigw.tencentcs.com/release/Bibili_Cover_Upload_Server";};
			var reader = new FileReader();
			reader.readAsDataURL(image);
			reader.onload = function(ev) {
				dataURL = ev.target.result;
				//document.getElementById("img_base64").value = dataURL;
			}
			//console.log(image);
		}
	</script>
<?php  $key=crypt(md5(date("Y-m-d H")),md5("chenrui_bilibili_nmsl"))?>
	<script type="text/javascript">
		function update_url() {
			history.pushState({}, {}, '?&bvid=' + document.getElementById("bvid").value + '&sessdata=' + document.getElementById("sessdata").value + "&bili_jct=" + document.getElementById("bili_jct").value);
		}
		function update() {
			var data = "img_base64="+encodeURIComponent(dataURL);
			var xhr = new XMLHttpRequest();
			xhr.withCredentials = false;

			xhr.addEventListener("readystatechange", function() {
				if (this.readyState === 4) {
					//console.log(this.responseText);
					alert(JSON.stringify(JSON.parse(this.responseText), null, 4));
					location.reload();
				}
			});
			xhr.open("POST", Server_url + '?key=<?php echo $key?>&bvid=' + document.getElementById("bvid").value + '&sessdata=' + document.getElementById("sessdata").value + "&bili_jct=" + document.getElementById("bili_jct").value);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send(data);
		}
	</script>

</body>
</html>



<?php
    // end the web html
    // 网页结束
    $html=ob_get_clean();

    $value="";
    unlink($last);

    // return the web html
    // 返回html网页
    return [
        'isBase64Encoded' => false,
        'statusCode' => 200,
        'headers' => [ 'Content-Type' => 'text/html' ],
        'body' => $html
    ];
}
