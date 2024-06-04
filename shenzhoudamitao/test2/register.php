<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  #处理用户注册  
  include("conn.php"); //包含数据库连接文件
  $username = $_POST['username']; //获取会员用户名
  $pwd = md5($_POST['passwd']); //获取密码并对该密码进行MD5加密
  $email = $_POST['email']; //获取email地址
  $dianhua = $_POST['dianhua']; //获取联系电话
  $zhucesj = date("Y-m-d"); //自动生成当前的日期
  $sql = mysqli_query($conn, "select * from tb_user where name='" . $username . "'"); //查询提交的注册会员用户名是否已存在
  $info = mysqli_fetch_array($sql); //将查询结果返回到数组中
  if ($info == true) { //如果用户名已存在，弹出提示信息
    echo "<script>alert('该账号已经存在!');history.back();</script>";
    exit; //退出程序
  }
  $sql = mysqli_query($conn, "select * from tb_user where dianhua='" . $dianhua . "'"); //查询提交的电话号码是否已存在
  $info = mysqli_fetch_array($sql);
  if ($info == true) { //如果电话号已存在，弹出提示信息
    echo "<script>alert('该电话号码已经存在!');history.back();</script>";
    exit; //退出程序
  }
  $sql = mysqli_query($conn, "select * from tb_user where email='" . $email . "'"); //查询提交的电子邮箱是否已存在
  $info = mysqli_fetch_array($sql);
  if ($info == true) { //如果邮箱已存在，弹出提示信息
    echo "<script>alert('该电子邮箱已经存在!');history.back();</script>";
    exit; //退出程序
  }
  //如果用户名、联系电话或电子邮箱在会员信息表中均不存在，则将提交的会员信息插入到用户表中以完成注册
  mysqli_query($conn, "insert into tb_user (name,pwd,email,dianhua,zhucesj) values ('$username','$pwd','$email','$dianhua','$zhucesj')");
  echo "<script>alert('注册成功!');window.location='index.html';</script>"; //弹出提示信息并转到首页访问
}
?>
<BODY text=#000000 bgColor=#ffffff leftMargin=0 topMargin=0>
  <TABLE cellSpacing=0 cellPadding=0 width="90%" align=center border=0>
    <TBODY>
      <TR>
        <TD align=middle height=40><BR>
          <BR>
          <FONT color=#000000 size=4><B>会员注册</B></FONT>
        </TD>
      </TR>
      <TR>
        <TD vAlign=top align=middle height=340>
          <FORM  method="post" onSubmit="return checkRegister();">
            <TABLE cellSpacing=0 cellPadding=0 width=710 align=center border=0>
              <TBODY>
                <TR>
                  <TD colSpan=2 height=20>&nbsp;</TD>
                </TR>
                <TR>
                  <TD colSpan=2 height=21>&nbsp;&nbsp;请您填写以下表格进行注册。</TD>
                </TR>
                <TR>
                  <TD width=110 bgColor=#eff8e7 height=21>
                    <DIV align=center>账 号 名：</DIV>
                  </TD>
                  <TD width=600 bgColor=#eff8e7 height=21><input type="text" name="username" id="username" size="40" placeholder="请输入账号名，账号名不接受中文" data-required="required" autocomplete="off">
                <TR>
                  <TD width=110 bgColor=#eff8e7 height=21>
                    <DIV align=center>密　　码：</DIV>
                  </TD>
                  <TD width=400 bgColor=#eff8e7 height=21><input type="password" name="passwd" id="passwd" size="30" placeholder="请输入密码，密码不能少于6位" data-required="required" autocomplete="off"></TD>
                </TR>
                <TR>
                <TR>
                  <TD width=110 bgColor=#eff8e7 height=21>
                    <DIV align=center>重复密码：</DIV>
                  </TD>
                  <TD width=400 bgColor=#eff8e7 height=21><input type="password" name="repasswd" id="repasswd" size="30" placeholder="请再次输入密码必须与上一密码相同" data-required="required" autocomplete="off"></TD>
                </TR>
                <TR>
                  <TD width=110 bgColor=#eff8e7 height=21>
                    <DIV align=center>联系电话：</DIV>
                  </TD>
                  <TD width=381 bgColor=#eff8e7 height=21><input type="text" name="dianhua" id="dianhua" size="15" placeholder="请输入联系电话" data-required="required" autocomplete="off"></TD>
                <TR>
                  <TD width=90 bgColor=#eff8e7 height=21>
                    <DIV align=center>E-Mail:　　</DIV>
                  </TD>
                  <TD width=500 bgColor=#eff8e7 height=21><input type="text" name="email" id="email" size="30" placeholder="请输入电子邮箱" data-required="required" autocomplete="off"></TD>
                </TR>
                <TR>
                  <TD colSpan=2 height=21><BR>
                    <BR>
                    <DIV align=center>
                      <input type="submit" value="注&nbsp;&nbsp;册">
                      <input type="reset" value="重&nbsp;&nbsp;填">
                    </DIV>
                  </TD>
                </TR>
              </TBODY>
            </TABLE>
          </FORM>
        </TD>
      </TR>
    </TBODY>
  </TABLE>
</body>

<script>
  function checkRegister() {
    if (document.getElementById("username").value.trim() == "") {
      alert("必须输入账号名称！");
      return false;
    }
    if (/^[\u4e00-\u9fa5]+$/.test(document.getElementById("username").value.trim())) {
      alert("账号不能输入汉字！");
      return false;
    }
    if (document.getElementById("passwd").value.trim().length < 6) {
      alert("密码不能少于6位！");
      return false;
    }
    if (document.getElementById("passwd").value.trim() !== document.getElementById("passwd").value.trim()) {
      alert('密码不一致！');
      return false;
	}
    if (document.getElementById("dianhua").value.trim() == "") {
      alert("必须输入联系电话！");
      return false;
    }
    if (isNaN(document.getElementById("dianhua").value.trim())) {
      alert("联系电话请输入数字");
      return false;
    }
    if (document.getElementById("email").value.trim() !== "") {
      if (!(/[A-z]+[A-z0-9_-]*\@[A-z0-9]+\.[A-z]+/.test(document.getElementById("email").value.trim()))) {
        alert('邮箱格式不对！');
        return false;
      }
    }
    return true;
  }
</script>
</body>
</html>