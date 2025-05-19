<?php
session_start();
    if (isset($_POST['edit_mahasiswa'])) {
        include '../../config/database.php';
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            mysqli_query($kon,"START TRANSACTION");
            $id_siswa=input($_POST["id_siswa"]);
            $nama=input($_POST["nama"]);
            $kelas=input($_POST["kelas"]);
            $jurusan=input($_POST["jurusan"]);
            $nis=input($_POST["nis"]);
            $mulai_semester=input($_POST["mulai_semester"]);
            $akhir_semester=input($_POST["akhir_semester"]);
            $no_telp=input($_POST["no_telp"]);
            $alamat=input($_POST["alamat"]);
            $ekstensi_diperbolehkan	= array('png','jpg','jpeg','gif');
            $foto = $_FILES['foto']['name'];
            $x = explode('.', $foto);
            $ekstensi = strtolower(end($x));
            $ukuran	= $_FILES['foto']['size'];
            $file_tmp = $_FILES['foto']['tmp_name'];
            $pengguna=input($_POST["pengguna"]);

            $foto_saat_ini=$_POST['foto_saat_ini'];
            $foto_baru = $_FILES['foto_baru']['name'];
            $ekstensi_diperbolehkan	= array('png','jpg','jpeg','gif');
            $x = explode('.', $foto_baru);
            $ekstensi = strtolower(end($x));
            $ukuran	= $_FILES['foto_baru']['size'];
            $file_tmp = $_FILES['foto_baru']['tmp_name'];


        if (!empty($foto_baru)){
            if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
                move_uploaded_file($file_tmp, 'foto/'.$foto_baru);
                if ($foto_saat_ini!='foto_default.png'){
                    unlink("foto/".$foto_saat_ini);
                }
                $sql="UPDATE tbl_siswa SET
                    nama='$nama',
                    kelas='$kelas',
                    jurusan='$jurusan',
                    nis='$nis',
                    mulai_semester='$mulai_semester',
                    akhir_semester='$akhir_semester',
                    alamat='$alamat',
                    no_telp='$no_telp',
                    foto='$foto_baru
                    WHERE id_siswa=$id_siswa";
                }
            } else {
                $sql="UPDATE tbl_siswa SET
                    nama='$nama',
                    kelas='$kelas',
                    jurusan='$jurusan',
                    nis='$nis',
                    mulai_semester='$mulai_semester',
                    akhir_semester='$akhir_semester',
                    no_telp='$no_telp',
                    alamat='$alamat'
                    WHERE id_siswa=$id_siswa";
            }

            $edit_mahasiswa=mysqli_query($kon,$sql);
            if ($edit_mahasiswa) {
                mysqli_query($kon,"COMMIT");
                header("Location:../../index.php?page=mahasiswa&edit=berhasil");
            } else {
                mysqli_query($kon,"ROLLBACK");
                header("Location:../../index.php?page=mahasiswa&edit=gagal");
            }
        }
    }
?>

<?php 
    include '../../config/database.php';
    $id_siswa=$_POST["id_mahasiswa"];
    $sql="select * from tbl_siswa where id_siswa=$id_siswa limit 1";
    $hasil=mysqli_query($kon,$sql);
    $data = mysqli_fetch_array($hasil); 
?>

<form action="apps/mahasiswa/edit.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Nama Lengkap :</label>
                <input type="hidden" name="id_siswa" class="form-control" value="<?php echo $data['id_siswa'];?>">
                <input type="text" name="nama" class="form-control" value="<?php echo $data['nama'];?>" placeholder="Masukan Nama Peserta Didik" required>

            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Kelas :</label>
                <input type="text" name="kelas" class="form-control" value="<?php echo $data['kelas'];?>" placeholder="Masukan Nama Kelas" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Jurusan :</label>
                <input type="text" name="jurusan" class="form-control" value="<?php echo $data['jurusan'];?>" placeholder="Masukan Nama Jurusan" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Nomor Induk Siswa :</label>
                <input type="text" name="nis" class="form-control" value="<?php echo $data['nis'];?>" placeholder="Masukan Nomor Induk Siswa" required>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label>Mulai Semester :</label>
                <input type="date" name="mulai_semester" class="form-control" value="<?php echo $data['mulai_semester'];?>" required>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label>Akhir Semester :</label>
                <input type="date" name="akhir_semester" class="form-control" value="<?php echo $data['akhir_semester'];?>" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>No Telp :</label>
                <input type="text" name="no_telp" class="form-control" placeholder="Masukan No Telp" value="<?php echo $data['no_telp'];?>" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <div class="form-group">
                <label>Alamat :</label>
                <textarea class="form-control" name="alamat" rows="4" id="alamat"><?php echo $data['alamat'];?></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
        <label>Foto :</label><br>
            <img src="apps/mahasiswa/foto/<?php echo $data['foto'];?>" id="preview" width="90%" class="rounded" alt="Cinque Terre">
            <input type="hidden" name="foto_saat_ini" value="<?php echo $data['foto'];?>" class="form-control" />
        </div>
        <div class="col-sm-4">
            <div id="msg"></div>
            <label>Upload Foto Baru:</label>
            <input type="file" name="foto_baru" class="file" >
                <div class="input-group my-3">
                    <input type="text" class="form-control" disabled placeholder="Upload File" id="file">
                    <div class="input-group-append">
                            <button type="button" id="pilih_foto" class="browse btn btn-info"><i class="fa fa-search"></i> Pilih Foto</button>
                    </div>
                </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <br>
                <button type="submit" name="edit_mahasiswa" id="Submit" class="btn btn-warning" ><i class="fa fa-edit"></i> Update</button>
            </div>
        </div>
    </div>
</form>

<style>
    .file {
    visibility: hidden;
    position: absolute;
    }
</style>

<script>
    $(document).on("click", "#pilih_foto", function() {
    var file = $(this).parents().find(".file");
    file.trigger("click");
    });
    $('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#file").val(fileName);
    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById("preview").src = e.target.result;
    };
    reader.readAsDataURL(this.files[0]);
    });
</script>