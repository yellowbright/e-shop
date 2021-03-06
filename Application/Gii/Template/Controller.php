
// namespace Home/Controller;
// use Think/Controller;
namespace <?php echo $mn; ?>\Controller;
class <?php echo $tpName;?>Controller extends \Home\Controller\IndexController{
	public function lst(){
		$model = D('<?php echo $tpName;?>');
		$data = $model -> search();
		$this -> assign(
			array(
				'data' => $data['data'],
				'page'=>$data['page']
				)
			);
		$this -> display();
	}
	public function add(){
		if(IS_POST){
			$model=D('<?php echo $tpName;?>');
			if($model->create()){
				if($model->add()){
					$this->success('添加数据成功',U('lst'));
					// 注意添加exit
					exit;
				}
				else{
					// $sql=$model->getLstSql();
					$sql=$model->getLastSql();
					$this->error('添加数据失败!  <br/>'.$sql);
				}
			}else{
				$error=$model->getError();
				$this->error($error);
			}
		}
		$this->display();
	}
	public function save($id){
		$model=D('<?php echo $tpName;?>');
		if(IS_POST){
			if($model->create()){
				if($model->save()!==FALSE){
					$this->success('修改数据成功',U('lst'));
					// 注意添加exit
					exit;
				}
				else{
					// $sql=$model->getLstSql();
					$sql=$model->getLastSql();
					$this->error('修改数据失败!  <br/>'.$sql);
				}
			}else{
				$error=$model->getError();
				$this->error($error);
			}
		}
		$data  = $model -> find($id);
		$this -> assign('data', $data);
		$this->display();
	}
	public function del($id){
		$model = D('<?php echo $tpName;?>');
			$model -> delete($id);
		$this -> success('删除成功',U('lst'));
	}
	public function bdel(){
		$delid = (array)I('post.delid');
		if($delid){
			$delid =implode(',',$delid);
			$model = D('<?php echo $tpName;?>');
			if (!$model->autoCheckToken($_POST)){
 // 令牌验证错误
				$this->error('令牌验证错误');
 }
			$model -> delete($delid);
			}	
	$this -> success('批量删除成功',U('lst'));
	exit;
	}
}