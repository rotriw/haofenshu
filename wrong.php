<? include("model/header.php") ?>
<body>
    <? include("model/nav.php") ?>
    <? navShow("exam-wrong", "Haofenshu") ?>
    <?php if (!isset($_GET["id"]))
    {
    ?>
    <div class="ui container main">
        <div class="ui action input">
          <input type="text" placeholder="Test ID...">
          <button class="ui right labeled icon button primary">前往
          <i class="angle right icon"></i></button>
        </div>
        <code id="rmessage"></code>
        <div id="shows" class="spaces">
        </div>
    </div>
    <?php } else { ?>
    <div class="ui container main">
        <div id="titles" class="titles">
            <h1>Writing now.</h1>
        </div>
        <button class="ui labeled icon button primary" onclick="refresh()">
          <i class="redo icon"></i>
          刷新考试信息
        </button>
        <button class="ui labeled icon button teal" onclick="window.location.href='examdata.php?id=<?php echo $_GET["id"]; ?>'">
          <i class="play icon"></i>
          前往试卷解析
        </button>
        <button class="ui labeled icon button purple" onclick="window.location.href='getscore.php?id=<?php echo $_GET["id"]; ?>'">
          <i class="certificate icon"></i>
          获取他人成绩
        </button>
        <button class="ui labeled icon button violet" onclick="calcData();">
          <i class="sticky note icon"></i>
          计算考试具体分析
        </button>
        <code id="rmessage"></code>
        <div id="extra" class="spaces">
        </div>
        <div id="shows" class="spaces">
        </div>
    </div>
    <?php } ?>
    <script>
        function getCookie(cname)
        {
          var name = cname + "=";
          var ca = document.cookie.split(';');
          for(var i=0; i<ca.length; i++) 
          {
            var c = ca[i].trim();
            if (c.indexOf(name)==0) return c.substring(name.length,c.length);
          }
          return "";
        }
        function makeCard(title, bodys, extraCode, classs)
        {
            var res = "";
            res = "<div class='ui card ";
            res += classs;
            res += "'><div class='content'><div class='header'>" + title + "</div></div><div class='content'>" + bodys + "</div>";
            if (extraCode != "nothing")
                res += "<div class='extra content'>" + extraCode + "</div>";
            res += "</div>";
            return res;
        }
        
        function getScoreHtml(total, score)
        {
            var av = score / total;
            var rgbs = [0,0,0];
            console.log(av);
            if (av <= 0.60)
            {
                rgbs[0] = 255;
                rgbs[1] = 0;
                rgbs[2] = 0;
            }
            else if (av <= 0.75)
            {
                rgbs[0] = 244;
                rgbs[1] = 176 + (0.75 - av) * 10;
                rgbs[2] = 132;
            }
            else
            {
                rgbs[0] = 198 - (av - 0.75) * 30;
                rgbs[1] = 239 - (av - 0.75) * 30;
                rgbs[2] = 206 - (av - 0.75) * 30; 
            }
            return "<font style='color:rgb("+rgbs[0]+","+rgbs[1]+","+rgbs[2]+")'>"+score+"</font>";
        }
        
        function getAnalyse()
        {
             $.ajax({
                url: "https://jump.hfs.lzx.smallfang.fun/v3/exam/"+<?php echo $_GET["id"] ?>+"/same-group-analysis",
                dataType: 'json',
                method: 'get', 
                xhrFields: { withCredentials: true },
                success: function(res) {
                    
                    var datas = [];
                    var _i = 0, _l = res.data.groups.length;
                    var peopleCount = 0;
                    for (_i = 0; _i < _l; _i ++ )
                    {
                        datas[_i] = new Array();
                        datas[_i]["score"] = res.data.groups[_i].min;
                        peopleCount += res.data.groups[_i].gradeStuNum;
                        datas[_i]["people"] = peopleCount;
                    }
                    var maxNuber = peopleCount;
                    const totalC = new G2.Chart({
                        container: 'totalScoreQ',
                        autoFit: true,
                        height: 200,
                        min: 0,
                        max: maxNuber + 100,
                        tickInterval: 100,
                        tickCount: 30,
                        renderer: 'svg'
                    });
                    totalC.data(datas);
                    totalC.scale('people', {
                        nice: true,
                        max: maxNuber+15,
                        tickInterval:20,
                    });
                    totalC.scale('score', {
                        nice: true,
                        
                        tickInterval:20,
                    });
                    totalC.tooltip({
  showMarkers: false
});
                    totalC.interaction('active-region');
                    totalC.line().position('score*people').label('people');
                    totalC.point().position('score*people');
                     totalC.render();
                    datas = [];
                    var _i = 0, _l = res.data.groups.length;
                    var peopleCount = 0;
                    for (_i = _l - 1; _i >= 0; _i -- )
                    {
                        datas[_i] = new Array();
                        datas[_i]["score"] = res.data.groups[_i].min;
                        peopleCount += res.data.groups[_i].gradeStuNum;
                        datas[_i]["people"] = peopleCount;
                    }
                    var maxNuber = peopleCount;
                    const totalH = new G2.Chart({
                        container: 'totalScoreH',
                        autoFit: true,
                        height: 200,
                        tickCount: 30,
                        renderer: 'svg'
                    });
                    console.log(maxNuber + 50);
                    totalH.data(datas);
                    totalH.scale('people', {
                        nice: true,
                        max: maxNuber+15,
                        tickInterval:20,
                    });
                    totalH.scale('score', {
                        nice: true,
                        
                        tickInterval:20,
                    });
                    totalH.tooltip({
  showMarkers: false
});
                    totalH.interaction('active-region');
                    totalH.line().position('score*people').label('people');
                    totalH.point().position('score*people');
                     totalH.render();
                }
             });
        }
        function getRanks()
        {
            console.log("write now");
            $.ajax({
                url: "https://jump.hfs.lzx.smallfang.fun/v3/exam/"+<?php echo $_GET["id"] ?>+"/same-group-analysis",
                dataType: 'json',
                method: 'get', 
                xhrFields: { withCredentials: true },
                success: function(resA) {
                    $.ajax({
                        url: "https://jump.hfs.lzx.smallfang.fun/v3/exam/"+<?php echo $_GET["id"] ?>+"/papers-analysis",
                        dataType: 'json',
                        method: 'get', 
                        xhrFields: { withCredentials: true },
                        success: function(paperR) {
                            console.log(resA);console.log(paperR);
                            var _i = 0, _l = resA.data.groups.length;
                            var peopleCount = 0;
                            var rankD = 0;
                            var _len2 = resA.data.myGradeIndex;
                            console.log(_len2);
                            for (_i = _l - 1; _i >= _len2+ 1; _i -- )
                            {
                                rankD = rankD + resA.data.groups[_i].gradeStuNum;
                                peopleCount += resA.data.groups[_i].gradeStuNum;
                            }
                            for (_i = _len2 ; _i >= 0; _i -- )
                            {
                                peopleCount += resA.data.groups[_i].gradeStuNum;
                            }
                            rankD += (resA.data.groups[_len2].gradeStuNum*((100-paperR.data.examSameGroupBeat)*0.01));
                            var extraMessage = "";
                            if(Math.ceil(rankD) != rankD)
                            {
                                extraMessage = " 精度损耗，排名可能在1-2名内波动。";
                                rankD = Math.ceil(rankD);
                            }
                            var html = makeCard("排名计算", rankD + "/" + peopleCount + extraMessage, "nothing", "ranksd totals");
                            document.getElementById("extra").innerHTML = html;
                        }
                    });
                }
            });
        }
        function refresh()
        {
            //console.log(getCookie('hfs-session-id'));
            document.getElementById("rmessage").innerText = "Loading...";
            $.ajax({
                url: "https://jump.hfs.lzx.smallfang.fun/v3/exam/"+<?php echo $_GET["id"] ?>+"/overview",
                dataType: 'json',
                method: 'get', 
                xhrFields: { withCredentials: true },
                success: function(res) {
                    console.log(res);
                    document.getElementById("titles").innerHTML = "<h1>" + res.data.name + "</h1>";
                    var totalMarkH = "<strong>总分</strong> " + getScoreHtml(res.data.manfen, res.data.score) + "/" + res.data.manfen + "<br />";
                    totalMarkH += "<table class='ui celled table'>";
                    totalMarkH += "<thead><tr><th>学科</th><th>班级</th><th>年级</th></tr></thead>";
                    totalMarkH += "<tbody>";
                    totalMarkH += "<tr><td data-label='学科'>总分</td>";
                    totalMarkH += "<th id='totals' data-label='班级'><center> " + res.data.classRankPart + "</center></th>"; 
                    totalMarkH += "<th id='totals' data-label='年级'><center> " + res.data.gradeRankPart + "<center></th>"; 
                    totalMarkH += "</tr>";
                    totalMarkH += "</tbody></table>";
                    var len = res.data.papers.length;
                    var _i;
                    for (_i = 0; _i < len; _i ++ )
                    {
                        totalMarkH += "<strong>" + res.data.papers[_i].subject + "</strong> 分数:" + getScoreHtml(res.data.papers[_i].manfen, res.data.papers[_i].score) + "/" + res.data.papers[_i].manfen + "<br />";
                    }
                    totalMarkH += "<br>";
                    totalMarkH += "</table>";
                    var html = makeCard("成绩总览", totalMarkH, "nothing", "totals");
                    html += makeCard("总分趋势图 - 前缀和", "<div id='totalScoreQ' class='totals'></div>", "nothing", "totals  pat");
                    html += makeCard("总分趋势图 - 后缀和", "<div id='totalScoreH' class='totals'></div>", "nothing", "totals  pat");
                    document.getElementById("rmessage").innerText = res.msg;
                    document.getElementById("shows").innerHTML = html;
                    getAnalyse();
                }
            });
        }
        function calcData()
        {
            
            getRanks();
        }
        refresh();
    </script>
    <? include ("model/footer.php") ?>
    
</body>