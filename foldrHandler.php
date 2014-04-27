<?php $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
$key = 'alongkey16bytes!along16byteskey!';

$username = $_GET['username'];
$password = $_GET['auth'];
$flink = $_GET['flink'];

$parsed = rawurldecode($password);

$base64encoded_ciphertext = $parsed;

$plainPass = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($base64encoded_ciphertext), MCRYPT_MODE_ECB);

$str = iconv(mb_detect_encoding($plainPass, mb_detect_order(), true), "UTF-8", $username);
$str2 = iconv(mb_detect_encoding($plainPass, mb_detect_order(), true), "UTF-8", $plainPass);

//This block strips unknown hex chars
$str = preg_replace('/[\x00-\x09\x0B-\x1F\x0A\x0D]/', '', $str);
str_replace(array("\n", "\r"), array('\n', '\r'), $str); 
$str2 = preg_replace('/[\x00-\x09\x0B-\x1F\x0A\x0D]/', '', $str2);
str_replace(array("\n", "\r"), array('\n', '\r'), $str2); 

?>

<html>
<head>
<title>Foldr Resource</title>
</head>
<body bgcolor="black">
<form action="https://foldr.minnow.it/flinks/<?php echo $flink;?>/download" name="downloader" method="post">
<input type="hidden" name="_auth_username" value="<?php echo $str;?>" />
<input type="hidden" name="_auth_password" value="<?php echo $str2;?>" />
</form>
<center><h1 style="color:white;"></br></br>Loading...</h1></center>
<script type="text/javascript">
document.forms.downloader.submit();
</script>
</body>
</html>
