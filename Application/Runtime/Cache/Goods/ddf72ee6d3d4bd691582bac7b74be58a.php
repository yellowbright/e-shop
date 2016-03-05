<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 库存 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/Js/jquery-1.4.2.min.js"></script>
</head>
<body>
<h1>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 库存 </span>
    <div style="clear:both"></div>
</h1>
<form method="post" action="/index.php/Goods/Goods/goodsnumber/id/7" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
            	<!-- 每一个属性是一列 -->
            	<?php foreach ($attrData as $k => $v): ?>
            	<th><?php echo $v[0]['attr_name']; ?></th>
            	<?php endforeach; ?>
                <th>库存量</th>
                <th>操作</th>
            </tr>
            <!-- 如果之前有数据就循环输出多行 -->
            <?php if($gnData): ?>
	            <?php foreach ($gnData as $k0 => $v0): ?>
	            <tr>
	            	<!-- 有几个属性就有几列 -->
	            	<?php foreach ($attrData as $k => $v): ?>
	            	<td>
	            	<select name="goods_attr_id[<?php echo $k; ?>][]">
		            	<?php foreach ($v as $k1 => $v1): if(strpos(','.$v0['goodsattr_id'].',', $v1['id']) !== FALSE) $select = 'selected="selected"'; else $select = ''; ?>
		            	<option <?php echo $select; ?> value="<?php echo $v1['id']; ?>"><?php echo $v1['attr_value']; ?></option>
		            	<?php endforeach; ?>
	            	</select>
	            	</td>
	            	<?php endforeach; ?>
	            	<td><input type="text" value="<?php echo $v0['goods_number']; ?>" name="goods_number[]" /></td>
	            	<td><input type="button" value="<?php echo $k0 == 0 ? '+' : '-'; ?>" /></td>
	            </tr>
	            <?php endforeach; ?>
	        <?php else: ?>
	         <tr>
	            	<!-- 有几个属性就有几列 -->
	            	<?php foreach ($attrData as $k => $v): ?>
	            	<td>
	            	<select name="goods_attr_id[<?php echo $k; ?>][]">
		            	<?php foreach ($v as $k1 => $v1): ?>
		            	<option value="<?php echo $v1['id']; ?>"><?php echo $v1['attr_value']; ?></option>
		            	<?php endforeach; ?>
	            	</select>
	            	</td>
	            	<?php endforeach; ?>
	            	<td><input type="text" name="goods_number[]" /></td>
	            	<td><input type="button" value="+" /></td>
	            </tr>
	        <?php endif; ?>
        </table>
        <div class="button-div">
        	<input type="submit" value=" 确定 " class="button"/>
        </div>
    </div>
</form>

<div id="footer">
共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<script>
$(":button").click(function(){
	var tr = $(this).parent().parent();
	if($(this).val() == '+')
	{
		// 传True是深度克隆，把事件也一起克隆过来
		var newtr = tr.clone(true);
		newtr.find(":button").val("-");
		$("table").append(newtr);
	}
	else
	{
		tr.remove();
	}
});
</script>