<? 
	session_start(); 
	
	include "../lib/dbconn.php"; 
	
	if ($mode=="level_up")
	{
		$sql = "update member set level = level+1 where id='$id'";
		$result = mysql_query($sql, $connect);
	}
	else if($mode=="level_down")
	{
		$sql = "update member set level = level-1 where id='$id'";
		$result = mysql_query($sql, $connect);
	}
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<meta charset="euc-kr">
<link href="../css/common.css" rel="stylesheet" type="text/css" media="all">
<link href="../css/memo.css" rel="stylesheet" type="text/css" media="all">
</head>

<body>
<div id="wrap">
  <div id="header">
    <? include "../lib/top_login2.php"; ?>
  </div>  <!-- end of header -->

  <div id="menu">
	<? include "../lib/top_menu2.php"; ?>
  </div>  <!-- end of menu --> 

  <div id="content">    
	<div id="col1">
		<div id="left_menu">
<?
			include "../lib/left_menu.php";
?>
		</div>
	</div>
	<!-- ��� ȸ�� ���� �˻�, �̸����� �˻� - �˻��ϸ� ����� �߰�, �󼼺��⸦ ������ �� ����� ������ �� ������ ������ ���� -->
	<!-- �󼼺��� �� �ۼ��� �� ���� - ���� ���� ������ ������ -->
	
	<div id="col2">  
		<div id="title">
			<img src="../img/mem_manage.gif">
		</div><br>
		
			<form method="post" action="member_manage_true.php?&mode=search"> 
			<div align="right" id="list_search">
				<img src="../img/select_search.gif">
					<select name="find">
						<option value='id'>���̵�</option>
						<option value='name'>�̸�</option>
						<option value='nick'>�г���</option>
					</select>
				<input type="text" name="search">
				<input type="image" src="../img/list_search_button.gif">
			</div>
		</form>

			<p><a href ="member_manage_true.php?mode=member_all">[��üȸ��]</a> 
			   <a href ="member_manage_true.php?mode=id_first">[���̵�� ����]</a>
			   <a href ="member_manage_true.php?mode=hp_first">[��ȭ��ȣ�� ����]</a>
			   <a href ="member_manage_true.php?mode=regist_day_first">[���Գ�¥�� ����]</a></p>
		<br>
		<div>
		<form method="get" action="member_update.php?id=$id">
		<table width="830" border="0" cellpadding="7">
			 <tr align="center" bgcolor="#eeeeee">
			 <td>���̵�</td>
			 <td>��й�ȣ</td>
			 <td>�̸�</td>
			 <td>�г���</td>
			 <td>����</td>
			 <td>��ȭ��ȣ</td>
			 <td>�̸���</td>
			 <td>���Գ�¥</td>
			 <td>�ۼ��Ѵ��</td>
			 <td colspan="2">&nbsp;</td>			 
			 </tr>
			 

		
