<html>
<title>Simple Database Application using PHP</title>
<h1>Simple Database Application using PHP</h1>
<script type="text/javascript">
function validateForm()
{ var un=document.form1.username.value;
  var pd=document.form1.psd.value;
  if(un=="" && pd!="")
  {	  
  document.getElementById("errorMessage").innerHTML="Please enter username";return false;	}
  if(un!="" && pd=="")
  {	   document.getElementById("errorMessage").innerHTML="Please enter password"; return false;	}
  if(un=="" && pd=="")
	  {	 document.getElementById("errorMessage").innerHTML="Please enter username & password";return false;	}
	}
</script>
<body>

<?PHP 
if($_REQUEST['action']=='edit')
{
?>
<form id="form1" name="form1" method="post" action="update.php?id=<?PHP echo $_REQUEST['id']; ?>" onSubmit="return validateForm();">
<table width="200" border="1">
  <tr>
    <td>Username</td>
    <td><label for="username"></label>
       <input type="text" name="username" id="username" value="<?PHP echo $_REQUEST['un']; ?>" /></td>
   </tr>
  <tr>
    <td>Password</td>
    <td><label for="psd"></label>
      <input type="text" name="psd" id="psd" value="<?PHP echo $_REQUEST['pd']; ?>" /></td>
  </tr>
  <tr>
    <td><input type="submit" name="submit" id="submit" value="Submit" /></td>
    <td><input type="reset" name="Reset" id="Reset" value="Reset" /></td>
  </tr>
</table>

</form>
<?PHP
}
else
{
?>
<form id="form1" name="form1" method="post" action="insert.php" onSubmit="return validateForm();">
<table width="200" border="1">
  <tr>
    <td>Username</td>
    <td><label for="username"></label>
       <input type="text" name="username" id="username" value="" /></td>
   </tr>
  <tr>
    <td>Password</td>
    <td><label for="psd"></label>
      <input type="text" name="psd" id="psd" value="" /></td>
  </tr>
  <tr>
    <td><input type="submit" name="submit" id="submit" value="Submit" /></td>
    <td><input type="reset" name="Reset" id="Reset" value="Reset" /></td>
  </tr>
</table>

</form>
<?PHP } ?>
<p id="errorMessage" style="color:#C00; font-style:italic;"></p>

<?php
require_once('conn.php');
$result = mysqli_query($conn, "SELECT * FROM tbllogin");
echo "<table border='2'>";
echo "<th>Username</th><th>Password</th>";
while($row=mysqli_fetch_array($result))
{ echo "<tr>";
$idn=$row['id'];$un=$row['username'];$pd=$row['psd'];
 echo "<td>".$row['username']." </td>";
   echo "<td>".$row['psd']."</td>";
   echo "<td><a href='delete.php?id=$idn'>Delete</a></td>
   <td><a href='home.php?id=$idn&action=edit&un=$un&pd=$pd'>Edit</a></td>";
	echo "</tr>";
	}
echo "</table>";

?>

</body>
</html>