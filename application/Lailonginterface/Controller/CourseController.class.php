<?php
namespace Lailonginterface\Controller;

use Lailonginterface\Controller\PublicController;

class CourseController extends PublicController
{

    /**
     * 获取排课计划
     */
    public function plan()
    {
        $token = $_REQUEST['token'];
        $userid = $this->checkAccess($token);
        $date = date('Y-m-d H:i:s', time());
        // 当前条数
        $pagesize = $_REQUEST['pagesize'];
        // 当前页数
        $pagec = $_REQUEST['pagec'];
        $start = ($pagec - 1) * $pagesize;
        $c = M('Course')->where("start_time >='$date'")
            ->distinct(true)
            ->order("start_time asc")
            ->limit($start.','.$pagesize)
            ->select();
        $arr = array();
        if ($c) {
            foreach ($c as $k => $v) {
                $starttime = date("Y-m-d 00:00:00", strtotime($v[start_time]));
                $endtime = date("Y-m-d 23:59:59", strtotime($v[start_time]));
                $r = M('Course')->field("c.*,t.name as teacher")
                    ->table(C('DB_PREFIX') . "course as c")
                    ->join(C('DB_PREFIX') . "teacher as t on t.id = c.teacher_id", 'left')
                    ->where("c.start_time between '$starttime' and '$endtime'")
                    ->select();
                foreach ($r as $k2 => $v2) {
                    $r[$k2][picture] = __ROOT__ . '/data/upload/avatar/' . $v2[picture];
                    $r[$k2][cover] = __ROOT__ . '/data/upload/avatar/' . $v2[cover];
                }
                $stime = date("Y-m-d", strtotime($v[start_time]));
                $arr[$stime] = $r;
            }
            $rs = array();
            foreach ($arr as $k => $v) {
                $a = array();
                $a['time'] = $k;
                $b = array();
                foreach ($v as $key => $value) {
                    $b[] = $value;
                }
                $a['list'] = $b;
                $rs[] = $a;
            }
            $this->successLongResult($rs, "获取排课计划成功");
        } else {
            $this->errorResult("未获取到排课计划");
        }
    }

    /**
     * 获取课程详情
     */
    public function coursedetail()
    {
        $token = $_REQUEST['token'];
        $user = $this->checkAccess($token);
        $courseid = $_REQUEST['courseid'];
        if (empty($courseid) || $courseid == 0) {
            $this->emptyResult();
        }
        $c = M('Course')->field("c.*,h.content as h5_content")->table(C('DB_PREFIX').'course as c')->join(C('DB_PREFIX')."h5 as h on h.id = c.h5_id",'left')->where("c.id = $courseid")->find();
        if (! $c) {
            $this->errorResult("未获取到课程详情");
        }
        $c[picture] = __ROOT__ . '/data/upload/avatar/' . $c[picture];
        $c[cover] = __ROOT__ . '/data/upload/avatar/' . $c[cover];
        $res = M('teacher')->where("id = $c[teacher_id]")->find();
        $res[avatar] = __ROOT__ . '/data/upload/avatar/' . $res[avatar];
        $c[teacherdata] = $res;
        $classroom = M('classroom')->where("id = $c[classroom_id]")->find();
        $c[classroomdata] = $classroom;
        $bool = 0;
        if (M('collection')->where("course_id = '$courseid' and user_id = '$user'")->find()) {
            $bool = 1;
        }
        $c[is_collect] = $bool;
        if ($c) {
            $this->successLongResult($c, "获取课程详情成功");
        }
    }

    /**
     * 获取讲师详情
     */
    public function lecturer()
    {
        $token = $_REQUEST['token'];
        $this->checkAccess($token);
        $teacher_id = $_REQUEST['teacher_id'];
        /* $c=M('Course')->field("teacher_id")->where("id = $courseid")->find(); */
        if (empty($teacher_id) || $teacher_id == 0) {
            $this->emptyResult();
        }
        $res = M('teacher')->where("id = $teacher_id")->find();
        $res[avatar] = __ROOT__ . '/data/upload/avatar/' . $res[avatar];
        if ($res) {
            $this->successLongResult($res, "获取讲师详情成功");
        } else {
            $this->errorResult("未获取到讲师详情");
        }
    }

    /**
     * 课程收藏
     */
    public function collection()
    {
        $token = $_REQUEST['token'];
        $user = $this->checkAccess($token);
        $courseid = $_REQUEST['courseid'];
        if ($courseid == 0) {
            $this->errorResult("操作非法");
        }
        if (M('collection')->where("course_id = '$courseid' and user_id = '$user'")->find()) {
            $this->errorResult('已收藏过了');
        }
        $data = array(
            'course_id' => $courseid,
            'user_id' => $user,
            'createtime' => date('Y-m-d H:i:s', time())
        );
        if (M('collection')->add($data)) {
            $this->successShortResult('收藏完成');
        } else {
            $this->errorResult("收藏失败");
        }
    }

    /**
     * 取消收藏
     */
    function cancelcollection()
    {
        $token = $_REQUEST['token'];
        $user = $this->checkAccess($token);
        $courseid = $_REQUEST['courseid'];
        if ($courseid == 0) {
            $this->errorResult("操作非法");
        }
        if (M('collection')->where("course_id = '$courseid' and user_id = '$user'")->delete()) {
            $this->successShortResult('取消收藏成功');
        } else {
            $this->errorResult("取消收藏失败");
        }
    }

    /**
     * 我的收藏
     */
    public function mycollection()
    {
        $token = $_REQUEST['token'];
        $user = $this->checkAccess($token);
        // 当前条数
        $pagesize = $_REQUEST['pagesize'];
        // 当前页数
        $pagec = $_REQUEST['pagec'];
        $start = ($pagec - 1) * $pagesize;
        $field = "co.title,co.picture,co.start_time,t.name as teacher,c.course_id,co.cover";
        $res = M('collection')->table(C('DB_PREFIX') . "collection as c")
            ->field($field)
            ->join(C('DB_PREFIX') . "course as co on co.id =c.course_id", 'left')
            ->join(C('DB_PREFIX') . "teacher as t on t.id =co.teacher_id", 'left')
            ->where("c.user_id = $user")
            ->limit($start . ',' . $pagesize)
            ->order("c.createtime desc")
            ->select();
        foreach ($res as $r => $s) {
            $res[$r][picture] = __ROOT__ . '/data/upload/avatar/' . $s[picture];
            $res[$r][cover] = __ROOT__ . '/data/upload/avatar/' . $s[cover];
        }
        if ($res) {
            $msg = "获取我的收藏成功";
            $this->successLongResult($res, $msg);
        } else {
            $result = "获取我的收藏失败";
            $this->errorResult($result);
        }
    }
}