# set namss utf8;
# use php28;
# DROP TABLE php28_text1 IF EXECT;
# CREATE TABLE php28_text1(
# id int NOT NULL auto_increment commit 'id',
# name varchar(30) not null default '' commit 'name',
# secret char(30) not null defauit '' commit 'secret',
# fun_id mediumint not null default 0 commit 'fun id',
# fun_level tinyint not null default 0 commit 'fun level',
# fun_type enum(1,2) not null default 1 commit 'fun type',
# primary key(id),
# )engine=MASIAM default charset=utf8;

# DROP TABLE IF EXECT php28_text2;
# CREATE TABLE php28_text2(
# id mediumint not null auto_increment commit 'id',
# fun_id mediumint not null default 0 commit 'fun id',
# foreign key(fun_id) references php28_text1(fun_id) on delete cascade,
# primary key (id),
# )engine=InnoDB default charset=utf8;

set names utf8;
use php28;
DROP TABLE IF EXISTS php28_text1;
CREATE TABLE php28_text1(
id int unsigned not null auto_increment comment 'id',
name varchar(30) not null comment 'name',
name2 varchar(32) not null comment 'name2',
secret char(30) not null comment 'secret',
fun_id mediumint unsigned not null comment 'fun id',
fun_level tinyint unsigned not null default 1 comment 'fun level',
fun_type enum('1','2') not null default '1' comment 'fun type',
primary key (id)
)engine=InnoDB default charset=utf8 comment 'text1';

DROP TABLE IF EXISTS php28_text2;
CREATE TABLE php28_text2(
id mediumint unsigned not null auto_increment comment 'id',
fun_id int unsigned not null comment 'fun id',
foreign key (fun_id) references php28_text1 (id) on delete cascade,
primary key (id)
)engine=InnoDB default charset=utf8 comment 'text2';
INSERT INTO php28_text1 VALUES(1,'名字','名字二','mima',1,1,'1');
