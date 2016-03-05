<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加新商品 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/Js/jquery-1.4.2.min.js"></script>

    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="/index.php/Goods/Goods/lst">商品列表</a>
    </span>
    <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加新商品 </span>
    <div style="clear:both"></div>
</h1>

<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front">基本信息</span>
            <span class="tab-back">商品描述</span>
            <span class="tab-back">会员价格</span>
            <span class="tab-back">商品属性</span>
            <span class="tab-back">商品图片</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/index.php/Goods/Goods/add" method="post">
        	<!-- 基本信息 -->
            <table width="90%" class="spanandtable" align="center">
            	<tr>
                    <td class="label">logo：</td>
                    <td><input type="file" name="logo" />
                    </td>
                </tr>
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="Goods[goods_name]" value=""size="30" />
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">商品分类：</td>
                    <td>
                        <select name="Goods[cat_id]">
	                		<option value="0">选择商品分类</option>
	                		<?php foreach ($catData as $k => $v): ?>
	                			<option value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', $v['level']*4).$v['cat_name']; ?></option>
	                		<?php endforeach; ?>
	                	</select>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品品牌：</td>
                    <td>
                        <select name="Goods[brand_id]">
	                		<option value="0">选择品牌</option>
	                		<?php foreach ($brandData as $k => $v): ?>
	                			<option value="<?php echo $v['id']; ?>"><?php echo $v['brand_name']; ?></option>
	                		<?php endforeach; ?>
	                	</select>
                    </td>
                </tr>
                <tr>
                    <td class="label">市场价：</td>
                    <td>
                        <input type="text" name="Goods[market_price]" value="0" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="Goods[shop_price]" value="0" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="Goods[is_on_sale]" value="1"/> 是
                        <input type="radio" name="Goods[is_on_sale]" value="0"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">推荐到：</td>
                    <td>
                    	<?php foreach ($recData as $k => $v): ?>
                    	<input type="checkbox" name="Goods[rec_id][]" value="<?php echo $v['id']; ?>" /><?php echo $v['rec_name']; ?>
                    	<?php endforeach; ?>
                    </td>
                </tr>
            </table>
            
            <!-- 商品描述 -->
            <table width="100%" class="spanandtable" align="center" style="display:none;">
            	<tr>
                    <td>
                        <textarea id="goods_desc" name="Goods[goods_desc]" cols="40" rows="3"></textarea>
                    </td>
                </tr>
            </table>
            
            <!-- 会员价格 -->
            <table width="90%" class="spanandtable" align="center" style="display:none;">
            	<?php foreach ($mlData as $k => $v): ?>
            	<tr>
                    <td class="label"><?php echo $v['level_name']; ?>：</td>
                    <td>
                        ￥<input type="text" name="MemberPrice[<?php echo $v['id']; ?>]" />元
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            
            <!-- 商品属性 -->
            <table width="90%" class="spanandtable" align="center" style="display:none;">
            	<tr>
                    <td class="label">商品属性：</td>
                    <td>
                        <select name="Goods[type_id]">
                        	<option value="0">选择商品类型</option>
                        <?php foreach ($typeData as $k => $v): ?>
                        	<option value="<?php echo $v['id']; ?>"><?php echo $v['type_name']; ?></option>
                        <?php endforeach; ?>
                        </select>
                        <div id="attr_element"></div>
                    </td>
                </tr>
            </table>
            
            <!-- 商品图片 -->
            <table width="90%" class="spanandtable" align="center" style="display:none;">
            	<tr>
                    <td>
                    	<script>var str = '<tr><td><input type="file" name="pics[]" /></td></tr>';</script>
                    	<input onclick="$(this).parent().parent().parent().append(str);" type="button" value="添加一张" />
                    </td>
                </tr>
                <tr>
                    <td>
                    	<input type="file" name="pics[]" />
                    </td>
                </tr>
            </table>
            
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
</div>

<div id="footer">
共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<script>
$("#tabbar-div p span").click(function(){
	// 计算点击的是第几个按钮
	var i = $(this).index();
	// 隐藏所有的Table
	$(".spanandtable").hide();
	// 显示第i个
	$(".spanandtable").eq(i).show();
	// 先去掉原选中的按钮
	$(".tab-front").removeClass("tab-front").addClass("tab-back");
	// 设置当前按钮为选中状态
	$(this).removeClass("tab-back").addClass("tab-front");
});

// 实际商品类型的AJAX效果
$("select[name='Goods[type_id]']").change(function(){
	// 获取选中的类型的id
	var tid = $(this).val();
	$.ajax({
		type : "GET",
		url : "/index.php/Goods/Goods/ajaxGetAttr/tid/"+tid,
		dataType : "json",
		success : function(data)
		{
			var html = "<ul>";
			// 循环每一个属性
			$(data).each(function(k,v){
				html += "<li>";
				html += v.attr_name+" : ";
				if(v.attr_type == '单选')
					html += " <a onclick='addALi(this);' href='#'>[+]</a> ";
				if(v.attr_option_value == "")
				{
					html += " <input type='text' name='goods_attr["+v.id+"][]' />";
				}
				else
				{
					// 把可选值转化成数组
					var attr_array = v.attr_option_value.split(",");
					html += "<select name='goods_attr["+v.id+"][]'>";
					html += "<option value=''>选择属性值</option>";
					for(var i=0; i<attr_array.length; i++)
					{
						html += "<option value='"+attr_array[i]+"'>"+attr_array[i]+"</option>";
					}
					html += "</select>";
				}
				html += " ￥<input name='attr_price[]' type='text' />元";
				html += "</li>";
			});
			html += "</ul>";
			// 把构造的字符串放到div中
			$("#attr_element").html(html);
		}
	});
});
function addALi(a)
{
	var opt = $(a).html();
	var li = $(a).parent();
	if(opt == "[+]")
	{
		var newli = li.clone();
		newli.find("a").html("[-]");
		// 把新LI放到LI后面
		li.after(newli);
	}
	else
		li.remove();
}

UE.getEditor('goods_desc');
</script>