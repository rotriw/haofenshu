<? include("model/header.php") ?>
<body>
    <? include("model/nav.php") ?>
    <? navShow("exam-d", "Haofenshu") ?>
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
            <h1>学科数据统计</h1>
        </div>
        <button class="ui labeled icon button primary" onclick="refresh()">
          <i class="redo icon"></i>
          刷新考试信息
        </button>
        
        <button class="ui labeled icon button primary" onclick="onlyError()">
          <i class="ban icon" id="shower"></i>
          是否仅显示错题
        </button>
        <code id="rmessage"></code>
        <div id="shows" class="spaces">
        </div>
        <br>
        <div id="datas" class="spaces">
            
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
                    var totalMarkH = "<div class='ui buttons'>";
                    var len = res.data.papers.length;
                    var _i;
                    for (_i = 0; _i < len; _i ++ )
                    {
                        console.log(res.data.papers[_i].paperId);
                        totalMarkH += "<button class='ui button' onclick='getPaper(";
                        totalMarkH += '\"';
                        totalMarkH += res.data.papers[_i].paperId;
                        totalMarkH += '\",\"'+res.data.papers[_i].manfen+'\",\"'+res.data.papers[_i].score+'\",'+_i;
                        totalMarkH += ")' id=link-";
                        totalMarkH += _i + ">";
                        totalMarkH += res.data.papers[_i].subject;
                        totalMarkH += "</button>";
                    }
                    var html = totalMarkH;
                    document.getElementById("rmessage").innerText = res.msg;
                    document.getElementById("shows").innerHTML = html;
                }
            });
        }
        var errors = false, pid = "", mf = "", sc = "", tss = "";
        function onlyError()
        {
            errors == true ? errors = false : errors = true;
            if (errors == true)
            {
                document.getElementById("shower").className = "check icon";
            }
            else
            {
                document.getElementById("shower").className = "ban icon";
            }
            if (pid != "")
                getPaper(pid, mf, sc, tss);
        }
        
        function getPaper(paperid,manfen,score, ts)
        {
            var tl = document.getElementsByClassName("olive").length;
            var ti_;
            tss = ts;
            console.log(document.getElementsByClassName("olive"));
            for (ti_ = 0; ti_ < tl; ti_ ++ )
            {
                document.getElementsByClassName("olive")[ti_].classList.remove("olive");
            }
            document.getElementById("link-"+ts).classList.add("olive");
            pid = paperid, mf = manfen, sc = score;
            console.log("https://jump.hfs.lzx.smallfang.fun/v3/exam/"+<?php echo $_GET["id"] ?>+"/papers/"+paperid+"/question-detail");
            $.ajax({
                url: "https://jump.hfs.lzx.smallfang.fun/v3/exam/"+<?php echo $_GET["id"] ?>+"/papers/"+paperid+"/question-detail",
                dataType: 'json',
                method: 'get', 
                xhrFields: { withCredentials: true },
                success: function(res) {
                    console.log(res);
                    var html = "您本次得分为:<strong>"+score + "/" + manfen + "</strong>  得分率:<strong>"+ (score / manfen * 100).toFixed(2) +"% </strong><br>";
                    html += "<br><div class='ui styled accordion totals'>";
                    var _i;
                    var len = res.data.questionList.length;
                    for (_i = 0; _i < len; _i ++ )
                    {
                        if (errors == true && res.data.questionList[_i].score == res.data.questionList[_i].manfen)
                            continue;
                        html += "<div class='";
                        html += "title ";
                        if (res.data.questionList[_i].score == res.data.questionList[_i].manfen)
                        {
                            html += "rights";
                        }
                        else if(res.data.questionList[_i].score == 0)
                        {
                            html += "wrongs";
                        }
                        else
                        {
                            html += "somewrong";
                        }
                        html += "'><div class='ui grid'><div class='three wide column'><i class='dropdown icon'></i>";
                        html += (_i + 1) + "</div><div class='three wide column'>" + res.data.questionList[_i].name + "</div>";
                        html += "<div class='three wide column'>得分:" + res.data.questionList[_i].score + "/" + res.data.questionList[_i].manfen + "";
                        html += "</div>"
                        html += "<div class='three wide column'>";
                        html += "You:";
                        var yours = (res.data.questionList[_i].score/res.data.questionList[_i].manfen*100).toFixed(2);
                        html += yours;
                        html += "%/";
                        html += "Class:" + res.data.questionList[_i].classScoreRate;
                        html += "%/Grade:" + res.data.questionList[_i].gradeScoreRate+"%";
                        html += "</div>";
                        html += "</div></div>";
                        
                        html += "<div class='content'><p class='transition hidden'><h2>Problem</h2>";
                        var _j = 0;
                        var len_2 = res.data.questionList[_i].pictures.length;
                        for (_j = 0; _j < len_2; _j ++)
                        {
                            html += "<img src='";
                            html += res.data.questionList[_i].pictures[_j];
                            html += "' /img>";
                        }
                        html += "<h2> Your answer </h2>";
                        var len_2 = res.data.questionList[_i].myAnswerPics.length;
                        if (len_2 == 0)
                        {
                            html += res.data.questionList[_i].myAnswer;
                        }
                        for (_j = 0; _j < len_2; _j ++)
                        {
                            html += "<img src='";
                            html +=  res.data.questionList[_i].myAnswerPics[_j];
                            html += "' /img>";
                        }
                        html += "<h2> Right answer </h2>";
                        var len_2 = res.data.questionList[_i].xbAnswerPics.length;
                        if (len_2 == 0)
                        {
                            html += res.data.questionList[_i].answer;
                        }
                        for (_j = 0; _j < len_2; _j ++)
                        {
                            html += "<img style='width: 100%' src='";
                            html +=  res.data.questionList[_i].xbAnswerPics[_j];
                            html += "' /img>";
                        }
                        html += "</p></div>";
                    }
                    html += "</div>";
                    document.getElementById("rmessage").innerText = res.msg;
                    document.getElementById("datas").innerHTML = html;
           $('.ui.accordion').accordion();
                }
            });
        }
        refresh();
        $(document).ready(function(){
           $('.ui.accordion').accordion();
        });
    </script>
    <? include ("model/footer.php") ?>
    
</body>