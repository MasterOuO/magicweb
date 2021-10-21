<?php
srand();

session_start();

require_once("../include/configure.php");
require_once("../include/db_func.php");
	$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
	$account=$_SESSION['gameaccount'];
	$sql="SELECT * FROM game_user WHERE account ='$account'";
	$rs = querydb($sql,$db_conn);
	$score=$rs[0]['score'];
	
//if(!isset($_GET['value'])) $score = 0;
//else $score = $_GET['value'];
if($score <= 10) $time=11;
else if($score > 10 && $score <=20) $time=8;
else if($score > 20 && $score <=30) $time=6;
else if($score > 30) $time=4; 

function GenerateArrow(){ //生成題目
	$ans_arrow = "";
	for($i=0; $i<5; $i++){
		$a = rand(0,3);
		$ans_arrow .= $a;
	}
	return $ans_arrow;
}

function PrintArrow($arrow){ //顯示題目圖案
	for($i = 0; $i < 5 ; $i++){
	$x = substr($arrow,$i,1);
	if($x == 0) echo '<img src="Arrow_Left.png" border="0" width="100px" height="100px">';
    else if($x == 1) echo '<img src="Arrow_Up.png" border="0" width="100px" height="100px">';
    else if($x == 2) echo '<img src="Arrow_Right.png" border="0" width="100px" height="100px">';
    else echo '<img src="Arrow_Down.png" border="0" width="100px" height="100px">';
    }
}

//echo $score;
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<meta HTTP-EQUIV="Pragma" CONTECT="no-cache">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<title>Project Test</title>
<style>
body{
    font-family:monospace;
    text-align: center;
	background-image: url(background_jungle.jpg);
	background-attachment:fixed;
    background-repeat:no-repeat;
	background-size: cover;
}
</style>
</head>
<body>
<div style="text-align:center; margin-top:30px;">
<div style="text-align:center; margin-top:30px; font-size:20pt; display:inline-block">
<img src="boss.png" border="0" width="300px" height="300px">
<div id="topic" style="text-align:center;background-color:#FFFFFF;border:5px #FF0000 solid">
<?php
$ans_arrow = GenerateArrow();
PrintArrow($ans_arrow);
?>
</div>
</div>
<div id="timer" style="text-align:center; margin-top:30px; font-size:20pt; display:inline-block;
                       background-color:#FFD382;border:2px black solid;width:50px">
</div>
</div>
<div id="scoreboard" style="text-align:center;margin:30px 775px 0px;font-size:30pt;
                            background-color:#9999FF;border:3px #7744FF solid;width:300px">
</div>
<script>
function express(score){
	//sum++;
	//window.sessionStorage.setItem("score", sum);
	
	location.replace="game_easy.php";	
	
}
function refresh(){
	for(var j=0; j<5; j++){
			$("#arrow").remove();
	}
	window.location.reload();
}
</script>
<div id="playerAns" style="text-align:center;margin:50px 665px 0px;background-color:#FFFFFF;border:5px #00BBFF solid;
                           height:100px;width:500px">
<script>
var i=0;
var input_arrow;
//var sum = 0;
var sum ;

var score = "<?php echo $score; ?>";
document.getElementById("scoreboard").innerHTML = "得分 : " +score;
var ans_arrow = "<?php echo $ans_arrow; ?>";
function keyFunction() {
	var s = ans_arrow.substr(i,1);
	if(event.keyCode == 37){
		var str = '<img id="arrow" src="Arrow_Left.png" border="0" width="100px" high="100px">';
		$("#playerAns").append(str);
		input_arrow = 0;
		i++;
	}
	else if(event.keyCode == 38){
		var str = '<img id="arrow" src="Arrow_Up.png" border="0" width="100px" high="100px">';
		$("#playerAns").append(str);
		input_arrow = 1;
		i++;
	}
	else if(event.keyCode == 39){
		var str = '<img id="arrow" src="Arrow_Right.png" border="0" width="100px" high="100px">';
		$("#playerAns").append(str);
		input_arrow = 2;
		i++;
	}
	else if(event.keyCode == 40){
		var str = '<img id="arrow" src="Arrow_Down.png" border="0" width="100px" high="100px">';
		$("#playerAns").append(str);
		input_arrow = 3;
		i++;
	}
	if(input_arrow != s){
		for(var j=0; j<i; j++){
			$("#arrow").remove();
		}
		i=0;
	}
	if(i == 5){
		i=0;
		score++;
		<?php
		$score++;
		$sqlcmd="UPDATE game_user SET score='$score' WHERE account='$account'";
        $result = updatedb($sqlcmd, $db_conn);
		?>
		express(score);
		setTimeout("refresh()",200);
	}
}
document.onkeydown=keyFunction;
</script>
<script>
var x = <?php echo $time; ?>;
function countdown(){
	x = x-1;
	if(x < 0) {
		var score = "<?php echo $score; ?>"-1;
		alert("失敗");
		window.location.href = "settlement.php?value="+score;
	}
	document.getElementById("timer").innerHTML = x;
	setTimeout("countdown()",1000);
}
</script>
<script>
countdown();
</script>
</div>
</body>
</html>