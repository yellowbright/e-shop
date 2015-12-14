# set namss utf8;
# use yellow28;
# DROP TABLE yellow28_text1 IF EXECT;
# CREATE TABLE yellow28_text1(
# id int NOT NULL auto_increment commit 'id',
# name varchar(30) not null default '' commit 'name',
# secret char(30) not null defauit '' commit 'secret',
# fun_id mediumint not null default 0 commit 'fun id',
# fun_level tinyint not null default 0 commit 'fun level',
# fun_type enum(1,2) not null default 1 commit 'fun type',
# primary key(id),
# )engine=MASIAM default charset=utf8;

# DROP TABLE IF EXECT yellow28_text2;
# CREATE TABLE yellow28_text2(
# id mediumint not null auto_increment commit 'id',
# fun_id mediumint not null default 0 commit 'fun id',
# foreign key(fun_id) references yellow28_text1(fun_id) on delete cascade,
# primary key (id),
# )engine=InnoDB default charset=utf8;

set names utf8;
use yellow28;
DROP TABLE IF EXISTS yellow28_text1;
CREATE TABLE yellow28_text1(
id int unsigned not null auto_increment comment 'id',
name varchar(30) not null comment 'name',
name2 varchar(32) not null comment 'name2',
secret char(30) not null comment 'secret',
fun_id mediumint unsigned not null comment 'fun id',
fun_level tinyint unsigned not null default 1 comment 'fun level',
fun_type enum('1','2') not null default '1' comment 'fun type',
primary key (id)
)engine=InnoDB default charset=utf8 comment 'text1';

DROP TABLE IF EXISTS yellow28_text2;
CREATE TABLE yellow28_text2(
id mediumint unsigned not null auto_increment comment 'id',
fun_id int unsigned not null comment 'fun id',
foreign key (fun_id) references yellow28_text1 (id) on delete cascade,
primary key (id)
)engine=InnoDB default charset=utf8 comment 'text2';
INSERT INTO yellow28_text1 VALUES(1,'名字','名字二','mima',1,1,'1');

use yellow28;
set names utf8;

# int                  0 ~ 40多亿
# mediumint            0 ~ 1600多万
# smallint             0 ~ 65535
# tinyint              0 ~ 255
# varchar(5) 和 char(5) 啥区别？
# varchar(5) 能不能存 'abcdef'？同样不能存！
# 如存 'abc'     char(5) -> 占5个字符，   字节：gbk/汉字*2 utf8/汉字*3
# 如存 'abc\0'   varchar(5) -> 占4个字符，字节：gbk/汉字*2 utf8/汉字*3
# char,varchar,text最大长度？
# char : 最大能存255个字符
# varchar : 最大能存 65535个字节
# text    : 最大能存 65535个字符

# 导入到数据库中
# 方法一：在mysql中执行 source db.sql;
# 方法二：直接把SQL复制到MYSQL中执行（要先set names gbk)

