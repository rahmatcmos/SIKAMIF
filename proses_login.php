<?phpsession_start();include "./global/connect.php";$username = $_POST['username'];$password = $_POST['password'];$sekarang = date("y-m-d, H:i:s");$perintah = "SELECT id,login,pwd,tipe,aktif FROM usermanager WHERE login='$username' AND pwd='$password' AND aktif='1'";$hasil = mysql_query($perintah);$row = mysql_fetch_array($hasil);if ($row['login'] == $username && $row['pwd'] == $password) {    $_SESSION['username'] = $row['login'];    $_SESSION['password'] = $row['pwd'];    $_SESSION['tipe'] = $row['tipe'];    if ($row['tipe'] == '1') {//administrator        $str_insert = "UPDATE usermanager SET last_login='$sekarang' WHERE login='$username'";        mysql_query($str_insert);        echo "<script>document.location.href='admin/index.php';</script>";//        header("location:admin/index.php");    } elseif ($row['tipe'] == '2') {//siswa        $str_insert = "UPDATE usermanager SET last_login='$sekarang' WHERE login='$username'";        mysql_query($str_insert);        header("location:siswa/index.php");    } elseif ($row['tipe'] == '3') {//wali kelas dan guru        $str_insert = "UPDATE usermanager SET last_login='$sekarang' WHERE login='$username'";        mysql_query($str_insert);        header("location:guru/index.php");    } else {        echo "<script>alert('Username benar');</script>\n";    }} else {    echo "<script>javascript.location.href='index.php';</script>";}