<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/Js/jquery-1.4.2.min.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="/index.php/Home/Role/lst">列表</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="/index.php/Home/Role/add" >
        <table cellspacing="1" cellpadding="3" width="100%">
                        <tr>
                <td class="label">角色名称</td>
                <td>
                    <input type="text" name="role_name" maxlength="60" value="" />
                                        <span class="require-field">*</span>
                                </td>
            </tr>
                        <tr>
                <td class="label">权限的ID，如果有多个权限就用,隔开，如1,3,4</td>
                <td>
                <?php foreach ($data as $k => $v): ?>
                        <input level="<?php echo $v['pri_level']; ?>" type="checkbox" name="pri_id[]" value="<?php echo $v['id']; ?>" /><?php echo str_repeat('-', $v['pri_level']*4).$v['pri_name']; ?><br />
                   <?php endforeach; ?>
                                        <span class="require-field">*</span>
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
//click表示点击之后的动作
$(":checkbox").click(function(){
    var _this = $(this);
    // 取出当前权限的级别
    var cur_level = _this.attr("level");
    //这里的.attr表示点击之后的状态
    if(_this.attr("checked"))
    {
        // 点击的checkbox前面的checkbox
        _this.prevAll(":checkbox").each(function(k,v){
            // 这里的$(this)代表前面的每个,如果前面的级别小于当前级别就是上一级
            if($(this).attr("level") < cur_level)
            {
                // 找到一个上级之后，减一级，下次再向上找一级
                cur_level--;
                $(this).attr("checked", "checked");
            }
        });
    }
    else
    {
        // 取出所有子权限并取消选状态
        _this.nextAll(":checkbox").each(function(k,v){
            if($(this).attr("level") > cur_level)
                $(this).removeAttr("checked");
            else
                return false;  // 遇到同级的就退出
        });
    }
});
</script>