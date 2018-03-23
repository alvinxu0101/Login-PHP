<?php
header('content-type:text/html;charset=utf-8');

class Register
{
    public function register()
    {
        if (isset($_POST["Submit"]) && $_POST["Submit"] == "注册") {
            $user = $_POST["username"];
            $psw = $_POST["passwd"];
            $psw_confirm = $_POST["repasswd"];
            if ($user == "" || $psw == "" || $psw_confirm == "") {
                echo "<script>alert('请确认信息完整性！');history.go(-1);</script>";
                require '../view/Register.html';
            } else {
                if ($psw == $psw_confirm) {
                    /*对数据库的操作*/
                    mysql_connect("localhost", "root", "root");   //连接数据库
                    mysql_select_db("login");  //选择数据库
                    mysql_query("set names 'utf-8'"); //设定字符集
                    $sql = "select username from user where username = '$_POST[username]'"; //SQL语句
                    $result = mysql_query($sql);    //执行SQL语句
                    $num = mysql_num_rows($result); //统计执行结果影响的行数
                    if ($num)    //如果已经存在该用户
                    {
                        echo "<script>alert('用户名已存在');</script>";
                        echo "<script></script>";
                        include '../view/Register.html';
                    } else    //不存在当前注册用户名称
                    {
                        $sql_insert = "insert into user (username,passwd) values('$_POST[username]','$_POST[passwd]')";
                        $res_insert = mysql_query($sql_insert);
                        //$num_insert = mysql_num_rows($res_insert);
                        if ($res_insert) {
                            echo "<script>alert('注册成功！');</script>";
                            include '../view/Login.html';
                        } else {
                            echo "<script>alert('系统繁忙，请稍候！');</script>";
                            include '../view/Register.html';
                        }
                    }
                } else {
                    echo "<script>alert('密码不一致！');</script>";
                    include '../view/Register.html';
                }
            }
        } else {
            echo "<script>alert('提交未成功！');</script>";
            include '../view/Register.html';
        }
    }
}

?>