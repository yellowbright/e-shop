<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 列表 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/Js/jquery-1.4.2.min.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="/index.php/Goods/Type/add">添加</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 列表 </span>
    <div style="clear:both"></div>
</h1>
<form method="post" action="/index.php/Goods/Type/bdel" onsubmit="return confirm('确定要删除吗？');" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
            	<th width="30"><input id="selall" type="checkbox" /></th>
            	                <th>id</th>
                                <th>类型名称</th>
                                <th>操作</th>
            </tr>
            <?php foreach ($data as $k => $v): ?>            <tr>
            	<td>
            		<input name="delid[]" type="checkbox" value="<?php echo $v['id']; ?>" />
            	</td>
            	                <td align="center"><?php echo $v['id']; ?></td>
                                <td align="center"><?php echo $v['type_name']; ?></td>
                                <td align="center">
                <a href="/index.php/Goods/Attribute/lst/type_id/<?php echo $v['id']; ?>" title="属性列表">属性列表</a>
                <a href="/index.php/Goods/Type/save/id/<?php echo $v['id']; ?>" title="编辑">编辑</a>
                <a onclick="return confirm('确定要删除吗？');" href="/index.php/Goods/Type/del/id/<?php echo $v['id']; ?>" title="移除">移除</a> 
                </td>
            </tr>
            <?php endforeach; ?>            <tr>
            	<td><input type="submit" value="删除所选" /></td>
                <td align="right" nowrap="true" colspan="3">
                <?php echo $page; ?>                </td>
            </tr>
        </table>
    </div>
</form>

<div id="footer">
共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<script>
$("#selall").click(function(){
	if($(this).attr("checked"))
		$("input[name='delid[]']").attr("checked", "checked");
	else
		$("input[name='delid[]']").removeAttr("checked");
});
</script>