<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/Js/jquery-1.4.2.min.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="/index.php/Home/Role/add">添加</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 列表 </span>
    <div style="clear:both"></div>
</h1>
<form method="post" action="/index.php/Home/Role/bdel" onclick="return confilm('确认要删除么?');" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th width="30"><input id="selall" type="checkbox" /></th>
                                <th>id</th>
                            <th>角色名称</th>
                            <th>权限的ID，如果有多个权限就用,隔开，如1,3,4</th>
                            <th>操作</th>
            </tr>
           <?php foreach($data as $k => $v): ?>          <tr class="ontr">
                 <td>
                <input name="delid[]" type="checkbox" value="<?php echo $v['id']; ?>" />
                </td>       
                                <td align="center"><?php echo $v['id']; ?></td>
                                <td align="center"><?php echo $v['role_name']; ?></td>
                                <td align="center"><?php echo $v['pn']; ?></td>
                                <td align="center">
                <a href="/index.php/Home/Role/save/id/<?php echo $v['id']; ?>" title="编辑">编辑</a>
                 <a onclick="return confirm('确认要删除么?');" href="/index.php/Home/Role/del/id/<?php echo $v['id']; ?>" title="编辑">移除</a> 
                </td>
            </tr>
            <?php endforeach; ?>            <tr>
                <td><input type="submit" value="删除所选" /></td>
                <td align="right" nowrap="true" colspan="4">
                       <?php echo $page; ?>         </td>
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
<script>
    $("#selall").click(function(){
        if($(this).attr("checked"))
            $("input[name='delid[]']").attr("checked","checked")
        else
            $("input[name='delid[]']").removeAttr("checked")
    }

        );
</script>