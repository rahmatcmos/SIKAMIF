<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once "fungsi_lanjutan.php";
$tahun_ajaran = $_REQUEST['tahun_ajaran'];
$kelas_id = $_REQUEST['kelas_id'];
$hari = $_REQUEST['hari'];
$act = $_REQUEST['act'];
$id_jadwal = $_REQUEST['id_jadwal'];
$jam = $_REQUEST['jam'];
$id_guru = $_REQUEST['id_guru'];
$id_matpel = $_REQUEST['id_matpel'];
$nip = $_REQUEST['nip'];
$nama = $_REQUEST['nama'];
$matpel = $_REQUEST['matpel'];
$waktu1 = $_REQUEST['waktu1'];
$waktu2 = $_REQUEST['waktu2'];

if ($act == 'del') {
    mysql_query("delete from jadwal where id_jadwal='$id_jadwal'");
}
?>
<html>
    <head>
        <title>Jadwal Pelajaran</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!--        <link href="../bootstrap/css/bootstrap.css" rel="stylesheet"/>
        <link href="../bootstrap/css/bootstrap-responsive.css" rel="stylesheet"/>
        <link href="../bootstrap/css/style.css" rel="stylesheet"/>
        <script src="../bootstrap/js/jquery-1.7.2.min.js"></script>
        <script src="../bootstrap/js/bootstrap-dropdown.js"></script> -->
        <script language="JavaScript"  src="../global/jscript.js" type="text/javascript"></script>
        <script language="JavaScript"  src="../global/jscript_pop.js" type="text/javascript"></script>
