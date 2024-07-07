<?php
session_start();

//koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "stockbarang");

//menambah user baru
if (isset($_POST['addnewuser'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    //validasi udh ada atau belum
    $cek = mysqli_query($conn,"SELECT * FROM login WHERE username='$username'");
    $hitung = mysqli_num_rows($cek);

    if($hitung<1){
        //jika belum ada
        $addtotable = mysqli_query($conn, "INSERT INTO login (iduser, username, password, role) VALUES ('', '$username', '$password','$role')");

    } else{
        //jika sudah ada
        echo'<script>alert("Username Sudah Terdaftar")</script>';
    }
};

//menambah barang baru
if (isset($_POST['addnewbarang'])) {
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    //soalgambar
    $allowed_extension = array('png','jpg','jpeg');
    $nama = $_FILES['gambarBarang']['name'];//ngambil nama file gambar
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot));//ngambil ekstensinya
    $ukuran = $_FILES['gambarBarang']['size'];//ngambil size gambarnya
    $file_tmp = $_FILES['gambarBarang']['tmp_name'];//ngambil lokasi gambar

    $dirUpload = "system/barang/";
    $imageName = md5(uniqid($nama,true). time()).'.'.$ekstensi; 

    //validasi udh ada atau belum
    $cek = mysqli_query($conn,"select * from stock where namabarang='$namabarang'");
    $hitung = mysqli_num_rows($cek);

    if($hitung<1){
        if(in_array($ekstensi, $allowed_extension)){
            //proses upload gambar
            $saveImage = move_uploaded_file($file_tmp, $dirUpload.$imageName);
            if ($saveImage) {
                mysqli_query($conn, "INSERT INTO stock (namabarang, deskripsi, stock, image) VALUES ('$namabarang', '$deskripsi', '$stock','$imageName')");
                // header('location:index.php');
            } else {
                echo 'Gagal';
                echo `<script>alert($file_tmp)</script>`;
                // header('location:index.php');
            }
        } else{
            //kalau file non png/jpg
            echo'
            <script>
                allert("Format File Harus png/jpg");
                window.location.href="index.php";
            </script>
            ';
        }

    } else{
        //jika sudah ada
        echo'
            <script>
                allert("Nama Barang Sudah Terdaftar");
                window.location.href="index.php";
            </script>
            ';
    }
};

//menambah barang masuk 
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];
    
    $allowed_extension = array('png','jpg','jpeg');
    $nama = $_FILES['foto']['name'];//ngambil nama file gambar
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot));//ngambil ekstensinya
    $ukuran = $_FILES['foto']['size'];//ngambil size gambarnya
    $file_tmp = $_FILES['foto']['tmp_name'];//ngambil lokasi gambar

    $dirUpload = "system/masuk/";
    $imageName = md5(uniqid($nama,true). time()).'.'.$ekstensi; 

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambilbarangnya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambilbarangnya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang + $qty;
    
    $saveImage = move_uploaded_file($file_tmp, $dirUpload.$imageName);
    if ($saveImage) {
        $addtomasuk = mysqli_query($conn, "INSERT INTO masuk (idbarang, keterangan, qty, foto) VALUES ('$barangnya', '$penerima', '$qty', '$imageName')");
        $updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$barangnya'");    
        if ($addtomasuk && $updatestockmasuk) {
            header('location:masuk.php');
        } else {
            echo 'Gagal';
            header('location:masuk.php');
        }
    }
}

//menambah barang keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $allowed_extension = array('png','jpg','jpeg');
    $nama = $_FILES['foto']['name'];//ngambil nama file gambar
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot));//ngambil ekstensinya
    $ukuran = $_FILES['foto']['size'];//ngambil size gambarnya
    $file_tmp = $_FILES['foto']['tmp_name'];//ngambil lokasi gambar

    $dirUpload = "system/keluar/";
    $imageName = md5(uniqid($nama,true). time()).'.'.$ekstensi; 

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambilbarangnya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambilbarangnya['stock'];

    if($stocksekarang >= $qty){
        //barangnya cukup
        $tambahkanstocksekarangdenganquantity = $stocksekarang - $qty;
        $saveImage = move_uploaded_file($file_tmp, $dirUpload.$imageName);
        if ($saveImage) {
            $addtokeluar = mysqli_query($conn, "INSERT INTO keluar (idbarang, penerima, qty, foto) VALUES ('$barangnya', '$penerima', '$qty', '$imageName')");
            $updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$barangnya'"); 
            if ($addtokeluar && $updatestockmasuk) {
                header('location:keluar.php');
            } else {
                echo 'Gagal';
                header('location:keluar.php');
            } 
        }  
    } else{
        //barang tidak cukup
        echo '
        <script>
            alert("stock saat ini tidak mencukupi");
            window.location.href="keluar.php";
        </script>
        ';
    }
}

