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
	 		$this->success('操作成功');
			die;
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

