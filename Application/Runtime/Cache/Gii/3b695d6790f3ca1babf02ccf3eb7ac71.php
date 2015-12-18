<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <form method="post" action="/index.php/Gii/Index/index">
    	模块名:<input type="text" name="moduleName">
    	表单名:<input type="text" name="tableName">
    	<input type="submit" value="确定">
    	<input type="reset" value="重置">
    </form>
</body>
</html>