<?
	if ($mode == "mem_all")          
       $sql = "select * from member";
	else if ($mode == "id_first")          
       $sql = "select * from member order by id";
    else if ($mode == "regist_day_first")   
       $sql = "select * from member order by regist_day";
    else if ($mode == "hp_first")   
    $sql = "select * from member order by hp";
	else if ($mode=="search")
	{
		if(!$search)
		{
			echo("
				<script>
				 window.alert('�˻��� �ܾ �Է��� �ּ���!');
			     history.go(-1);
				</script>
			");
			exit;
		}

		$sql = "select * from member where $find like '%$search%' order by id desc";
	}
    else 
       
   $sql = "select * from member order by id";
   
	$result = mysql_query($sql);
	   
	$fields = mysql_num_fields($result);
	$records = mysql_num_rows($result);
	
    $count = 0;  
	
	 while ($row = mysql_fetch_array($result))
    {   
	$num = $row[num];
       echo "<tr align='center'>
             <td> <u><a href='../img/man.jpg' onclick='window.open('../img/man.jpg', '', 'width=150px,height=150px,toolbars=no,scrollbars=no'); return false;'>$row[id]</a></u> </td>
			 <td> $row[pass] </td>
             <td> $row[name] </td>
             <td> $row[nick] </td>
			 <td> $row[level] <a href ='member_manage_true.php?mode=level_up&id=$row[id]'>��</a>
			 <a href ='member_manage_true.php?mode=level_down&id=$row[id]'>��</a></td>
             <td> $row[hp] </td>
             <td> <u><a href='mailto:$row[email]'>$row[email]</a></u></td>
             <td> $row[regist_day]  </td>
             <td> 
		 <a href='member_manage_true.php?id=$row[id]'>[������]</a></td>
		 <td><a href='member_manage_true.php?mode=update&id=$row[id]'>[����]</a></td>
		 <td><a href='member_delete.php?id=$row[id]'>[����]</a></td>
         </tr>
             ";
     
       $count++;
     }
	 

 // DB ������ ��� ��
                // DB ���� ����
 ?>

 
 </table>
 </form><br>
 <div>�� �� <?=$count?> ���� ȸ���� �ֽ��ϴ�.  </div>
 </div>
 <br>

 <hr>
 <p><a href ="member_manage_true.php?mode=rip_all">[��ü���]</a><p> <!--mode�� ��� get���-->

		
<?
	if($mode=="update")
	{
		$sql = "select * from member where id='$id'";
		$result = mysql_query($sql);
		
		echo 
		"
		<table width='830' border='0' cellpadding='7'>
			 <tr align='center' bgcolor='#eeeeee'>
			 <td>���̵�</td>
			 <td>��й�ȣ</td>
			 <td>�̸�</td>
			 <td>�г���</td>
			 <td>����</td>
			 <td>��ȭ��ȣ</td>
			 <td>�̸���</td>
			 <td>���Գ�¥</td>		 
			 <td>����</td>
			 </tr>";
			 
	   
	$fields = mysql_num_fields($result);
	$records = mysql_num_rows($result);

	 while ($row = mysql_fetch_array($result))
    {   
       echo "<tr align='center'>
			 <form method='get' action='./member_update.php?id=$id'>
             <td> <input type='text' name='id' value='$row[id]' readonly size='6'></td>
             <td> <input type='text' name='pass' value='$row[pass]' size='5' ></td>
             <td> <input type='text' name='name' value='$row[name]' size='5'></td>
             <td> <input type='text' name='nick' value='$row[nick]' size='5'></td>
			 <td> <input type='text' name='level' value='$row[level]' size='3'></td>
             <td> <input type='text' name='hp' value='$row[hp]' size='5' ></td>
             <td> <input type='text' name='email' value='$row[email]' size='7' ></td>
             <td> <input type='text' name='regist_day' value='$row[regist_day]' size='7'></td>
			 <td> <input type='submit' value='��'></a></td>
         </tr></table></form>
             ";

     }
	}
	 
	else
	{
		echo 
		" 		
		<table width='830' border='0' cellpadding='7' scrolling='yes'>
			 <tr align='center' bgcolor='#eeeeee'>
			 <td>���̵�</td>
			 <td>�̸�</td>
			 <td>�г���</td>
			 <td width='45%'>����</td>
			 <td>�ۼ���¥</td>
			 <td>��ۻ���</td>
			 <td>��������</td>			 
			 </tr>";
	
	if ($mode=="rip_all")
	$sql = "select * from memo_ripple";
	else 
	$sql = "select * from memo_ripple where id='$id'";

	$result = mysql_query($sql);
	
	//$fields = mysql_num_fields($result);
	//$records = mysql_num_rows($result);
	
    $count = 0;  
	while ($row = mysql_fetch_array($result))
    {   
	$num = $row[num];

       echo "<tr align='center'>
             <td> $row[id] </td>
             <td> $row[name] </td>
             <td> $row[nick] </td>
             <td> <a href ='$row[content]'>$row[content]</a> </td>
             <td> $row[regist_day] </td>
		 <td><a href='../memo/delete_ripple_member.php?num=$num'>[X]</a></td>
		 <td><a href='member_delete.php?id=$id'>[X]</a></td>
         </tr>
             ";
     
       $count++;
		
	}	 
	}		
	
 // DB ������ ��� ��

 // DB ���� ����
 ?>
 </table><br>
 
 <div>�� �� <?=$count?> ���� ����� �ֽ��ϴ�.  </div>
		</div>
	</div>
</body>
</html>