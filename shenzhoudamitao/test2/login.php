<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include("conn.php"); //包含数据库连接文件
  $username = $_POST['username']; //获取用户输入的用户名
  $passwd = md5($_POST['passwd']); //获取用户输入的密码
  $sql=mysqli_query($conn,"select * from tb_user where name='".$username."' or dianhua='".$username."' or email='".$username."'"); 
  $info = mysqli_fetch_array($sql); //将查询结果返回到数组中
  if ($info == false) { //如果查询结果为空
    echo "<script language='javascript'>alert('不存在会员账户！');history.back();</script>"; //弹出提示信息
  } else {
    if ($info['pwd'] == $passwd) { //如果用户密码输入正确
      session_start(); //启动session
      $_SESSION['username'] = $info['name']; //将登录用户名存储在session变量中
      if (isset($_SESSION['userurl'])) {  //可以返回到要求登录的页面或首页
        $url = $_SESSION['userurl'];
      } else {
        $url = "index.html";
      }
      echo "<meta http-equiv=\"refresh\" content=\"1.0;url=$url\">"; //1s后跳转
    } else {
      echo "<script language='javascript'>alert('密码输入错误！');history.back();</script>"; //弹出提示信息
    }
  }
}
?>
<BODY text=#000000 bgColor=#ffffff leftMargin=0 topMargin=0>
  <TABLE cellSpacing=0 cellPadding=0 width=760 border=0 align="center">
    <TBODY>
      <TR>
        <TD align=middle height=30>
          <FONT color=#000000 size=4><B>会员登录</B></FONT>
        </TD>
      </TR>
    </TBODY>
  </TABLE>
  <FORM action="#" method="post" onSubmit="return checkLogin()">
    <TABLE width=300 align="center" border=0>
      <TR>
        <TD vAlign=top align="left" width=50>账　号：</TD>
        <TD><input type="text" name="username" id="username" placeholder="请输账号/手机号/邮箱" data-required="required" autocomplete="off"></TD>
      </TR>
      <TR>
        <TD align="left" width=50>密　码：</TD>
        <TD><input type="password" name="passwd" id="passwd" placeholder="请输入密码" data-required="required" autocomplete="off"></TD>
      </TR>
      <TR>
        <TD colSpan=2 height=21><BR>
          <DIV align=center>
            <input type="submit" value="登&nbsp;&nbsp;&nbsp;&nbsp;录">
            <input type="button" onClick="javascript:window.location.href='register.php'" value="立即注册" >
          </DIV>
        </TD>
      </TR>
    </TABLE>
  </FORM>
</BODY>

<script>
  function checkLogin() {	 
    if (document.getElementById("username").value.trim() == "") {
      alert("必须输入账号名称！");
      return false;
    }
    if (/^[\u4e00-\u9fa5]+$/.test(document.getElementById("username").value)) {
      alert("账号不能输入汉字！");
      return false;
    }
    if (document.getElementById("passwd").value.length < 6) {
      alert("密码不能少于6位！");
      return false;
    }
    return true;
  }
</script>
</body>
</html>