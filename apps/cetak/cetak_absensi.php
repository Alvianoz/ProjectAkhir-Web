<?php
    $id_siswa = $_GET["id_siswa"];
    $tanggal_awal = $_GET["tanggal_awal"];
    $tanggal_akhir = $_GET["tanggal_akhir"];

    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="'.$namafile.'"');

    require('../../source/plugin/fpdf/fpdf.php');
    $pdf = new FPDF('P', 'mm','Letter');

    include '../../config/database.php';
    include '../../config/function.php';
    $query = mysqli_query($kon, "select * from tbl_site limit 1");    
    $row = mysqli_fetch_array($query);
    $pembimbing = $row['pembimbing'];

    $pdf->AddPage();

    $pdf->Image('../../apps/pengaturan/logo/'.$row['logo'],15,5,20,20);
    $pdf->SetFont('Arial','B',21);
    $pdf->Cell(0,7,strtoupper($row['nama_instansi']),0,1,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,7,$row['alamat'].', Telp '.$row['no_telp'],0,1,'C');
    $pdf->Cell(0,7,$row['website'],0,1,'C');

    $pdf->SetLineWidth(1);
    $pdf->Line(10,31,206,31);
    $pdf->SetLineWidth(0);
    $pdf->Line(10,32,206,32);

    $sql="select * from tbl_siswa where id_siswa=$id_siswa";
    $hasil=mysqli_query($kon,$sql);
    $data = mysqli_fetch_array($hasil); 

    $awal_semester = $data['mulai_semester'];
    $akhir_semester = $data['akhir_semester'];
    $mulai_bulan = date("m", strtotime($awal_semester));
    $akhir_bulan = date("m", strtotime($akhir_semester));
    $mulai_hari = date("d", strtotime($awal_semester));
    $akhir_hari = date("d", strtotime($akhir_semester));
    $akhir_tahun = date("Y", strtotime($akhir_semester));

    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,5,'',0,1,'C');
    $pdf->Cell(0,7,'DAFTAR HADIR SISWA',0,1,'C');
    $pdf->Cell(0,7,'PERIODE '.$mulai_hari.' '.MendapatkanAwalBulan($mulai_bulan).' - '.$akhir_hari.' '.MendapatkanAkhirBulan($akhir_bulan).' '.$akhir_tahun,0,1,'C');
    $pdf->Cell(0,5,'',0,1,'C');
    $pdf->Cell(0,5,'',0,1,'C');

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(30,6,'Nama ',0,0);
    $pdf->Cell(31,6,': '.$data['nama'],0,1);
    $pdf->Cell(30,6,'Nis ',0,0);
    $pdf->Cell(31,6,': '.$data['nis'],0,1);
    $pdf->Cell(30,6,'Kelas ',0,0);
    $pdf->Cell(31,6,': '.$data['kelas'],0,1);
    $pdf->Cell(30,6,'Jurusan ',0,0);
    $pdf->Cell(31,6,': '.$data['jurusan'],0,1);

    $pdf->Cell(10,3,'',0,1);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(10,6,'No',1,0,'C');
    $pdf->Cell(40,6,'Hari',1,0,'C');
    $pdf->Cell(50,6,'Tanggal',1,0,'C');
    $pdf->Cell(47,6,'Waktu',1,0,'C');
    $pdf->Cell(48,6,'Keterangan',1,1,'C');
    $pdf->SetFont('Arial','',10);

    $no= 0;

    $sql="SELECT id_absensi, id_siswa, status, tanggal, waktu,
    DATE_FORMAT(tanggal, '%W') AS hari 
    FROM tbl_absensi WHERE id_siswa = $id_siswa AND 
    tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ORDER BY tanggal ASC";
    $hasil=mysqli_query($kon,$sql);

    while ($data = mysqli_fetch_assoc($hasil)){
    
    $waktu = date("h:i", strtotime($data['waktu']));
    $status = $data['status'];
    $hari =$data['hari'];
    $tgl = date("d", strtotime($data['tanggal']));
    $bulan = date("m", strtotime($data['tanggal']));
    $tahun = date("Y", strtotime($data['tanggal']));
    
    $no++;
    $pdf->Cell(10,6,$no,1,0,'C');
    $pdf->Cell(40,6,MendapatkanHari($hari),1,0,'C');
    $pdf->Cell(50,6,$tgl.' '.MendapatkanBulan($bulan).' '.$tahun.'',1,0,'C');
    $pdf->Cell(47,6,$waktu,1,0,'C');
    $pdf->Cell(48,6,StatusAbsensi($status),1,1,'C');
    }

    $tanggal=date('Y-m-d');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(340,15,'',0,1,'C');
    $pdf->Cell(340,12,'',0,1,'C');
    $pdf->Cell(340,0,'Pembimbing semester',0,1,'C');
    $pdf->Cell(340,50,$pembimbing,0,1,'C');  
    
    $kueri="select nama from tbl_siswa where id_siswa=$id_siswa";
    $hasilsql=mysqli_query($kon,$kueri);
    $hasilnama = mysqli_fetch_array($hasilsql); 
    $nama=$hasilnama['nama'];
    $namafile = 'Absensi-'.$nama.'-'.date('YmdHis').'.pdf';
    $pdf->Output('files/'.$namafile, 'F');
    readfile('files/'.$namafile);
?>