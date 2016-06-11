<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
    <script src="../../jquery-2.2.3.min.js"></script>
</head>
<script>
    console.info("posting...");
    $.post("login.php",{
        username: '',
        password: ''
    }, function(data){
        console.info(data);
        if(data != '-1'){
            window.location.replace("manageInventory.php?id="+data);
        }
    });
</script>
<body>

<form>
    username:<br>
    <input type="text" id="username"><br>
    Password:<br>
    <input type="password" id="password"><br>
    <input type="button" value="login" onclick="loginClick()">
</form>

</body>
<script>

    function loginClick(){

        var un = $("#username").val();
        var pw = $("#password").val();

        $.post("login.php",{
            username: un,
            password: pw
        }, function(data){
            console.info(data);
            if(data != '-1'){
                window.location.replace("manageInventory.php?id="+data);
            }else{
                alert("incorrect data");
            }
        });

    }

</script>

</html>