//update data user
if(isset($_POST['updateuser'])){
    $iduser = $_POST['iduser'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    //tidak ingin upload
    $update = mysqli_query($conn, "UPDATE login SET username='$username', password='$password', role='$role' WHERE iduser='$iduser'");
    if($update){
        header('location:user.php');
    } else {
        echo 'Gagal';
        header('location:user.php');
    }    
}

//update info barang
if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    //soalgambar
    $allowed_extensions = array('png','jpg');
    $nama = $_FILES['file']['name'];//ngambil nama file gambar
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot));//ngambil ekstensinya
    $ukuran = $_FILES['file']['size'];//ngambil size gambarnya
    $file_tmp = $_FILES['file']['tmp_name'];//ngambil lokasi gambar

    //penamaan file
    $image = md5(uniqid($nama,true). time()).'.'.$ekstensi; 

    if($ukuran==0){
        //tidak ingin upload
        $update = mysqli_query($conn, "UPDATE stock SET namabarang='$namabarang', deskripsi='$deskripsi' WHERE idbarang='$idb'");
        if($update){
            header('location:index.php');
        } else {
            echo 'Gagal';
            header('location:index.php');
        }
    } else{
        //ingin upload
        move_uploaded_file($file_tmp, 'images/'.$image);
        $update = mysqli_query($conn, "UPDATE stock SET namabarang='$namabarang', deskripsi='$deskripsi', image='$image' WHERE idbarang='$idb'");
        if($update){
            header('location:index.php');
        } else {
            echo 'Gagal';
            header('location:index.php');
        }
    }

    
}

//menghapus data user 
if(isset($_POST['hapususer'])){
    $iduser = $_POST['iduser'];
    $hapus = mysqli_query($conn, "DELETE FROM login WHERE iduser='$iduser'");
    if($hapus){
        header('location:user.php');
    } else {
        echo 'Gagal';
        header('location:user.php');
    }
}

//menghapus barang stock 
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb']; //idbarang

    $gambar = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $get = mysqli_fetch_array($gambar);
    $img = 'images/'.$get['image'];
    unlink($img);

    $hapus = mysqli_query($conn, "DELETE FROM stock WHERE idbarang='$idb'");
    if($hapus){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

// mengubah data barang masuk
if (isset($_POST['updatebarangmasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stocksekarang = $stocknya['stock'];

    $qtysekarang = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtysekarang);
    $qtysekarang = $qtynya['qty'];

    if ($qty > $qtysekarang) {
        $selisih = $qty - $qtysekarang;
        $kurangin = $stocksekarang + $selisih;
    } else {
        $selisih = $qtysekarang - $qty;
        $kurangin = $stocksekarang - $selisih;
    }

    $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
    $updatenya = mysqli_query($conn, "UPDATE masuk SET qty='$qty', keterangan='$deskripsi' WHERE idmasuk='$idm'");

    if ($kurangistocknya && $updatenya) {
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}


//menghapus barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn,"SELECT * FROM stock WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock-$qty;

    $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk='$idm'");

    if($update&&$hapusdata){
        header('location:masuk.php');
    } else{
        header('location:masuk.php');
    }
}


// Mengubah data barang keluar
if (isset($_POST['updatebarangkeluar'])) {
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stocksekarang = $stocknya['stock'];

    $qtysekarang = mysqli_query($conn, "SELECT * FROM keluar WHERE idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtysekarang);
    $qtysekarang = $qtynya['qty'];

    if ($qty > $qtysekarang) {
        $selisih = $qty - $qtysekarang;
        $kurangin = $stocksekarang - $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE keluar SET qty='$qty', penerima='$penerima' WHERE idkeluar='$idk'");
        if ($kurangistocknya && $updatenya) {
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
        }
    } else {
        $selisih = $qtysekarang - $qty;
        $kurangin = $stocksekarang + $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE keluar SET qty='$qty', penerima='$penerima' WHERE idkeluar='$idk'");
        if ($kurangistocknya && $updatenya) {
            header('location:keluar.php');
            } else {
                echo 'Gagal';
                header('location:keluar.php');
            }
    }
}

// Menghapus barang keluar
if (isset($_POST['hapusbarangkeluar'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk']; 
    $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock + $qty;

    $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE FROM keluar WHERE idkeluar='$idk'");

    if ($update && $hapusdata) {
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }
}


//Tambah Admin
if(isset($_POST['addadmin'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $queryinsert = mysqli_query($conn,"insert into login (username, password) values ('$username','$password')");

    if($queryinsert){
        //berhasil
        header('location:admin.php');
    } else{
        //gagal
        header('location:admin.php');
    }
}

?>