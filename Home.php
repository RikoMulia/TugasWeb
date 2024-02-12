<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('inputberangkat');
    }

    public function proses(){
        $nobp = $this->request->getPost('nobp');
        $nama = $this->request->getPost('nama');
        $uts = $this->request->getPost('uts');
        $uas = $this->request->getPost('uas');
        echo "Nobp : $nobp <br>";
        echo "Nama : $nama <br>";
        echo "Uts : $uts <br>";
        echo "Uas : $uas <br>";
        $hasil = ($uas + $uts)/2;
        echo $hasil;
    }

    public function jumlah(){
        $kode = $this->request->getPost('kode');
        $jenis = $this->request->getPost('jenis');
        $harga = $this->request->getPost('harga');
        $jumlah = $this->request->getPost('jumlah');
        $total = $this->request->getPost('total');
        echo "kode :  $kode <br>";
        echo "agenda : $jenis <br>";
        echo "transportasi : $harga <br>";
        echo "penginapan : $jumlah<br>";
        echo "total : $total <br>";
    }

    public function hitung(){
        $bakso = $this->request->getPost('bakso')*10000;
        $siomay = $this->request->getPost('siomay')*12000;
        $miayam = $this->request->getPost('miayam')*12000;
        $tehes = $this->request->getPost('tehes')*4000;
        $member = $this->request->getPost('member');
        $total = $this->request->getPost('total')+$bakso+$siomay+$miayam+$tehes;
        $diskon = 0;

        if($member == "ya"){
            $diskon = ($total * 20 )/100;
            $total1 = $total - $diskon;
            echo "bakso :  $bakso <br>";
            echo "siomay : $siomay <br>";
            echo "miayam : $miayam <br>";
            echo "tehes : $tehes <br>";
            echo "harga : $total <br>";
            echo "member : $member <br>";
            echo "jumlah discount: $diskon  <br>"; 
            echo "total harga : $total1<br>";
        } else{
            echo "bakso :  $bakso <br>";
            echo "siomay : $siomay <br>";
            echo "miayam : $miayam <br>";
            echo "teh es : $tehes <br>";
            echo "member : $member <br>"; 
            echo "total : $total<br>";
        }

        echo '<form action="index">
        <input type="submit" value="Pesan lagi">
                </form>';
        
    }

    public function simpan(){
        $db = \Config\Database::connect();
        $data = [
            'kode' => $this->request->getPost('kode'),
            'jenis' => $this->request->getPost('jenis'),
            'harga' => $this->request->getPost('harga'),
            'jumlah' => $this->request->getPost('jumlah'),
            'total' => $this->request->getPost('total'),
        ];
        $simpan = $db->table('sppd')->insert($data);
        if($simpan = TRUE){
            echo "<script>
            alert('data berhasil disimpan');
            window.location = '/home/tampil';
        </script>";

        }else{
            echo "<script>
            alert('data gagal disimpan');
            window.location = '/home/sppd';
        </script>";
        }             
    }

    public function tampil(){
        $db = \Config\Database::connect();
        $builder = $db->table('sppd');
        $query = $builder->get();
        $data['sppdok'] = $query->getResultArray();
        return view ('tampilsppd',$data);
    }

    public function simpanbakso(){
        $idpesan = $this->request->getPost('idpesan');
        $bakso = $this->request->getPost('bakso')*10000;
        $siomay = $this->request->getPost('siomay')*12000;
        $miayam = $this->request->getPost('miayam')*12000;
        $tehes = $this->request->getPost('tehes')*4000;
        $member = $this->request->getPost('member');
        $total = $this->request->getPost('total')+$bakso+$siomay+$miayam+$tehes;
        $diskon = 0;

        if($member == "ya"){
            $diskon = ($total * 20 )/100;
            $total1 = $total - $diskon;
        }else{
            $total1 = $total;
        }

        $db = \Config\Database::connect();
        $data = [
            'idpesanan' => $idpesan,
            'bakso' => $bakso,
            'siomay' => $siomay,
            'mieayam' => $miayam,
            'tehes' => $tehes,
            'member' => $member,
            'diskon' => $diskon,
            'total' => $total1,
        ];
        $simpan = $db->table('pesanan')->insert($data);
        if($simpan = TRUE){
            echo "<script>
            alert('data berhasil disimpan');
            window.location = '/home/tampilbakso';
        </script>";

        }else{
            echo "<script>
            alert('data gagal disimpan');
            window.location = '/home/pesanan';
        </script>";
        }             
    }

    public function tampilbakso(){
        $db = \Config\Database::connect();
        $builder = $db->table('pesanan');
        $query = $builder->get();
        $data['pesananok'] = $query->getResultArray();
        return view ('tampilbakso',$data);
    }
}
