namespace <?php echo $mn; ?>\Model;
use Think\Model;
class <?php echo $tpName;?>Model extends Model{
	// public function $_valicate(){
	protected $_validate=array(
	//下面4行可以放到一个<?php ?>中
		<?php foreach ($fields as $k=>$v):?>
			<?php if($v['Field']=='id')
				 continue; ?>
				<?php if($v['Null']=='NO' && $v['Default'] === null):?>
					array('<?php echo $v['Field'];?>','require','<?php echo $v['Comment'];?>不能为空',1),
				<?php endif;?>
		<?php endforeach;?>
		);
	
	public function search(){
		$where = 1;
		$count      = $this->where($where)->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,4);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $this->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
		return array(
			'page'=>$show,
			'data' => $list
			);
	}

}