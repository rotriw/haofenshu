<? include("model/header.php") ?>
<body>
<? include("model/nav.php") ?>
<? navShow("index", "Haofenshu") ?>
<div class="ui container main">
    <button class="ui labeled icon button primary" onclick="addNew()">
        <i class="running icon"></i>
        登陆
    </button>
     <button class="ui labeled icon button primary" onclick="$('.ui.modal').modal('show');">
          <i class="info icon"></i>
          写给你的话（Update 2023-07）
        </button>
        
    <div class="ui action input">
         <div class="ui modal">
      <i class="close icon"></i>
      <div class="header">
        一封信
      </div>
      <div class="content">
        <div class="description">
          <div class="ui header"></div>
          <p>现如今，跟该项目有关的开发者已经毕业，并可能不再使用好分数，无法再继续维护。</p>
          <p>若您有意愿继续维护该项目请联系邮箱 smallfang@rotriw.tech 或者加入tg群 <a href='https://t.me/+Ocm3OMi3aYRhZjVl'>here</a> 随时欢迎！</p>
          <p>想到这个项目刚开始时还不知道如何做跳板。通过这个项目学习了通过手机抓包等一系列技术，收获良多。突然想到写这个项目其实是在初三上半学期，刚刚退竞却又想写点东西，然后又考试，发现原本的好分数前端写的太烂了。然后就打算自己写一个（虽说这个写的也不怎么好看。后来发现好分数上线了PK功能，这个功能非常有意思，而且我感觉可以看到对手的成绩，然后竟然手机抓包发现直接给百分比，当时真的非常兴奋，赶紧把对战功能写完了。另外就是通过各种方式计算排名...这个项目也承载了很多有趣的事，如果可以，也希望有人也能通过这个项目获得到独特的一段经历。祝愿大家未来可期。</p>
          <p>
            项目有机会会再被维护。-2023.07.07
          </p>
        <p style="color: #5BCEFA;"></p>
        <p style="color: #F5A9B8;"></p>
        <p style="color: #FFFFFF;"></p>
        </div>
      </div>
      <div class="actions">
          <a href='https://t.me/+Ocm3OMi3aYRhZjVl'><div class="ui teal button ys" style="background-color: #F5A9B8;">Group Link</div></a>
        <div class="ui positive right labeled icon button">
          OK
          
          <i class="checkmark icon"></i>
        </div>
      </div>
    </div>
        <input type="text" id="testId" placeholder="Test ID...">
        <button class="ui button" onclick="goTest();"><font style="vertical-align: inherit;"><font
                        style="vertical-align: inherit;">前往</font></font></button>
    </div>
    <button class="ui labeled icon button primary" onclick="refresh()">
        <i class="redo icon"></i>
        刷新考试信息
    </button>
    
    <code id="rmessage"></code>
    <div id="shows" class="spaces">
    </div>
</div>
<script>
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i].trim();
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    }

    function goTest() {
        window.location.href = "/exam?id=" + document.getElementById("testId").innerText;
    }

    function makeCard(title, bodys, extraCode) {
        var res = "";
        var calcHeight = 0.9;
        if (title.length > 10) {
            calcHeight = 0.9;
        }
        res = "<div class='ui card'><div class='content'><div class='header' style='font-size:" + calcHeight + "em;'>";
        res += title + "</div></div><div class='content'>" + bodys + "</div>";
        res += "<div class='extra content'>" + extraCode + "</div></div>";
        return res;
    }

    function getScoreHtml(total, score) {
        var av = score / total;
        var rgbs = [0, 0, 0];
        console.log(av);
        if (av <= 0.60) {
            rgbs[0] = 255;
            rgbs[1] = 0;
            rgbs[2] = 0;
        } else if (av <= 0.75) {
            rgbs[0] = 244;
            rgbs[1] = 176 + (0.75 - av) * 10;
            rgbs[2] = 132;
        } else {
            rgbs[0] = 198 - (av - 0.75) * 30;
            rgbs[1] = 239 - (av - 0.75) * 30;
            rgbs[2] = 206 - (av - 0.75) * 30;
        }
        return "<font style='color:rgb(" + rgbs[0] + "," + rgbs[1] + "," + rgbs[2] + ")'>" + score + "</font>";
    }

    function refresh() {
        //console.log(getCookie('hfs-session-id'));
        document.getElementById("rmessage").innerText = "Loading..";
        $.ajax({
            url: "https://jump.hfs.lzx.smallfang.fun/v3/exam/list?start=-1",
            dataType: 'json',
            method: 'get',
            xhrFields: {withCredentials: true},
            success: function (res) {
                document.getElementById("rmessage").innerText = res.msg;
                console.log(res);
                var Datas = res.data.list;
                console.log(Datas);
                var DataNumber = res.data.totalCount;
                var htmls = "";
                var times = 0;
                for (var i = 0; i < DataNumber; i++) {
                    if (Datas[i] == null) {
                        break;
                    }
                    times++;
                    if (times == 1) {
                        htmls += "<div class='HENG'>";
                    }
                    var links = "<a href='/exam.php?id=";
                    links += Datas[i].examId;
                    links += "'><button class='ui button'>前往考试</button></a>";
                    console.log(Datas[i].examId);
                    var mainTest = "";
                    mainTest = getScoreHtml(Datas[i].manfen, Datas[i].score) + "/" + Datas[i].manfen;
                    htmls += makeCard(Datas[i].name, mainTest, links);
                    if (times == 3) {
                        htmls += "</div>";
                        times = 0;
                    }
                }
                document.getElementById("shows").innerHTML = htmls;
                document.getElementById("rmessage").innerText = res.msg;

            }
        });
    }

    refresh();

    function addNew() {
        Swal.mixin({
            input: 'text',
            confirmButtonText: 'Next &rarr;',
            showCancelButton: true,
            progressSteps: ['1', '2']
        }).queue([
            {
                title: 'Username',
                text: 'Type your Username.'
            },
            {
                title: 'password',
                text: 'Type your password.',
                input: 'password'
            },
        ]).then((result) => {
            if (result.value) {
                Swal.fire({
                    title: 'All done!',
                    html:
                        'Confirm your login status： <pre><code id="logincheck">' +
                        "登陆检测中...." +
                        '</code></pre>',
                    confirmButtonText: 'Next'
                })
                $.ajax({
                    url: "https://jump.hfs.lzx.smallfang.fun/v2/users/sessions",
                    dataType: 'json',
                    method: 'post',
                    data: {
                        loginName: result.value[0],
                        password: result.value[1],
                        rememberMe: 1,
                        roleType: 1,
                    },
                    xhrFields: {withCredentials: true},
                    //console.log(req);
                    success: function (data, status, req) {
                        if (data.msg == "登录成功") {
                            document.getElementById("logincheck").innerText = "Login Successful!";
                            //  document.cookie="hfs-session-id="+data.data.fdToken+";domain=hfs.lzx.smallfang.fun;";
                            console.log(data.data.fdToken);
                            refresh();
                        } else {
                            document.getElementById("logincheck").innerText = "Login Fail";
                        }
                    }
                });

            }
        })
    }
</script>
<? include("model/footer.php") ?>
</body>