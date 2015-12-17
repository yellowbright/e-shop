<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品品牌 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="/index.php/Home/Admin/add">添加管理员</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 管理员列表 </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
    <form action="/index.php/Home/Admin/lst.html" name="searchForm">
    <img src="/Public/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />
    名称: <input type="text" name="un" size="15" value="<?php echo I('get.un'); ?>" />
    id: <input type="text" name="id" size="15" value="<?php echo I('get.id'); ?>" />
        <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>
<form method="post" action="/index.php/Home/Admin/bdel" onclick="return confilm('确认要删除么?');" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th width="30"><input id="selall" type="checkbox" /></th>
                <th>id</th>
                <th>管理员名称</th>
                <th>操作</th>
            </tr>
            <?php foreach($data as $k => $v): ?>
          <tr>
                 <td>
                 <?php if($v['id'] > 1): ?>
                <input name="delid[]" type="checkbox" value="<?php echo $v['id']; ?>" />
            <?php endif; ?>
                </td>       
                <td align="center"><?php echo $v['id']; ?></td>
                <td align="center"><?php echo $v['username']; ?></td>
                <td align="center">
                <a href="/index.php/Home/Admin/save/id/<?php echo $v['id']; ?>" title="编辑">编辑</a>
                <?php if($v['id'] > 1): ?>
                 <a onclick="return confirm('确认要删除么?');" href="/index.php/Home/Admin/del/id/<?php echo $v['id']; ?>" title="编辑">移除</a> 
             <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td><input type="submit" value="删除所选" /></td>
                <td align="right" nowrap="true" colspan="3">
                <?php echo $page;?>
                </td>
            </tr> 
        </table>
    </div>
    {__TOKEN__}
</form>

<div id="footer">
共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>