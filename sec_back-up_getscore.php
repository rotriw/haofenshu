<? include("model/header.php") ?>
<body>
    <? include("model/nav.php") ?>
    <? navShow("exam", "Haofenshu") ?>
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
    <div class="ui modal">
      <i class="close icon"></i>
      <div class="header">
        关于获取成绩
      </div>
      <div class="content">
        <div class="description">
          <div class="ui header"></div>
          <p>我们根据HFS数据，进行处理。请注意！您选择对方成绩如果有小数是暂时不可能计算的，对于满分>100分的考试也是不精准的！！！但最终成绩应该与实际分数差距控制在10分以内</p>
          <p>请注意，使用该工具时，对方会收到"PK"信息</p>
          <p>而且，手里没有非VIP账号，无法模拟。</p>
          <p>HFS有相关PK次数限制。请珍惜</p>
        </div>
      </div>
      <div class="actions">
        <div class="ui positive right labeled icon button">
          OK
          <i class="checkmark icon"></i>
        </div>
      </div>
    </div>
    <div class="ui container main">
        <div id="titles" class="titles">
            <h1>考试</h1>
        </div>
        <button class="ui labeled icon button primary" onclick="getUsers()">
          <i class="redo icon"></i>
          刷新列表
        </button>
        
        <button class="ui labeled icon button brown" onclick="$('.ui.modal').modal('show');">
          <i class="help icon"></i>
          这是吮磨
        </button>
        
            <!--<button class="ui button primary" onclick="change()">切换隐藏状态</button>-->
        <code id="rmessage"></code>
        <div id="users" class="spaces">
            <div class="ui card totals"><div class="content">
            <div class="ui form">
              <div class="field">
                  <label>选择用户</label>
                  <div class="ui selection dropdown">
                      <input type="hidden" name="gender">
                      <i class="dropdown icon"></i>
                      <div class="default text">选择同学</div>
                      <div class="menu" id="test">
                      </div>
                  </div>
              </div></div>
            </div>
            <button class="ui button primary" onclick="view()">查看</button>
            </div>
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
        function getUsers()
        {
            //console.log(getCookie('hfs-session-id'));
            document.getElementById("rmessage").innerText = "Loading...";
            $.ajax({
                url: "https://jump.hfs.lzx.smallfang.fun/v2/exam/"+<?php echo $_GET["id"] ?>+"/class-students-info?withPkInfo=true",
                dataType: 'json',
                method: 'get', 
                xhrFields: { withCredentials: true },
                success: function(res) {
                    console.log(res);
                    document.getElementById("rmessage").innerText = res.msg;
                    var _len = res.data.length;
                    var _i = 0;
                    var html = "";
                    //<div class="item" data-value="1">Male</div>
                    for (_i = 0; _i < _len; _i ++ )
                    {
                        html += "<div class='item' data-value='"+res.data[_i].id+"'>"+res.data[_i].name+"</div>";
                    }
                    document.getElementById("test").innerHTML = html;
                    $('.selection.dropdown')
  .dropdown()
;
                }
            });
        }
        
        function change()
        {
            $.ajax({
                url: "https://jump.hfs.lzx.smallfang.fun/v2/exam/"+<?php echo $_GET["id"] ?>+"/comparison/"+"switch",
                dataType: 'json',
                method: 'post', 
                data: {"status":2},
                xhrFields: { withCredentials: true },
                success: function(res) {
                    document.getElementById("rmessage").innerText = "更改状态成功";
                }
            });
        }
        function view()
        {
            var userID = $('.selection.dropdown').dropdown('get value');
            $.ajax({
                url: "https://jump.hfs.lzx.smallfang.fun/v2/exam/"+<?php echo $_GET["id"] ?>+"/students/"+userID+"/comparison",
                dataType: 'json',
                method: 'post', 
                data: {"examId":"<?php echo $_GET["id"] ?>","payerType":5,"studentId":userID},
                xhrFields: { withCredentials: true },
                success: function(res) {
                    var html = "学科. - 您的成绩 - 对方成绩 - 差距<br>";
                    var _len = res.data.subjects.length;
                    var uS = 0, rS = 0;
                    for (var _i = 0; _i < _len; _i ++ )
                    {
                        uS += res.data.subjects[_i].myRatio;
                        rS += res.data.subjects[_i].targetRatio;
                        if (res.data.subjects[_i].myRatio >= res.data.subjects[_i].targetRatio)
                        {
                            html += "<font style='color:green'>";
                        }
                        else
                        {
                            html += "<font style='color:red'>";
                        }
                        html += "<strong>" + res.data.subjects[_i].subject + "</strong>";
                        html += "</font>";
                        html += " - " + res.data.subjects[_i].myRatio + " - " + res.data.subjects[_i].targetRatio;
                        
                        if (res.data.subjects[_i].myRatio >= res.data.subjects[_i].targetRatio)
                        {
                            html += "<font style='color:green'> +";
                        }
                        else
                        {
                            html += "<font style='color:red'> ";
                        }
                        html += res.data.subjects[_i].myRatio - res.data.subjects[_i].targetRatio;
                        html += "</font>";
                        html +=  "<br>";
                    }
                    if (uS >= rS)
                        {
                            html += "<font style='color:green'>";
                        }
                        else
                        {
                            html += "<font style='color:red'> ";
                        }
                    html += "<strong>总科</strong></font>";
                    html += " - " + uS + " - " + rS ;
                    if (uS > rS)
                        {
                            html += "<font style='color:green'> +";
                        }
                        else
                        {
                            html += "<font style='color:red'> ";
                        }
                        html += uS - rS;
                    html += "<br>";
                    document.getElementById("shows").innerHTML = makeCard("Data", html, "nothing", " totals");
                }
            });
        }
        function calcData()
        {
            getRanks();
        }
        getUsers();
        $('.selection.dropdown')
  .dropdown()
;
    </script>
    <? include ("model/footer.php") ?>
    
</body>