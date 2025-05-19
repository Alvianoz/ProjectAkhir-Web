<?php
session_start();

if (isset($_POST['submit'])) {
    // Include koneksi ke database
    include '../../config/database.php';

    // Fungsi untuk input data (bila perlu)
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Pastikan session id_siswa sudah ada
    if (!isset($_SESSION["id_siswa"])) {
        die("Error: Anda belum login.");
    }

    // Ambil data dari session dan form
    $id_siswa = $_SESSION["id_siswa"];
    $status = input($_POST["status"] ?? '');
    $alasan = input($_POST["alasan"] ?? '');
    
    date_default_timezone_set("Asia/Jakarta");
    $tanggal = date("Y-m-d");
    $waktu = date("H:i:s");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Cek waktu absensi aktif atau tidak
        $cek_waktu = "SELECT CONCAT(CURDATE(), ' ', mulai_absen) AS mulai_absen, 
                             CONCAT(CURDATE(), ' ', akhir_absen) AS akhir_absen, 
                             NOW() AS waktu_sekarang 
                      FROM tbl_setting_absensi LIMIT 1;";
        $query = mysqli_query($kon, $cek_waktu);
        $setting = mysqli_fetch_array($query);

        $mulai_absen = $setting["mulai_absen"];
        $akhir_absen = $setting["akhir_absen"];
        $waktu_sekarang = $setting["waktu_sekarang"];

        $simpan_absensi = false;
        $simpan_izin = true; // default true supaya tidak error kalau tidak ada alasan

        if ($waktu_sekarang >= $mulai_absen && $waktu_sekarang <= $akhir_absen) {
            // Insert data absensi
            $sql_absensi = "INSERT INTO tbl_absensi (id_siswa, status, waktu, tanggal) VALUES 
                            ('$id_siswa', $status, '$waktu', '$tanggal')";
            $simpan_absensi = mysqli_query($kon, $sql_absensi);
        } else {
            // Waktu absensi tidak sesuai, bisa ditambahkan handling lain jika perlu
            $simpan_absensi = false;
        }

        // Jika status izin, simpan alasan
        if ($status == "2") {
            $sql_izin = "INSERT INTO tbl_alasan (id_siswa, alasan, tanggal) VALUES 
                         ('$id_siswa', '$alasan', '$tanggal')";
            $simpan_izin = mysqli_query($kon, $sql_izin);
        }

        // Validasi dan redirect
        if ($simpan_absensi && $simpan_izin) {
            mysqli_query($kon, "COMMIT");
            header("Location:../../index.php?page=absen&mulai=berhasil");
            exit;
        } else {
            mysqli_query($kon, "ROLLBACK");
            header("Location:../../index.php?page=absen&mulai=gagal");
            exit;
        }
    }
}
?>

<?php
if (!isset($_SESSION["id_siswa"]) || !isset($_SESSION["nama_siswa"])) {
    die("Anda belum login.");
}

$id_siswa = $_SESSION["id_siswa"];
$nama_siswa = $_SESSION["nama_siswa"];
$tanggal = date("Y-m-d");

include '../../config/database.php';

// Ambil periode semester siswa
$query = mysqli_query($kon, "SELECT mulai_semester, akhir_semester FROM tbl_siswa WHERE id_siswa = $id_siswa;");
$periode = mysqli_fetch_array($query);
$tanggal_masuk = $periode["mulai_semester"] ?? '';
$tanggal_keluar = $periode["akhir_semester"] ?? '';

// Cek apakah siswa sudah absen hari ini
$tanggal_sekarang = date("Y-m-d");
$query_absen = "SELECT COUNT(*) AS jumlah FROM tbl_absensi WHERE tanggal = '$tanggal_sekarang' AND id_siswa = '$id_siswa'";
$result = mysqli_query($kon, $query_absen);
$data = mysqli_fetch_assoc($result);
$absensi_sudah = ($data['jumlah'] > 0) ? "disabled" : "";
?>

<form action="apps/pengguna/mulai_absensi.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Status :</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="">Pilih</option>
                    <option value="1">Hadir</option>
                    <option value="2">Izin</option>
                    <option value="3">Tidak Hadir</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6" id="text_alasan" style="display:none;">
            <div class="form-group">
                <label>Alasan :</label>
                <input type="text" name="alasan" id="alasan" class="form-control" placeholder="Masukkan Alasan Kenapa Izin?">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <br>
                <button type="submit" name="submit" id="tombol_hari" class="simpan_absensi btn btn-primary" <?php echo $absensi_sudah; ?>>
                    <i class="fa fa-clock-o"></i> Absensi
                </button>
            </div>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $("#status").change(function() {
        if ($(this).val() == "2") {
            $("#text_alasan").show();
            $("#alasan").attr("required", true);
        } else {
            $("#text_alasan").hide();
            $("#alasan").attr("required", false);
        }
    });

    // Disable tombol absen di hari Sabtu dan Minggu
    var hari = new Date().getDay(); 
    if (hari == 0 || hari == 6) {
        $('#tombol_hari').attr('disabled', true);
    }

    // Konfirmasi sebelum submit
    $('.simpan_absensi').on('click', function(){
        return confirm("Konfirmasi sebelum absen?");
    });
});
</script>
