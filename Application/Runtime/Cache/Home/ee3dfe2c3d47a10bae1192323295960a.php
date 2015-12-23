<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 权限添加 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="/index.php/Home/Privilege/lst">权限列表</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 权限添加 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="/index.php/Home/Privilege/add" >
        <table cellspacing="1" cellpadding="3" width="100%">
           <tr>
                <td class="label">上级权限的id</td>
                <td>
                    <select name="parent_id">
                        <option value="0">顶级权限</option>
                        <?php foreach ($data as $k=>$v):?>
                        <option value="<?php echo $v['id'];?>"><?php  echo str_repeat('-', $v['pri_level']*4).$v['pri_name'];?></option>
                    <?php endforeach;?>
                    </select>
                    <span class="require-field">*</span>
                                    </td>
            </tr>
                        <tr>
                <td class="label">权限名称</td>
                <td>
                    <input type="text" name="pri_name" maxlength="60" value="" />
                                        <span class="require-field">*</span>
                                </td>
            </tr>
                        <tr>
                <td class="label">对应的模块名</td>
                <td>
                    <input type="text" name="module_name" maxlength="60" value="" />
                                        <span class="require-field">*</span>
                                </td>
            </tr>
                        <tr>
                <td class="label">对应的控制器名</td>
                <td>
                    <input type="text" name="controller_name" maxlength="60" value="" />
                                        <span class="require-field">*</span>
                                </td>
            </tr>
                        <tr>
                <td class="label">对应的方法名</td>
                <td>
                    <input type="text" name="action_name" maxlength="60" value="" />
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