
<?php
   function navShow($page, $title)
    {
        $HTML = "<div class=\"ui secondary pointing menu fixed mbl tit\"><div class=\"ui container\">
        <div class=\"item fonts\"> ".$title." </div>";
        $vala = ($page == "index"?"active":"linkr");
        $HTML = $HTML . "<a class=\"item ".$vala."\" href=\" index.php \" >"."首页"."</a>";
        $vala = ($page == "exam"?"active":"linkr");
        $HTML = $HTML . "<a class=\"item ".$vala."\" href=\" exam.php \" >"."考试详情"."</a>";
        $vala = ($page == "exam-d"?"active":"linkr");
        $HTML = $HTML . "<a class=\"item ".$vala."\" href=\" exam-detail.php \" >"."考试分析"."</a>";
        $vala = ($page == "exam-wrong"?"active":"linkr");
        $HTML = $HTML . "<a class=\"item ".$vala."\" href=\" wrong.php \" >"."错题分析"."</a>";
        $vala = ($page == "exam-trend"?"active":"linkr");
        $HTML = $HTML . "<a class=\"item ".$vala."\" href=\" trend.php \" >"."趋势分析"."</a>";
        $vala = ($page == "about"?"active":"linkr");
        $HTML = $HTML . "<a class=\"item ".$vala."\" href=\" main.php \" >"."关于项目"."</a>";
        $HTML = $HTML . "<div class=\"right menu\">
            <a class=\"ui item linkr\" onclick=\"logout()\">
              Logout
            </a>
          </div></div></div></div>";
          $HTML = $HTML . "<script>function logout(){document.cookie=\"hfs-session-id=qwq; Max-Age=-1; Domain=.smallfang.fun; Path=/; SameSite=None; Secure\"; location.reload();}</script>";
            echo $HTML;
    }
?>