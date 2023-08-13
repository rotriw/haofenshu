<? include("model/header.php") ?>

<body>
	<? include("model/nav.php") ?>
	<? navShow("status", "Haofenshu") ?>
	<div class="ui container main" style="text-align: center;">
	   <div class="ui statistic">
          <div class="label">
            网站访问次数
          </div>
          <div class="value">
            <?php echo $newnum; ?>
          </div>
        </div>
        <br>
        <br>
         <span style="color: grey;size: 10px;">仅统计自2022/08/15日起的数据。</span>
    </div>
	<? include("model/footer.php") ?>

</body>