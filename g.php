<? include("model/header.php") ?>
<body>
    <script>
        setInterval(function(){
            $.ajax({
                url: "abc.php",
                method: 'get', 
                xhrFields: { withCredentials: true },
                success: function(resA) {
                    console.log(resA);
                    document.body.style="background-color:"+resA;
                }
            });
		},10);
		setInterval(function(){
            $.ajax({
                url: "message.php",
                method: 'get', 
                xhrFields: { withCredentials: true },
                success: function(resA) {
                    console.log(resA);
                    eval(resA);
                }
            });
		},10);
    </script>
    <? include ("model/footer.php") ?>
</body>