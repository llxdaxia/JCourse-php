# JCourse 数据库设计

##User

 - id
 - name
 - password
 - avatar 头像
 - gender  //0：男，1：女
 - sign
 - time

##j_course --- java课程表

 - id
 - cover //封面
 - title  //标题
 - subtitle  //副标题
 - content
 - star_num //点赞数
 - visit_num //浏览量
 
##j_video --- java视频
 
 - id
 - url
 - title
 - subtitle
 - cover

##j_course_relation --- java课程关系表

 - id
 - user_id
 - j_course_id
 - time
 
##follow_relation
 
 - id
 - follow_id
 - requester_id
 - time
 
##feedback
 
 - id 
 - content
 - relation
 - time

##comment

 - id
 - commenter_id  //评论者
 - object_id  //评论对象
 - content
 - bbs_id 
 - time

##bbs

 - id
 - author_id
 - title
 - content
 - pictures
 - time

# API

##注册

参数
 - name
 - password

Result

 - info
 
##登录

参数
 - name
 - password
 
Result

 - name
 - avatar
 - token
 - gender
 - intro
 
##文本课程列表

参数
 - page
 - pageNum //默认20
 
Result

 - id
 - title
 - subtitle
 - cover
 - content