<!--        <script type="text/javascript" src="../bootstrap/js/jquery.js"></script>
        <script type="text/javascript" src="../bootstrap/js/styletable.jquery.plugin.js"></script>
        <script language="JavaScript">
            $(document).ready(function() {
                $('table').styleTable({
                    th_bgcolor: '#3E83C9',
                    th_color: '#ffffff',
                    th_border_color: '#333333',
                    tr_odd_bgcolor: '#ECF6FC',
                    tr_even_bgcolor: '#ffffff',
                    tr_border_color: '#95BCE2',
                    tr_hover_bgcolor: '#BCD4EC'
                });
            });
        </script> -->
    </head>

    <body>
        <div class="container-fluid">
            <div class="row-fluid">
                <!-- Content -->  
                <div class="span10">
                    <div class="row-fluid">
                        <img src="images/jadwal.gif" width="48" height="47" border="0">  
                        <br/>
                        <?php
                        if ($act == 'tambah') {
                            tambah_jadwal($tahun_ajaran, $kelas_id, $hari, $jam, $nip, $nama, $matpel, $id_guru, $id_matpel, $waktu1, $waktu2);
                        } elseif ($act == 'edit') {
                            edit_jadwal($tahun_ajaran, $kelas_id, $hari, $id_jadwal);
                        } else {
                            ?>
                            <form name="frm_tahun_ajaran" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <table class="table-bordered">
                                    <!--DWLayoutTable-->
                                    <tr>                             
                                    <input type="hidden" name="kelas_id" value="<?php echo $kelas_id; ?>">
                                    <input type="hidden" name="hari" value="<?php echo $hari; ?>">
                                    <td>Tahun Ajaran</td>
                                    <td colspan="5"> <select NAME="tahun_ajaran" onChange="submit();" class="input-medium">
                                            <?php
                                            $strsql = "SELECT tahun_ajaran FROM tahun_ajaran order by tahun_ajaran desc";
                                            $result = mysql_query($strsql);
                                            $num_results = mysql_num_rows($result);
                                            for ($i = 0; $i < $num_results; $i++) {
                                                $row_tahun = mysql_fetch_array($result);
                                                $test = $row_tahun[tahun_ajaran];
                                                if (isset($_POST['tahun_ajaran'])) {
                                                    $selected = (isset($_POST['tahun_ajaran']) and
                                                            $_POST['tahun_ajaran'] == $test) ? ' selected' : '';
                                                    echo "<option value='$test' $selected>$test</option>\n";
                                                } else {
                                                    $selected = (isset($_GET['tahun_ajaran']) and
                                                            $_GET['tahun_ajaran'] == $test) ? ' selected' : '';
                                                    echo "<option value='$test' $selected>$test</option>\n";
                                                }
                                            }
                                            ?>
                                        </select> </td>

                                    </tr>
                            </form>
                            <form name="frm_jurusan" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="tahun_ajaran" value="<?php echo $tahun_ajaran; ?>">
                                <input type="hidden" name="hari" value="<?php echo $hari; ?>">
                                <td>Kelas</td>
                                <td colspan="5"> <select NAME="kelas_id" onChange="submit();" class="input-medium">
                                        <?php
                                        $strsql = "SELECT id,ruang,aktif FROM kelas where aktif='1' order by ruang";
                                        $result = mysql_query($strsql);
                                        $num_results = mysql_num_rows($result);
                                        for ($i = 0; $i < $num_results; $i++) {
                                            $row_tahun = mysql_fetch_array($result);
                                            $test2 = $row_tahun[id];
                                            $test = $row_tahun[ruang];
                                            if (isset($_POST['kelas_id'])) {
                                                $selected = (isset($_POST['kelas_id']) and
                                                        $_POST['kelas_id'] == $test2) ? ' selected' : '';
                                                echo "<option value='$test2' $selected>$test</option>\n";
                                            } else {
                                                $selected = (isset($_GET['kelas_id']) and
                                                        $_GET['kelas_id'] == $test2) ? ' selected' : '';
                                                echo "<option value='$test2' $selected>$test</option>\n";
                                            }
                                        }
                                        ?>
                                    </select> 
                                </td>
                            </form>
                            <form name="frm_semester" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <tr>
                                <input type="hidden" name="kelas_id" value="<?php echo $kelas_id; ?>">
                                <input type="hidden" name="tahun_ajaran" value="<?php echo $tahun_ajaran; ?>">
                                <td>Hari</td>
                                <td> 
                                    <select name="hari"  onChange="submit();" class="input-medium">
                                        <option value="SENIN" <?php if ($hari == 'SENIN') echo "SELECTED"; ?>>SENIN</option>
                                        <option value="SELASA" <?php if ($hari == 'SELASA') echo "SELECTED"; ?>>SELASA</option>
                                        <option value="RABU" <?php if ($hari == 'RABU') echo "SELECTED"; ?>>RABU</option>
                                        <option value="KAMIS" <?php if ($hari == 'KAMIS') echo "SELECTED"; ?>>KAMIS</option>
                                        <option value="JUM`AT" <?php if ($hari == 'JUM`AT') echo "SELECTED"; ?>>JUM`AT</option>
                                        <option value="SABTU" <?php if ($hari == 'SABTU') echo "SELECTED"; ?>>SABTU</option>
                                    </select> 
                                </td>
                                <td colspan="4">
                                    <a href="?act=tambah&tahun_ajaran=<?php echo $tahun_ajaran; ?>&kelas_id=<?php echo $kelas_id; ?>&hari=<?php echo $hari; ?>" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i>Tambah</a>
                                </td>
                                </tr>
                            </form>

                            <?php
                            $hasil_wali = mysql_query("SELECT wali_kelas.ID, wali_kelas.TAHUN_AJARAN, guru.NIP, guru.GLR_DEPAN, guru.NAMA, guru.GLR_BLK, kelas.RUANG
FROM kelas INNER JOIN (guru INNER JOIN wali_kelas ON guru.ID = wali_kelas.ID_GURU) ON kelas.ID = wali_kelas.ID_KELAS
where wali_kelas.TAHUN_AJARAN='$tahun_ajaran' and kelas.ID='$kelas_id'");
                            $row_wali = mysql_fetch_array($hasil_wali);
                            ?>
                            <tr> 
                                <td>Wali Kelas</td>
                                <td colspan="5"><?php echo $row_wali[GLR_DEPAN] . " " . $row_wali[NAMA] . " " . $row_wali[GLR_BLK]; ?></td>
                            </tr>
                            <tr> 
                                <th align="center">NAMA PENGAJAR</th>
                                <th align="center">MATA PELAJARAN</th>
                                <th align="center">WAKTU</th>
                                <th align="center">JAM</th>
                                <th colspan="2" align="center">AKSI</th>
                            </tr>
                            <?php
                            jadwal_pelajaran($tahun_ajaran, $hari, $kelas_id);
                            ?>
                            <tr>
                                <td colspan="6"><a href="rpt_jadwal_pelajaran.php?tahun_ajaran=<?php echo $tahun_ajaran; ?>&kelas_id=<?php echo $kelas_id; ?>" target="_blank"><img src="images/cetak.gif" alt="klik disini untuk Cetak Data Jadwal Pelajaran" border="0"></a></td>
                            </tr>
                            </table>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <!-- end content -->
            </div>
        </div>

    </body>
</html>
