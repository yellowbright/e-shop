<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="/index.php/Goods/Goods/add">添加</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 列表 </span>
    <div style="clear:both"></div>
</h1>
<form method="post" action="/index.php/Goods/Goods/bdel" onclick="return confilm('确认要删除么?');" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th width="30"><input id="selall" type="checkbox" /></th>
                                <th>id</th>
                            <th>商品名称</th>
                            <th>小图</th>
                            <th>中图</th>
                            <th>大图</th>
                            <th>原图</th>
                            <th>分类ID</th>
                            <th>品牌ID</th>
                            <th>市场价</th>
                            <th>本店价</th>
                            <th>是否上架</th>
                            <th>商品描述</th>
                            <th>商品类型id</th>
                            <th>推荐位的ID，多个用，隔开</th>
                            <th>操作</th>
            </tr>
           <?php foreach($data as $k => $v): ?>          <tr class="ontr">
                 <td>
                <input name="delid[]" type="checkbox" value="<?php echo $v['id']; ?>" />
                </td>       
                <td align="center"><?php echo $v['id']; ?></td>
                <td align="center"><?php echo $v['username']; ?></td>
                <td align="center">
                <a href="/index.php/Goods/Goods/save/id/<?php echo $v['id']; ?>" title="编辑">编辑</a>
                 <a onclick="return confirm('确认要删除么?');" href="/index.php/Goods/Goods/del/id/<?php echo $v['id']; ?>" title="编辑">移除</a> 
                </td>
            </tr>
            <?php endforeach; ?>            <tr>
                <td><input type="submit" value="删除所选" /></td>
                <td align="right" nowrap="true" colspan="15">
                <?php echo $page;?>                </td>
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