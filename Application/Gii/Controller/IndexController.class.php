<?php
namespace Gii\Controller;
use Think\Controller;
class  IndexController extends Controller{
	 public function index(){
	 	if(IS_POST){
	 		$mn=trim((string)I('post.modelName'));
	 		$tn=ucfirst(trim((string)I('post.tableName')));
	 		$cdir=APP_PATH.$mn.'/Controller/';
	 		$mdir=APP_PATH.$mn.'/Model/';
	 		$vdir=APP_PATH.$mn.'/View/';
	 		if(!$cdir)
	 			mkdir($cdir,0777,TRUE);
	 		if(!$mdir)
	 			mkdir($mdir,0777,TRUE);
	 		if(!$vdir)
	 			mkdir($vdir,0777,TRUE);
	 		
	 		/***********生成控制器名和模型名********/
	 		$tn=$this->tableName2TpName($tn);
	 		$cName=$tn.'Controller.class.php';
	 		$mName=$tn.'Controller.class.php';
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

