# 打卡计时器（后端）

#### 介绍
本项目为学习与研究项目，通过设计与实现一款桌面计时器软件，实现类似钉钉的考勤打卡功能，有助于提高学习效率。主要功能包括：登录注销、用户信息设置、自动识别 WIFI 网络、定时更新计时信息、公告展示、个人在线时长统计、每周计时排名统计等。

#### 截图

![20210320003908.png](public/static/img/screenshot/20210320003908.png)

![20210320003842.png](public/static/img/screenshot/20210320003842.png)

![20210320003927.png](public/static/img/screenshot/20210320003927.png)

![20210320003939.png](public/static/img/screenshot/20210320003939.png)

![20210320004034.png](public/static/img/screenshot/20210320004034.png)

![20210320004046.png](public/static/img/screenshot/20210320004046.png)

![20210320004102.png](public/static/img/screenshot/20210320004102.png)

![20210320004129.png](public/static/img/screenshot/20210320004129.png)

#### 技术栈
MySQL+PHP+ThinkPHP5

1. 后台数据处理采用基于 PHP 的 ThinkPHP5 框架开发
2. 计时信息保存在 MySQL 数据库上

#### 功能特性

1. 用户登录、注册、注销，其中登录的时候可以选择记住密码以及自动登录
2. 登录之后可到用户信息设置界面完善或修改用户信息，方便统计时长排名
3. 支持定时匹配 WIFI 的物理地址，如若不匹配，则自动停止打卡计时
4. 打卡计时信息首先会加密保存在本地数据文件，之后会定时同步更新服务器计时信息
5. 使用柱状图表的方式统计个人的本周在线时长，方便直观地显示每天的学习时间
6. 每一周都会统计所有人的计时排名，根据计时时长使用列表的形式降序排列
7. 打卡计时器只能在后台运行一个，即无法重复打开多个计时器，确保计时的准确性

#### 使用说明

1. 可在 application/database.php 文件中修改数据库连接信息
2. WIFI 的动态 Mac 物理地址列表保存在 application/admin/controller/Index.php 文件中
3. 此项目为 PHP 项目，需要配置 PHP5 或者 PHP7 运行环境才能正常使用
