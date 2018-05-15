<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<title>mymusic register</title>
    <?php $register_url = 'http://localhost/music/MVC/index.php?a=register'; ?>
</head>

<body>

 <?php
 if(isset($data['error_msg'])){
    //echo "<p class = 'error'>".$data['error_msg']."</p>";
    echo "<script>alert('".$data['error_msg']."');</script>";
 }
 ?>
<form method="post" action="<?php echo $register_url?>" >
    <span>用户名:</span><input type="text" name="username"
    value="<?php if (!empty($data['username'])) echo $data['username'];?>"/><br />
    <span>密  码:</span><input type="password" name="password"/><br />
    <span>再次输入密码:</span><input type="password" name="repeat"/><br />
    <span>邮  箱:</span><input type="email" name="mail"/><br />
    <input type="submit" name="submit" value="注册"/>
</form>


</body>
</html>