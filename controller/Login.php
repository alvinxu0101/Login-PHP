<?php
header('content-type:text/html;charset=utf-8');

class Login
{
    public function login()
    {
        if (isset($_POST["Submit"]) && $_POST["Submit"] == "登录") {
            $user = $_POST["username"];
            $psw = $_POST["passwd"];
            if ($user == "" || $psw == "") {
                echo "<script>alert('请输入用户名或密码！');</script>";
            } else {
                mysql_connect("localhost", "root", "root");
                mysql_select_db("login");
                mysql_query("set names 'utf-8'");
                $sql = "select username,passwd from user where username = '$_POST[username]' and passwd = '$_POST[passwd]'";
                $result = mysql_query($sql);
                $num = mysql_num_rows($result);
                if ($num) {
                    $row = mysql_fetch_array($result);  //将数据以索引方式储存在数组中
                    /*echo $row[0];*/
                    include '../view/LoginS.html';
                } else {
                    echo "<script>alert('用户名或密码不正确！');</script>";
                    include "../view/Login.html";
                }
            }
        } else {
            echo "<script>alert('提交未成功！'); </script>";
        }
        mysql_close();
    }
}

?>