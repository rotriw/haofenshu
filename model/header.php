
<?php
    if(!file_exists("count.txt")){
        $one_file=fopen("count.txt","w+"); //建立一个统计文本，如果不存在就创建
        echo"您是第<font color='red'><b>1</b></font>位访客"; //首次直接输出第一次
        fwrite("count.txt","1");  //把数字1写入文本
        fclose("$one_file");
     }else{ //如果不是第一次访问直接读取内容，并+1,写入更新后再显示新的访客数
        $num=file_get_contents("count.txt");
        $num++;
        file_put_contents("count.txt","$num");
        $newnum=file_get_contents("count.txt");
    }
?>
<html>
    <head>
        <title> <?php echo "Hao Fen Shu"; ?> </title>
        <script src="./style/jquery.min.js"></script>
        <script src="./style/swal.js"></script>
        <link rel="stylesheet" type="text/css" href="./style/all.min.css">
        <script src="./style/all.min.js"></script>
        <script src="./style/g2.min.js"></script>
        <link rel="stylesheet" type="text/css" href="./style/semantic.min.css">
        <link rel="stylesheet" type="text/css" href="./style/rtui.css">
        <script defer data-domain="hfs.lzx.smallfang.fun" src="https://plausible.io/js/plausible.js"></script>

        <link rel="stylesheet" type="text/css" href="./style/extra.css">
        <script src="./style/semantic.min.js"></script>
        <script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "i9w4ibjngs");
</script>
    </head>