DROP TABLE IF EXISTS yellow28_admin;
CREATE TABLE yellow28_admin
(
	id int unsigned not null auto_increment comment 'id',
	username varchar(30) not null comment '用户名',
	password char(32) not null comment '密码',
	role_id mediumint unsigned not null default '0' comment '角色的id',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '管理员';
INSERT INTO yellow28_admin VALUES(1,'admin','21232f297a57a5a743894a0e4a801fc3',1);

DROP TABLE IF EXISTS yellow28_privilege;
CREATE TABLE yellow28_privilege
(
	id mediumint unsigned not null auto_increment comment 'id',
	pri_name varchar(30) not null comment '权限名称',
	module_name varchar(30) not null comment '对应的模块名',
	controller_name varchar(30) not null comment '对应的控制器名',
	action_name varchar(30) not null comment'对应的方法名',
	parent_id mediumint unsigned not null default '0' comment '上级权限的id',
	pri_level tinyint unsigned not null default '0' comment '权限的级别。0：一级 1：二级',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '权限';

DROP TABLE IF EXISTS yellow28_role;
CREATE TABLE yellow28_role
(
	id mediumint unsigned not null auto_increment comment 'id',
	role_name varchar(30) not null comment '角色名称',
	pri_id varchar(150) not null default '' comment '权限的ID，如果有多个权限就用,隔开，如1,3,4',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '角色';
INSERT INTO yellow28_role VALUES(1,'超级管理员','*');

# 多对多（现在是多对多）
# 一个角色有多个权限
# 一个权限可以被多个角色拥有

# 一对多
# 一个班级有多个学生
# 一个学生只属于一个班级

DROP TABLE IF EXISTS yellow28_category;
CREATE TABLE yellow28_category
(
	id mediumint unsigned not null auto_increment comment 'id',
	cat_name varchar(30) not null comment '分类名称',
	parent_id mediumint unsigned not null default '0' comment '上级分类的id',
	price_section tinyint unsigned not null default '5' comment '价格区间',
	cat_keywords varchar(300) not null default '' comment '页面的关键字',
	cat_description varchar(300) not null default '' comment '页面的描述',
	attr_id varchar(150) not null default '' comment '筛选属性id,多个用，隔开',
	rec_id varchar(150) not null default '' comment '推荐位的ID，多个用，隔开',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '商品分类';

DROP TABLE IF EXISTS yellow28_brand;
CREATE TABLE yellow28_brand
(
	id mediumint unsigned not null auto_increment comment 'id',
	brand_name varchar(30) not null comment '品牌名称',
	site_url varchar(150) not null default '' comment '官方网站',
	brand_logo varchar(150) not null default '' comment '图片的LOGO',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '商品品牌';

DROP TABLE IF EXISTS yellow28_type;
CREATE TABLE yellow28_type
(
	id mediumint unsigned not null auto_increment comment 'id',
	type_name varchar(30) not null comment '类型名称',
	primary key (id)
)engine=InnoDB default charset=utf8 comment '商品类型';

DROP TABLE IF EXISTS yellow28_attribute;
CREATE TABLE yellow28_attribute
(
	id mediumint unsigned not null auto_increment comment 'id',
	attr_name varchar(30) not null comment '属性名称',
	attr_type enum("单选",'唯一') not null default '唯一' comment '属性类型',
	attr_option_value varchar(300) not null default '' comment '属性可选值',
	type_id mediumint unsigned not null default '0' comment '类型id',
	foreign key (type_id) references yellow28_type(id) on delete cascade,
	primary key (id)
)engine=InnoDB default charset=utf8 comment '属性表';

DROP TABLE IF EXISTS yellow28_goods;
CREATE TABLE yellow28_goods
(
	id mediumint unsigned not null auto_increment comment 'id',
	goods_name varchar(30) not null comment '商品名称',
	sm_logo varchar(150) not null default '' comment '小图',
	mid_logo varchar(150) not null default '' comment '中图',
	big_logo varchar(150) not null default '' comment '大图',
	logo varchar(150) not null default '' comment '原图',
	cat_id mediumint unsigned not null default '0' comment '分类ID',
	brand_id mediumint unsigned not null default '0' comment '品牌ID',
	market_price decimal(10,2) not null default '0.00' comment '市场价',
	shop_price decimal(10,2) not null default '0.00' comment '本店价',
	is_on_sale enum('是','否') not null default '是' comment '是否上架',
	goods_desc text comment '商品描述',
	type_id mediumint unsigned not null default '0' comment '商品类型id',
	rec_id varchar(150) not null default '' comment '推荐位的ID，多个用，隔开',
	primary key (id),
	key shop_price(shop_price)
)engine=MyISAM default charset=utf8 comment '商品表';

DROP TABLE IF EXISTS yellow28_member_level;
CREATE TABLE yellow28_member_level
(
	id mediumint unsigned not null auto_increment comment 'id',
	level_name varchar(30) not null comment '级别名称',
	top int unsigned not null default '0' comment '积分上限',
	bottom int unsigned not null default '0' comment '积分下限',
	rate int unsigned not null default '100' comment '折扣',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '会员级别';

DROP TABLE IF EXISTS yellow28_member_price;
CREATE TABLE yellow28_member_price
(
	price decimal(10,2) not null default '0.00' comment '价格',
	level_id mediumint unsigned not null default '0' comment '会员级别id',
	goods_id mediumint unsigned not null default '0' comment '商品的id'
)engine=MyISAM default charset=utf8 comment '会员价格';

DROP TABLE IF EXISTS yellow28_goods_pic;
CREATE TABLE yellow28_goods_pic
(
	id mediumint unsigned not null auto_increment comment 'id',
	sm_logo varchar(150) not null default '' comment '小图',
	mid_logo varchar(150) not null default '' comment '中图',
	logo varchar(150) not null default '' comment '原图',
	goods_id mediumint unsigned not null default '0' comment '商品的id',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '商品图片';

DROP TABLE IF EXISTS yellow28_goods_attr;
CREATE TABLE yellow28_goods_attr
(
	id mediumint unsigned not null auto_increment comment 'id',
	goods_id mediumint unsigned not null default '0' comment '商品的id',
	attr_id mediumint unsigned not null default '0' comment '属性id',
	attr_value varchar(150) not null default '' comment '属性值',
	attr_price decimal(10,2) not null default '0.00' comment '属性的价格',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '商品属性';

DROP TABLE IF EXISTS yellow28_goods_number;
CREATE TABLE yellow28_goods_number
(
	goods_id mediumint unsigned not null default '0' comment '商品的id',
	goods_number int unsigned not null default '0' comment '商品数量',
	goodsattr_id varchar(150) not null default '' comment '商品属性ID，如果有多个属性用,隔开'
)engine=MyISAM default charset=utf8 comment '商品库存';

DROP TABLE IF EXISTS yellow28_member;
CREATE TABLE yellow28_member
(
	id mediumint unsigned not null auto_increment comment 'id',
	username varchar(30) not null comment '用户名',
	email varchar(150) not null comment 'email',
	password char(32) not null comment '密码',
	email_code char(13) not null comment 'email验证码,如果这个字段为空，代表已经验证过了',
	email_code_time int unsigned not null comment '验证码生成的时间',
	jifen int unsigned not null default '0' comment '会员的积分',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '会员';

DROP TABLE IF EXISTS yellow28_recommend;
CREATE TABLE yellow28_recommend
(
	id mediumint unsigned not null auto_increment comment 'id',
	rec_name varchar(150) not null comment '推荐位名称',
	rec_type enum('商品','分类') not null comment '推荐位的类型',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '推荐位';

DROP TABLE IF EXISTS yellow28_history;
CREATE TABLE yellow28_history
(
	id mediumint unsigned not null auto_increment comment 'id',
	member_id mediumint unsigned not null comment '会员的id',
	goods_id mediumint unsigned not null comment '商品的id',
	view_count int unsigned null default '0' comment '浏览的次数',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '浏览历史';

DROP TABLE IF EXISTS yellow28_remark;
CREATE TABLE yellow28_remark
(
	id mediumint unsigned not null auto_increment comment 'id',
	member_id mediumint unsigned not null comment '会员的id',
	goods_id mediumint unsigned not null comment '商品的id',
	content varchar(300) not null comment '评论的内容',
	addtime datetime not null comment '评论的时间',
	stars tinyint unsigned not null default '5' comment '打分',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '评论';

DROP TABLE IF EXISTS yellow28_yinxiang;
CREATE TABLE yellow28_yinxiang
(
	id mediumint unsigned not null auto_increment comment 'id',
	goods_id mediumint unsigned not null comment '商品的id',
	yx_name varchar(30) not null comment '印象',
	yx_count int unsigned not null comment '印象次数',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '印象';

DROP TABLE IF EXISTS yellow28_cart;
CREATE TABLE yellow28_cart
(
	id mediumint unsigned not null auto_increment comment 'id',
	goods_id mediumint unsigned not null comment '商品的id',
	member_id mediumint unsigned not null comment '会员的ID',
	gaid varchar(30) not null default '' comment '商品属性的id',
	gastr varchar(150) not null default '' comment '商品属性的字符串',
	goods_number int unsigned not null default '1' comment '商品的数量',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '购物车';

DROP TABLE IF EXISTS yellow28_address;
CREATE TABLE yellow28_address
(
	id mediumint unsigned not null auto_increment comment 'id',
	member_id mediumint unsigned not null comment '会员的ID',
	shr_name varchar(30) not null comment '收货人姓名',
	shr_province varchar(30) not null comment '收货人省',
	shr_city varchar(30) not null comment '收货人市',
	shr_area varchar(30) not null comment '收货人地区',
	shr_address varchar(30) not null comment '收货人详细地址',
	shr_phone varchar(30) not null comment '收货人手机',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '收货人';

DROP TABLE IF EXISTS yellow28_order;
CREATE TABLE yellow28_order
(
	id mediumint unsigned not null auto_increment comment 'id',
	member_id mediumint unsigned not null comment '会员的ID',
	addtime datetime not null comment '下单时间',
	shr_name varchar(30) not null comment '收货人姓名',
	shr_province varchar(30) not null comment '收货人省',
	shr_city varchar(30) not null comment '收货人市',
	shr_area varchar(30) not null comment '收货人地区',
	shr_address varchar(30) not null comment '收货人详细地址',
	shr_phone varchar(30) not null comment '收货人手机',
	pay_status tinyint unsigned not null default '0' comment '支付状态,0:未支付 1：已支付',
	post_status tinyint unsigned not null default '0' comment '发货状态， 0：未发货， 1：已发化 2：已收货',
	order_status tinyint unsigned not null default '0' comment '定单状态 0：未确认 1：已确认 2：已完成 3.申请退货 4.退货成功',
	post_method varchar(30) not null default '' comment '发货方式',
	pay_method varchar(30) not null default '' comment '支付方式',
	total_price decimal(10,2) not null default '0.00' comment '定单总价',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '定单基本信息';

DROP TABLE IF EXISTS yellow28_order_goods;
CREATE TABLE yellow28_order_goods
(
	id mediumint unsigned not null auto_increment comment 'id',
	member_id mediumint unsigned not null comment '会员的ID',
	order_id mediumint unsigned not null comment '定单的ID',
	goods_id mediumint unsigned not null comment '商品的ID',
	goodsattr_id varchar(150) not null default '' comment '商品属性ID',
	price decimal(10,2) not null default '0.00' comment '商品价格',
	goods_number int unsigned not null default '1' comment '购买的数量',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '定单商品';

