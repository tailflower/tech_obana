<?php

//3-1参照。データベースに接続;
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

//3-2参照。データベース内にcreateでテーブルを作成。「番号、名前、コメント、日付、パス」のカラムを作成。;
$sql= "CREATE TABLE mission4"
." ("
//『auto～key』は自動的に番号を1からつける働き。;
. "mynum INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"
//『TEXT』はテキストのみ入力可能にする働き。;
. "myname TEXT,"
. "mycomment TEXT,"
. "mydate TEXT,"
. "mypass TEXT"
.");";
$stmt = $pdo->query($sql);

/*
//3-3参照。テーブル一覧を表示する指示;
$sql2 ='SHOW TABLES';
$result = $pdo -> query($sql2);
foreach ($result as $row){
   echo $row[0];
   echo '<br>';
}
echo "<hr>";

//3-4参照。テーブルの中身を確認する指示;
$sql3 ='SHOW CREATE TABLE mission4';
$result2 = $pdo -> query($sql3);
foreach ($result2 as $row2){
   print_r($row2);
}
echo "<hr>";
*/


$name = $_POST['name'];
$message = $_POST['message'];
$numero = $_POST['numero'];
$date = date('Y/m/d Ah:i');
$spass = $_POST['spass'];
$dpass = $_POST['dpass'];
$epass = $_POST['epass'];


//①　新規投稿の処理;
//「送信のみが押されたとき」;
if($_POST['send'] && !$_POST['delete'] && !$_POST['edit']  && !$_POST['hide']){
//更に「名前と内容とsパスのみが入力されていれば」;
    if(!empty($name) && !empty($message) && !empty($spass)){
//3-5参照。insertでデータ入力;
	$myname = $name;
	$mycomment = $message;
	$mydate = $date;
	$mypass = $spass;

	$sql4 = $pdo -> prepare("INSERT INTO mission4 (myname, mycomment, mydate, mypass) VALUES (:myname, :mycomment, :mydate, :mypass)");
	$sql4 -> bindParam(':myname', $myname, PDO::PARAM_STR);
	$sql4 -> bindParam(':mycomment', $mycomment, PDO::PARAM_STR);
	$sql4 -> bindParam(':mydate', $mydate, PDO::PARAM_STR);
	$sql4 -> bindParam(':mypass', $mypass, PDO::PARAM_STR);

	$sql4 -> execute();
	print "入力ありがとうございます!!";
	print "<hr>";
    }
}


//②　削除処理;
//「削除のみ押されたとき」;
if($_POST['delete'] && !$_POST['send'] && !$_POST['edit'] ){
//更に「削除番号とdパスのみが入力されていれば」;
    if(!empty($numero) && !empty($dpass) && empty($name) && empty($message) && empty($spass) && empty($nombre) && empty($epass)){
//テーブルの中身を一度読み込む;
	$dsql = 'SELECT * FROM mission4';
	$dresult = $pdo->query($dsql);
	foreach($dresult as $drow){
//更に「削除番号$numeroと投稿番号$drow['mynum']が一致、かつdパス$dpassとsパス$drow['mypass']が一致したら、削除」;
	    if($numero == $drow['mynum'] && $dpass == $drow['mypass']){
//削除対象の投稿番号を指定;
		$dmynum = $numero;
//3-8参照。入力したデータをdeleteで削除;
		$dsql = "delete from mission4 where mynum=$dmynum";
		$dresult = $pdo->query($dsql);
		print "削除に成功しました!!";
		print "<hr>";
	    }else{
		echo "パスワードが違います...。";
		exit;
	    }
	}
    }
}


