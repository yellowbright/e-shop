<?php
namespace Gii\Controller;
use Think\Controller;
class IndexController extends Controller{
	 public function index(){
	 	if(IS_POST){
	 		$mn=ucfirst(trim((string)I('post.moduleName')));
	 		$tn=trim((string)I('post.tableName'));
	 		if(!$tn || !$mn)
				$this->error('表名和模块名不能为空！');
	 		$tpName=$this->tableName2TpName($tn);
	 		$cdir=APP_PATH.$mn.'/Controller/';
	 		$mdir=APP_PATH.$mn.'/Model/';
	 		$vdir=APP_PATH.$mn.'/View/'.$tpName.'/';
	 		if(!is_dir($cdir))
	 			mkdir($cdir,0777,TRUE);
	 		if(!is_dir($mdir))
	 			mkdir($mdir,0777,TRUE);
	 		if(!is_dir($vdir))
	 			mkdir($vdir,0777,TRUE);
	 		/***********生成控制器名和模型名********/
	 		$cName=$tpName.'Controller.class.php';
	 		$mName=$tpName.'Model.class.php';
	 		/*************************生成控制器和模型以及视图等*************************/
	 		ob_start();
	 		include(APP_PATH.'Gii/Template/Controller.php');
	 		$str=ob_get_clean();
	 		//\r\n只能在双引号中转义
	 		file_put_contents($cdir.$cName,"<?php\r\n".$str);
	 		/************************ 生成模型文件 *************************/
			// 取出表中所有字段的信息
	 		$model=M();
	 		$fields=$model->query("SHOW FULL FIELDS FROM ".$tn);
	 		ob_start();
	 		include(APP_PATH.'Gii/Template/Model.php');
	 		$str=ob_get_clean();
	 		file_put_contents($mdir.$mName, "<?php\r\n".$str);

	 		/*************************生成add,lst,save视图等*************************/
	 		ob_start();
	 		include(APP_PATH.'Gii/Template/add.html');
	 		$str=ob_get_clean();
	 		file_put_contents($vdir.'add.html', $str);

	 		ob_start();
	 		include(APP_PATH.'Gii/Template/lst.html');
	 		$str=ob_get_clean();
	 		file_put_contents($vdir.'lst.html', $str);

	 		ob_start();
	 		include(APP_PATH.'Gii/Template/save.html');
	 		$str=ob_get_clean();
	 		file_put_contents($vdir.'save.html', $str);

	 		/*********************************** 向权限表插入相应的权限 ***********************/
			// 1. 先判断顶级权限现在是否存在 
			$tpn = I('post.topPriName');
			$priModel = M('Privilege');
			$topPri = $priModel->where("pri_level=0 AND pri_name='$tpn'")->find();
			if($topPri)
				$topPriId = $topPri['id'];
			else 
			{
				// 如果不存在就插入顶级权限
				$topPriId = $priModel->add(array(
					'parent_id' => 0,
					'pri_name' => $tpn,
					'module_name' => 'null',
					'controller_name' => 'null',
					'action_name' => 'null',
					'pri_level' => 0,
				));
			}
			// 2. 在顶级权限下面添加二级权限
			$cnName = I('post.cnName');
			$subPriId = $priModel->add(array(
				'parent_id' => $topPriId,
				'pri_name' => $cnName.'列表',
				'module_name' => $mn,
				'controller_name' => $tpName,
				'action_name' => 'lst',
				'pri_level' => 1,
			));
			// 3. 添加三级权限
			$priModel->add(array(
				'parent_id' => $subPriId,
				'pri_name' => '添加'.$cnName,
				'module_name' => $mn,
				'controller_name' => $tpName,
				'action_name' => 'add',
				'pri_level' => 2,
			));
			$priModel->add(array(
				'parent_id' => $subPriId,
				'pri_name' => '修改'.$cnName,
				'module_name' => $mn,
				'controller_name' => $tpName,
				'action_name' => 'save',
				'pri_level' => 2,
			));
			$priModel->add(array(
				'parent_id' => $subPriId,
				'pri_name' => '删除'.$cnName,
				'module_name' => $mn,
				'controller_name' => $tpName,
				'action_name' => 'del',
				'pri_level' => 2,
			));
			$priModel->add(array(
				'parent_id' => $subPriId,
				'pri_name' => '批量删除'.$cnName,
				'module_name' => $mn,
				'controller_name' => $tpName,
				'action_name' => 'bdel',
				'pri_level' => 2,
			));
			
			$this->success('操作成功！');
			exit;
	 	}
	 	$this->display();
	 }
	 public function tableName2TpName($tablename){
	 	$prefix=C('DB_PREFIX');
	 	if(strpos($tablename,$prefix)===0){
	 		$len=strlen($prefix);
	 		$tablename=substr($tablename,$len);
			 }
		$tablename=explode('_',$tablename);
		$tablename=array_map('ucfirst',$tablename);
		$tablename=implode('', $tablename);

		return $tablename;
	 	}
}

