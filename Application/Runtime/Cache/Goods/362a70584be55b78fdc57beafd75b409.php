<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 修改 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/Js/jquery-1.4.2.min.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="/index.php/Goods/Category/lst">列表</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 修改 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="/index.php/Goods/Category/save/id/6">
    	<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <table cellspacing="1" cellpadding="3" width="100%">
        <tr>
	                <td class="label">上级分类</td>
	                <td>
	                    <select name="parent_id">
	                		<option value="0">顶级分类</option>
	                		<?php foreach ($catData as $k => $v): if($v['id'] == $data['id']) continue ; if($v['id'] == $data['parent_id']) $select = 'selected="selected"'; else $select = ''; ?>
	                			<option <?php echo $select; ?> value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', $v['level']*4).$v['cat_name']; ?></option>
	                		<?php endforeach; ?>
	                	</select>
	                    	                    <span class="require-field">*</span>
	                    	                </td>
	            </tr>
	       	 	            <tr>
	                <td class="label">分类名称</td>
	                <td>
	                    <input type="text" name="cat_name" maxlength="60" value="<?php echo $data['cat_name']; ?>" />
	                    	                    <span class="require-field">*</span>
	                    	                </td>
	            </tr>
	           	            <tr>
	                <td class="label">价格区间</td>
	                <td>
	                    <input type="text" name="price_section" maxlength="60" value="<?php echo $data['price_section']; ?>" />
	                    	                    <span class="require-field">*</span>
	                    	                </td>
	            </tr>
	           	            <tr>
	                <td class="label">页面的关键字</td>
	                <td>
	                	<textarea rows="6" cols="60" name="cat_keywords"><?php echo $data['cat_keywords']; ?></textarea>
	                    	                    <span class="require-field">*</span>
	                    	                </td>
	            </tr>
	           	            <tr>
	                <td class="label">页面的描述</td>
	                <td>
	                	<textarea rows="6" cols="60" name="cat_description"><?php echo $data['cat_description']; ?></textarea>
	                    	                    <span class="require-field">*</span>
	                    	                </td>
	            </tr>
	           	            <tr>
                <td class="label">筛选属性</td>
                <td id="attrIDTD">
                	<?php if(!$attrInfo): ?>
                	<div>
                		<input type="button" value="+" onclick="addARow(this);" />
	                	<select onchange="getAttr(this);">
	                		<option value="0">选择类型</option>
	                		<?php foreach ($typeData as $k => $v): ?>
	                		<option value="<?php echo $v['id']; ?>"><?php echo $v['type_name']; ?></option>
	                		<?php endforeach; ?>
	                	</select>
	                	<select name="attr_id[]"></select>
                	</div>
                	<?php endif; ?>
                	<?php  foreach ($attrInfo as $k1 => $v1): ?>
                	<div>
                		<input type="button" value="<?php echo $k1==0?'+':'-'; ?>" onclick="addARow(this);" />
	                	<select class="typeselect" onchange="getAttr(this);">
	                		<option value="0">选择类型</option>
	                		<?php foreach ($typeData as $k => $v): if($v['id'] == $v1['type_id']) $select = 'selected="selected"'; else $select = ''; ?>
	                		<option <?php echo $select; ?> value="<?php echo $v['id']; ?>"><?php echo $v['type_name']; ?></option>
	                		<?php endforeach; ?>
	                	</select>
	                	<select curId="<?php echo $v1['id']; ?>" name="attr_id[]"></select>
                	</div>
                	<?php endforeach; ?>
               </td>
            </tr>
            <tr>
                    <td class="label">推荐到：</td>
                    <td>
                    	<?php foreach ($recData as $k => $v): if(strpos(','.$data['rec_id'].',', ','.$v['id'].',') !== FALSE) $check = 'checked="checked"'; else $check = ''; ?>
                    	<input <?php echo $check; ?>type="checkbox" name="rec_id[]" value="<?php echo $v['id']; ?>" /><?php echo $v['rec_name']; ?>
                    	<?php endforeach; ?>
                    </td>
                </tr>
	                       <tr>
                <td colspan="2" align="center"><br />
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>

<div id="footer">
共执行 1 个查询，用时 0.018952 秒，Gzip 已禁用，内存占用 2.197 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<script>
// ajax获取属性
function getAttr(select)
{
	var type_id = $(select).val();
	// 这个类型对应的属性的下拉框
	var attrSelect = $(select).next("select");
	// 当前这个下拉框应该选择的ID
	var curId = attrSelect.attr("curid");
	$.ajax({
		type : "GET",
		url : "/index.php/Goods/Category/ajaxGetAttr/type_id/"+type_id,
		dataType : "json",
		success : function(data)
		{
			var html = "<option value='0'>选择筛选属性</option>";
			var selected;
			// 循环每一个属性放到下拉框中
			$(data).each(function(k,v){
				if(v.id == curId)
					selected = "selected='selected'";
				else
					selected = '';
				html += "<option "+selected+" value='"+v.id+"'>"+v.attr_name+"</option>";
			});
			attrSelect.html(html);
		}
	});
}
// 点击按钮时把div复制一行
function addARow(btn)
{
	var div = $(btn).parent();
	if($(btn).val() == "+")
	{
		// 克隆一个新的Div
		var newdiv = div.clone();
		// 设置新行中的按钮是-行
		newdiv.find(":button").val("-");
		// 第二个（属性）下拉框清空
		newdiv.find("select").eq(1).html("");
		// 去掉新的下的curId属性
		newdiv.find("select").eq(1).removeAttr("curid");
		// 把新div放到td的最后
		$("#attrIDTD").append(newdiv);
		// 直接触发change取出后面的属性
		newdiv.find("select").eq(0).trigger("change");
	}
	else
		div.remove();
}
// 直接触类型下拉框的onchange事件，取出后面的属性来
$(".typeselect").trigger("change");
</script>