//③　編集処理;
//(1)　フォームに、編集対象の投稿を表示させる指示;
$nombre = $_POST['nombre'];
$hide = $_POST['hide'];
//「編集ボタン押したとき」;
if($_POST['edit'] && !$_POST['send'] && !$_POST['delete']){
//「かつ、編集番号とeパスが入力されているとき」;
	if(!empty($nombre) && !empty($epass)){
//テーブルの中身を一度読み込む;
	    $esql = 'SELECT * FROM mission4';
	    $eresult = $pdo->query($esql);
	    foreach($eresult as $erow){
//更に「編集番号$nombreと投稿番号$erow['mynum']が一致、かつeパス$epassとsパス$erow['mypass']が一致したら、編集」;
		if($nombre == $erow['mynum'] && $epass == $erow['mypass']){
//編集対象の投稿番号を指定;
		    $datac = $erow['mynum'];
		    $dataa = $erow['myname'];
		    $datab = $erow['mycomment'];
		    echo "内容を編集し、新しくパスワードを設定してください。";
		    echo "<hr>";
		}
		if($nombre == $erow['mynum'] && !($epass == $erow['mypass'])){
		    print "パスワードが違います...。";
		    exit;
		}
	    }
	}
}

//(2)　ファイルに編集された投稿を上書き指示;
//「編集番号が表示されている、かつ送信ボタンのみを押したとき」;
if($_POST['send'] && !$_POST['delete'] && !$_POST['edit'] && !empty($hide)){
//更に「名前とコメントとspassが入力されているとき」;
    if(!empty($name) && !empty($message) && !empty($spass)){
//3-7参照。入力したデータをupdateで編集;
//編集対象の投稿番号を指定;
	$emynum = $hide;
//編集更新したい内容を新規に指定;
	$emyname = $name;
	$emycomment = $message;
	$emydate = $date;
	$emypass = $spass;
//「変更前→変更後（myname→$emyname...）にアップデート」という指示;
	$esql = "update mission4 set myname='$emyname', mycomment='$emycomment', mydate='$emydate', mypass='$emypass' where mynum = $emynum";
	$eresult = $pdo->query($esql);
	print "編集に成功しました!!";
	print "<hr>";
    }
}

?>



<html>
<body>
<form method = "post" action = "mission_4_obana.php">

名前 : <input type = "text" name = "name" value = "<?php echo $dataa; ?>" placeholder = "名前" size = "10"> <br/>
コメント : <input type = "text" name = "message" value = "<?php echo $datab; ?>" placeholder = "コメント" size = "10"> <br/>
パスワード : <input type = "password" name = "spass" placeholder = "パスワード" size = "10"><br/>
<input type = "hidden" name = "hide" value = "<?php echo $datac; ?>" size = "1">
<input type = "submit" name = "send" value = "送信"><br/>
<hr>

削除番号 : <input type = "text" name = "numero" placeholder = "削除対象番号" size = "15"> <br/>
パスワード : <input type = "password" name = "dpass" placeholder = "パスワード" size = "10"><br/>
<input type = "submit" name = "delete" value = "削除">
<hr>

編集番号 : <input type = "text" name = "nombre" placeholder = "編集対象番号" size = "15"><br/>
パスワード : <input type = "password" name = "epass" placeholder = "パスワード" size = "10"><br/>
<input type = "submit" name = "edit" value = "編集">
<hr>

</form>
</body>
</html>


<?php
//④ ブラウザ表示;
//「送信か削除か編集いずれかが押されたとき」;
if($_POST['send'] or $_POST['delete'] or $_POST['edit']){
//3-6参照。入力したデータをselectでブラウザ表示;
//『OEDER～ASC』は番号の小さい順に表示する働き。;
	$sql5 = 'SELECT * FROM mission4 ORDER BY mynum ASC';
	$results3 = $pdo -> query($sql5);
	foreach ($results3 as $row3){
//$rowの中にはテーブルのカラム名が入る;
	   echo $row3['mynum'].',';
	   echo $row3['myname'].',';
	   echo $row3['mycomment'].',';
	   echo $row3['mydate'].'<br>';
//	   echo $row3['mypass'].'<br>';
	}
}
?>
