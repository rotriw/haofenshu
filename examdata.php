<? include("model/header.php") ?>
<body>
    <? include("model/nav.php") ?>
    <? navShow("exam", "Haofenshu") ?>
    <?php if (!isset($_GET["id"]))
    {
    ?>
    <div class="ui container main">
        <div class="ui action input">
          <input type="text" placeholder="Test ID..." id='testId'></input>
          <button class="ui right labeled icon button primary" onclick=" window.location.href = '/examdata?id=' + document.getElementById('testId').innerText;">前往
          <i class="angle right icon"></i></button>
        </div>
        <code id="rmessage"></code>
        <div id="shows" class="spaces">
        </div>
    </div>
    <?php } else { ?>
    <div class="ui container main">
        <div id="titles" class="titles">
            <h1>Loading..</h1>
        </div>
        <button class="ui labeled icon button primary" onclick="refresh()">
          <i class="redo icon"></i>
          刷新考试信息
        </button>
        
        <button class="ui labeled icon button primary" onclick="onlyError()">
          <i class="ban icon" id="shower"></i>
          是否仅显示错题
        </button>
        
         <button class="ui labeled icon button brown" onclick="$('.coupled.modal')
  .modal({
    allowMultiple: true
  })
;
// open second modal on first modal buttons
$('.second.modal')
  .modal('attach events', '.first.modal .button.ys')
;
$('.third.modal')
  .modal('attach events', '.first.modal .button.helps')
;
$('.third.modal')
  .modal('attach events', '.fourth.modal .button.helps')
;
$('.fourth.modal')
  .modal('attach events', '.first.modal .button.logicset')
;
// show first immediately
$('.first.modal')
  .modal('show')
;">
          <i class="filter icon" id=""></i>
          筛选
        </button>
        <code id="rmessage"></code>
        <div id="shows" class="spaces">
        </div>
        <br>
        <div id="datas" class="spaces">
            
        </div>
    </div>
      <div class="ui first coupled modal">
    <div class="header">
      筛选
    </div>
    <div class="image content">
      <div class="description" id="slist2">
        功能暂未完成。<br>
      </div>
    </div>
    <div class="actions">
      <div class="ui brown button" onclick="addNewC()">新增一个新的筛选条件</div>
      <div class="ui brown button logicset">调整逻辑</div>
      <div class="ui purple button helps"><i class="help icon"></i>帮助</div>
      <div class="ui teal button ys2">调取预设</div>
      <div class="ui teal button ys">设为预设</div>
      <div class="ui primary button" onclick="runSX()">运行</div>
    </div>
  </div>
  <div class="ui small second coupled modal">
    <div class="header">
      Modal #2
    </div>
    <div class="content">
      <div class="description">
        <p>That's everything!</p>
      </div>
    </div>
    <div class="actions">
      <div class="ui approve button">
        <i class="checkmark icon"></i>
        All Done
      </div>
    </div>
  </div>
  <div class="ui small fourth coupled modal">
    <div class="header">
      逻辑调整
    </div>
    <div class="content">
      <div class="description">
        <p>如果您不知道做什么，请您先查看帮助。</p>
        <p>默认方式是&&模式</p>
      </div>
    </div>
    <div class="actions">
        
      <div class="ui button approve">
        放弃
      </div>
      <div class="ui purple button helps"><i class="help icon"></i>帮助</div>
      
      
      <div class="ui primary button right">
        <i class="list icon"></i>
        显示选择数据
      </div>
      <div class="ui primary approve button right">
        <i class="checkmark icon"></i>
        调整
      </div>
    </div>
  </div>
  <div class="ui small third coupled modal">
    <div class="header">
      Help
    </div>
    <div class="content">
      <div class="description">
        <p>That's everything!</p>
      </div>
    </div>
    <div class="actions">
      <div class="ui approve button">
        <i class="checkmark icon"></i>
        All Done
      </div>
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
        var _Li = 0;
        
        function runSX()
        {
            alert("sb人正在写。");
            var tests = "";
            for (var i = 1; i <= _Li; i ++ )
            {
                if (document.getElementById("testt-"+i).innerHTML == "")
                {
                    continue;
                }
                else
                {
                    tests += "qwq";
                }
            }
            console.log(tests);
        }
        
        function closes(ids)
        {
            document.getElementById("testt-"+ids).innerHTML = "";
        }
        
        function newList(ids)
        {
            var _res =  "<div id='testt-"+ids+"' class='ex-2'><button onclick='closes("+ids+")' class='ui button red'><i class='times icon'></i></button>";  
            _res += "<div class='ui selection dropdown a id-"+ids+"'><input type='hidden' name='选择'><i class='dropdown icon'></i><div class='default text'>选择项目</div><div class='scrollhint menu'><div class='item' data-value='0'>班级正确率</div><div class='item' data-value='1'>年级正确率</div><div class='item' data-value='2'>大题分类</div></div></div> &nbsp;&nbsp;";
            _res += "<div class='ui selection dropdown b id-"+ids+"'><input type='hidden' name='选择'><i class='dropdown icon'></i><div class='default text'>选择方式</div><div class='scrollhint menu'><div class='item' data-value='0'>大于</div><div class='item' data-value='1'>等于</div><div class='item' data-value='2'>小于</div></div></div>&nbsp;&nbsp;";
            _res += "<div class='ui input'><input type='text' placeholder='数据' id=put"+ids+"></div>";
            _res += "&nbsp;&nbsp;ID = " + ids;
            _res += "</div>";
			
            return _res;
        }
        
        function addNewC()
        {

            _Li ++;

            document.getElementById("slist2").innerHTML += newList(_Li) + "<br>";
            for (var __i = 1; __i <= _Li; __i ++ )
            {
                $('.selection.dropdown.a.id-'+__i).dropdown();
                $('.selection.dropdown.b.id-'+__i).dropdown();
            }
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
                            html += "<img  src='";
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
                            html += "<img style='width: inherit !important;' src='";
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
                            html += "<img style='width: inherit;' src='";
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