<?php

//3-1�Q�ƁB�f�[�^�x�[�X�ɐڑ�;
$dsn = '�f�[�^�x�[�X��';
$user = '���[�U�[��';
$password = '�p�X���[�h';
$pdo = new PDO($dsn,$user,$password);

//3-2�Q�ƁB�f�[�^�x�[�X����create�Ńe�[�u�����쐬�B�u�ԍ��A���O�A�R�����g�A���t�A�p�X�v�̃J�������쐬�B;
$sql= "CREATE TABLE mission4"
." ("
//�wauto�`key�x�͎����I�ɔԍ���1������铭���B;
. "mynum INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"
//�wTEXT�x�̓e�L�X�g�̂ݓ��͉\�ɂ��铭���B;
. "myname TEXT,"
. "mycomment TEXT,"
. "mydate TEXT,"
. "mypass TEXT"
.");";
$stmt = $pdo->query($sql);

/*
//3-3�Q�ƁB�e�[�u���ꗗ��\������w��;
$sql2 ='SHOW TABLES';
$result = $pdo -> query($sql2);
foreach ($result as $row){
   echo $row[0];
   echo '<br>';
}
echo "<hr>";

//3-4�Q�ƁB�e�[�u���̒��g���m�F����w��;
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


//�@�@�V�K���e�̏���;
//�u���M�݂̂������ꂽ�Ƃ��v;
if($_POST['send'] && !$_POST['delete'] && !$_POST['edit']  && !$_POST['hide']){
//�X�Ɂu���O�Ɠ��e��s�p�X�݂̂����͂���Ă���΁v;
    if(!empty($name) && !empty($message) && !empty($spass)){
//3-5�Q�ƁBinsert�Ńf�[�^����;
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
	print "���͂��肪�Ƃ��������܂�!!";
	print "<hr>";
    }
}


//�A�@�폜����;
//�u�폜�̂݉����ꂽ�Ƃ��v;
if($_POST['delete'] && !$_POST['send'] && !$_POST['edit'] ){
//�X�Ɂu�폜�ԍ���d�p�X�݂̂����͂���Ă���΁v;
    if(!empty($numero) && !empty($dpass) && empty($name) && empty($message) && empty($spass) && empty($nombre) && empty($epass)){
//�e�[�u���̒��g����x�ǂݍ���;
	$dsql = 'SELECT * FROM mission4';
	$dresult = $pdo->query($dsql);
	foreach($dresult as $drow){
//�X�Ɂu�폜�ԍ�$numero�Ɠ��e�ԍ�$drow['mynum']����v�A����d�p�X$dpass��s�p�X$drow['mypass']����v������A�폜�v;
	    if($numero == $drow['mynum'] && $dpass == $drow['mypass']){
//�폜�Ώۂ̓��e�ԍ����w��;
		$dmynum = $numero;
//3-8�Q�ƁB���͂����f�[�^��delete�ō폜;
		$dsql = "delete from mission4 where mynum=$dmynum";
		$dresult = $pdo->query($dsql);
		print "�폜�ɐ������܂���!!";
		print "<hr>";
	    }else{
		echo "�p�X���[�h���Ⴂ�܂�...�B";
		exit;
	    }
	}
    }
}


//�B�@�ҏW����;
//(1)�@�t�H�[���ɁA�ҏW�Ώۂ̓��e��\��������w��;
$nombre = $_POST['nombre'];
$hide = $_POST['hide'];
//�u�ҏW�{�^���������Ƃ��v;
if($_POST['edit'] && !$_POST['send'] && !$_POST['delete']){
//�u���A�ҏW�ԍ���e�p�X�����͂���Ă���Ƃ��v;
	if(!empty($nombre) && !empty($epass)){
//�e�[�u���̒��g����x�ǂݍ���;
	    $esql = 'SELECT * FROM mission4';
	    $eresult = $pdo->query($esql);
	    foreach($eresult as $erow){
//�X�Ɂu�ҏW�ԍ�$nombre�Ɠ��e�ԍ�$erow['mynum']����v�A����e�p�X$epass��s�p�X$erow['mypass']����v������A�ҏW�v;
		if($nombre == $erow['mynum'] && $epass == $erow['mypass']){
//�ҏW�Ώۂ̓��e�ԍ����w��;
		    $datac = $erow['mynum'];
		    $dataa = $erow['myname'];
		    $datab = $erow['mycomment'];
		    echo "���e��ҏW���A�V�����p�X���[�h��ݒ肵�Ă��������B";
		    echo "<hr>";
		}
		if($nombre == $erow['mynum'] && !($epass == $erow['mypass'])){
		    print "�p�X���[�h���Ⴂ�܂�...�B";
		    exit;
		}
	    }
	}
}

//(2)�@�t�@�C���ɕҏW���ꂽ���e���㏑���w��;
//�u�ҏW�ԍ����\������Ă���A�����M�{�^���݂̂��������Ƃ��v;
if($_POST['send'] && !$_POST['delete'] && !$_POST['edit'] && !empty($hide)){
//�X�Ɂu���O�ƃR�����g��spass�����͂���Ă���Ƃ��v;
    if(!empty($name) && !empty($message) && !empty($spass)){
//3-7�Q�ƁB���͂����f�[�^��update�ŕҏW;
//�ҏW�Ώۂ̓��e�ԍ����w��;
	$emynum = $hide;
//�ҏW�X�V���������e��V�K�Ɏw��;
	$emyname = $name;
	$emycomment = $message;
	$emydate = $date;
	$emypass = $spass;
//�u�ύX�O���ύX��imyname��$emyname...�j�ɃA�b�v�f�[�g�v�Ƃ����w��;
	$esql = "update mission4 set myname='$emyname', mycomment='$emycomment', mydate='$emydate', mypass='$emypass' where mynum = $emynum";
	$eresult = $pdo->query($esql);
	print "�ҏW�ɐ������܂���!!";
	print "<hr>";
    }
}

?>



<html>
<body>
<form method = "post" action = "mission_4_obana.php">

���O : <input type = "text" name = "name" value = "<?php echo $dataa; ?>" placeholder = "���O" size = "10"> <br/>
�R�����g : <input type = "text" name = "message" value = "<?php echo $datab; ?>" placeholder = "�R�����g" size = "10"> <br/>
�p�X���[�h : <input type = "password" name = "spass" placeholder = "�p�X���[�h" size = "10"><br/>
<input type = "hidden" name = "hide" value = "<?php echo $datac; ?>" size = "1">
<input type = "submit" name = "send" value = "���M"><br/>
<hr>

�폜�ԍ� : <input type = "text" name = "numero" placeholder = "�폜�Ώ۔ԍ�" size = "15"> <br/>
�p�X���[�h : <input type = "password" name = "dpass" placeholder = "�p�X���[�h" size = "10"><br/>
<input type = "submit" name = "delete" value = "�폜">
<hr>

�ҏW�ԍ� : <input type = "text" name = "nombre" placeholder = "�ҏW�Ώ۔ԍ�" size = "15"><br/>
�p�X���[�h : <input type = "password" name = "epass" placeholder = "�p�X���[�h" size = "10"><br/>
<input type = "submit" name = "edit" value = "�ҏW">
<hr>

</form>
</body>
</html>


<?php
//�C �u���E�U�\��;
//�u���M���폜���ҏW�����ꂩ�������ꂽ�Ƃ��v;
if($_POST['send'] or $_POST['delete'] or $_POST['edit']){
//3-6�Q�ƁB���͂����f�[�^��select�Ńu���E�U�\��;
//�wOEDER�`ASC�x�͔ԍ��̏��������ɕ\�����铭���B;
	$sql5 = 'SELECT * FROM mission4 ORDER BY mynum ASC';
	$results3 = $pdo -> query($sql5);
	foreach ($results3 as $row3){
//$row�̒��ɂ̓e�[�u���̃J������������;
	   echo $row3['mynum'].',';
	   echo $row3['myname'].',';
	   echo $row3['mycomment'].',';
	   echo $row3['mydate'].'<br>';
//	   echo $row3['mypass'].'<br>';
	}
}
?>
