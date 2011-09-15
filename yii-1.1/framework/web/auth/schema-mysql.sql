/**
 * Database schema required by CDbAuthManager.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @since 1.0
 */

drop table if exists `yii_auth_item`;
drop table if exists `yii_auth_itemchild`;
drop table if exists `yii_auth_assignment`;

create table `yii_auth_item`
(
   `name`                 varchar(64) not null,
   `type`                 integer not null,
   `description`          text,
   `bizrule`              text,
   `data`                 text,
   primary key (`name`)
) engine InnoDB;

create table `yii_auth_itemchild`
(
   `parent`               varchar(64) not null,
   `child`                varchar(64) not null,
   primary key (`parent`,`child`),
   foreign key (`parent`) references `yii_auth_item` (`name`) on delete cascade on update cascade,
   foreign key (`child`) references `yii_auth_item` (`name`) on delete cascade on update cascade
) engine InnoDB;

create table `yii_auth_assignment`
(
   `itemname`             varchar(64) not null,
   `userid`               varchar(64) not null,
   `bizrule`              text,
   `data`                 text,
   primary key (`itemname`,`userid`),
   foreign key (`itemname`) references `yii_auth_item` (`name`) on delete cascade on update cascade
) engine InnoDB;
