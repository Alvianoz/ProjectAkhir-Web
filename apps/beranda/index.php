<div class="row">
    <ol class="breadcrumb">
        <li><a href="index.php?page=beranda">
                <em class="fa fa-home"></em>
            </a></li>
        <li class="active">Beranda</li>
    </ol>
</div>
<!--/.row-->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Beranda</div>
            <div class="panel-body">

            <!--Menampilkan Nama Pengguna Sesuai Level -->
            <?php if ($_SESSION['level']=='Admin' or $_SESSION['level']=='Admin'):?>
                <h3>Selamat Datang,  <?php echo  $_SESSION["nama_admin"]; ?>.</h3>
            <?php endif; ?>
            <?php if ($_SESSION['level']=='Mahasiswa' or $_SESSION['level']=='mahasiswa'):?>
                <h3>Selamat Datang, <?php echo  $_SESSION["nama_siswa"]; ?>.</h3>
            <?php endif; ?>
            <!-- Menampilkan Nama Pengguna Sesuai Level -->

            <!-- Mengambil data table tbl_site -->
            <?php 
                //Mengambil profil aplikasi
                //Mengubungkan database
                include 'config/database.php';
                $query = mysqli_query($kon, "select * from tbl_site limit 1");    
                $row = mysqli_fetch_array($query);
            ?>
            <!-- Menhambil data table tbl_site -->

            <!-- Info Aplikasi -->
            <p>Selamat Datang di Aplikasi Presensi dan Kegiatan Harian Peserta Didik berbasis Web. Sebuah sistem yang memungkinkan para Peserta Didik di kelas XI PPLG B SMK Negeri 5 Surakarta untuk melalukan absensi dan mencatat kegiatan harian dari website. Sistem ini diharapkan dapat memberi kemudahan setiap Peserta Didik untuk melakukan presensi dan mencatat kegiatan harian.</p>
            <!-- Info Aplikasi -->
            
            </div>
        </div>
    </div>
</div>