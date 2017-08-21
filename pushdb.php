<?php
$data_files = scandir('./data');
array_shift($data_files);
array_shift($data_files);
foreach($data_files as $file) {
    if(isRead($file) > 0 && !isModified($file)) {
        echo "skipping $file \r\n";
        continue;
    }
        
    $resource = fopen("./data/$file", "r");
    if($content = fread($resource, filesize("./data/$file"))) {
        $doc = new DOMDocument();
        echo "reading $file \r\n";
        @$doc->loadHTML("<html><head><meta charset=\"UTF-8\"></head><body>$content</body></html>");
        $table = $doc->getElementsByTagName("table")->item(0);
        $matches = [];
        preg_match_all("/[\n\s]+(.+)/", $table->nodeValue, $matches);
        $array_data = $matches[1];
        //echo var_dump($array_data);
        $data = array();
        foreach($array_data as $idx => $sample) {
            if($idx < 1) continue;
            switch(trim($array_data[$idx - 1])) {
                case 'SỐ ĐƠN':
                    $data["so_don"] = trim($sample);
                    break;
                case 'NGÀY NỘP ĐƠN':
                    $data["ngay_nop_don"] = trim($sample);
                    break;
                case 'NGÀY ƯU TIÊN':
                    $data["ngay_uu_tien"] = trim($sample);
                    break;
                case 'TÊN NHÃN HIỆU':
                    $data["ten_nhan_hieu"] = trim($sample);
                    break;
                case 'LOẠI NHÃN HIỆU':
                    $data["loai_nhan_hieu"] = trim($sample);
                    break;
                case 'MÀU NHÃN HIỆU':
                    $data["mau_nhan_hieu"] = trim($sample);
                    break;
                case 'NỘI DUNG KHÁC':
                    $data["noi_dung_khac"] = trim($sample);
                    break;
                case 'NHÓM SẢN PHẨM / DỊCH VỤ':
                    $data["nhom"] = preg_split("/(\.\s+(?=\d+)|\.$|$)/",trim($sample));
                    array_pop($data["nhom"]);
                    break;
                case 'NGƯỜI NỘP ĐƠN / CHỦ SỞ HỮU':
                    $data['chu_so_huu'] = trim($sample);
                    break;
                case 'ĐỊA CHỈ NGƯỜI NỘP ĐƠN':
                    $data["dia_chi_nguoi_nop_don"] = trim($sample);
                    break;
                case 'ĐỊA CHỈ CHỦ SỞ HỮU':
                    $data["dia_chi_chu_so_huu"] = trim($sample);
                    break;
                case 'SỐ BẰNG':
                    $data["so_bang"] = trim($sample);
                    break;
                case 'NGÀY CẤP BẰNG':
                    $data["ngay_cap_bang"] = trim($sample);
                    break;
                case 'NGÀY CÔNG BỐ BẰNG':
                    $data["ngay_cong_bo_bang"] = trim($sample);
                    break;
                case 'NGÀY HẾT HẠN':
                    $data["ngay_het_han"] = trim($sample);
                    break;
                case 'SỐ LẦN GIA HẠN':
                    $data["so_lan_gia_han"] = trim($sample);
                    break;
                case 'MÃ SỐ YÊU CẦU': case 'MÃ SỐ YÊU CẦU GIA HẠN':
                    $data["ma_so_yeu_cau"] = trim($sample);
                    break;
                case 'TỔ CHỨC ĐẠI DIỆN SHTT':
                    $data["to_chuc_dai_dien_shtt"] = trim($sample);
                case 'TÀI LIỆU TRUNG GIAN':
                    $data["tai_lieu"] = array();
                    $i = 1;
                    while($idx + $i < count($array_data) && trim($array_data[$idx+$i]) != "") {
                        $data["tai_lieu"][] = $array_data[$idx+$i];
                        $i++;
                    }
                    break;
                case 'CHỦ CŨ':
                    $i = $idx+2;
                    while($array_data[$i] < count($array_data) && trim($array_data[$i]) != "(111)") {
                        $data["chu_cu"] = array(
                            "chu_so_huu" => $array_data[$i],
                            "dia_chi_chu_so_huu" => $array_data[$i+1],
                        );
                        $i+=2;
                    }
                    break;
                case 'PHÂN LOẠI HÌNH':
                    $i = $idx;
                    $data["phan_loai_hinh"] = array();
                    while($array_data[$i] < count($array_data) && trim($array_data[$i]) != "(731) / (732)") {
                        $data["phan_loai_hinh"][] = trim($array_data[$i]);
                        $i+=1;
                    }
                    break;
                    
                default: continue; break;
            }
        }
        //Now get logo file
        $imgTag = $doc->getElementsByTagName("img");
        $imgURL = $imgTag->item(0)->getAttribute("src");
        $data["logo"] = $imgURL;
        //echo var_dump($data);
        //Here we have $data now we need to push it to db
        createdata($data, $file); 
    }
}

function isRead($file) {
    $dbc = new PDO("mysql:host=localhost;dbname=iplibclone;charset=utf8", "root","haymora113");
    $rows = $dbc->query("SELECT id FROM read_data WHERE file_name = '$file'");
    return $rows->rowCount();
}

function isModified($file) {
    $dbc = new PDO("mysql:host=localhost;dbname=iplibclone;charset=utf8", "root","haymora113");
    $s = $dbc->query("SELECT hash_data from read_data where file_name='$file'");
    $row = $s->fetch(PDO::FETCH_ASSOC);
    return $row['hash_data'] != hash_file('md5', './data/'.$file);
}

function createdata($data, $file) {
    $dbc = new PDO("mysql:host=localhost;dbname=iplibclone;charset=utf8", "root","haymora113");
    echo "insert ".$data['so_don']." to db \r\n";
    $nhom_ids = array();
    if(isset($data["nhom"])) {
        foreach($data["nhom"] as $nhom) {
            if(trim($nhom) == "") continue;
            $matches = array();
            preg_match("/(\d+)\s*(.+)/",$nhom,$matches);
            $id = $matches[1];
            $name = $matches[2];
            $result = $dbc->query("SELECT id FROM iplibclone.loai_san_pham where ma_spdv = '$id' and ten = '$name'");
            if($result !== false && $result->rowCount() == 0) {
               $dbc->exec("INSERT INTO iplibclone.loai_san_pham (ten, ma_spdv) VALUES ('$name', '$id');");
               $nhom_ids[] = $dbc->lastInsertId();
            }
            else if($result !== false) {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $nhom_ids[] = $row['id'];
            }
        }
    }
    $res = $dbc->query("SELECT id from iplibclone.thuong_hieu where so_hieu='".$data['so_don']."'");
    $isNew = true;
    
    if( $res !== false && $res->rowCount() == 0 ) {
    $script = "INSERT INTO iplibclone.thuong_hieu (so_hieu,ten_nhan_hieu,ngay_nop_don,ngay_uu_tien,logo,loai_nhan_hieu,mau_nhan_hieu,noi_dung_khac,chu_so_huu,dia_chi_nguoi_nop_don,dia_chi_nguoi_so_huu,so_bang,ngay_cap_bang,ngay_cong_bo_bang,ngay_het_han,tai_lieu,phan_loai_hinh,chu_cu,so_lan_gia_han, to_chuc_dai_dien_shtt)";
    $script .= "VALUE("
            . "'".@$data['so_don']."', "
            . "'".@$data['ten_nhan_hieu']."', "
            . "'".@get_date($data['ngay_nop_don'])."', "
            . "'".@get_date($data['ngay_uu_tien'])."', "
            . "'".@$data['logo']."', "
            . "'".@$data['loai_nhan_hieu']."', "
            . "".@$data['mau_nhan_hieu'].", "
            . "'".@$data['noi_dung_khac']."', "
            . "'".@$data['chu_so_huu']."', "
            . "'".@$data['dia_chi_nguoi_nop_don']."', "
            . "'".@$data['dia_chi_chu_so_huu']."', "
            . "'".@$data['so_bang']."', "
            . "'".@get_date($data['ngay_cap_bang'])."', "
            . "'".@get_date($data['ngay_cong_bo_bang'])."', "
            . "'".@get_date($data['ngay_het_han'])."', "
            . "'".@serialize($data['tai_lieu'])."', "
            . "'".@serialize($data['phan_loai_hinh'])."', "
            . "'".@serialize($data['chu_cu'])."', "
            . "".@($data['so_lan_gia_han'] == "" ? 0 : $data['so_lan_gia_han']).", "
            . "'".@$data['to_chuc_dai_dien_shtt']."'"
            . ");";
    }
    else if($res->rowCount() > 0) {
        extract($data);
        @$script = "UPDATE iplibclone.thuong_hieu SET ten_nhan_hieu = '$ten_nhan_hieu', ngay_nop_don = '".get_date($ngay_nop_don)."', ngay_uu_tien = '".get_date($ngay_uu_tien)."', ".
            "logo = '$logo', loai_nhan_hieu = '$loai_nhan_hieu', mau_nhan_hieu = $mau_nhan_hieu, noi_dung_khac = '$noi_dung_khac', chu_so_huu = '$chu_so_huu', dia_chi_nguoi_nop_don = '$dia_chi_nguoi_nop_don', ".
            "dia_chi_nguoi_so_huu = '$dia_chi_chu_so_huu', so_bang = '$so_bang', ngay_cap_bang = '".get_date($ngay_cap_bang)."', ngay_cong_bo_bang = '".get_date($ngay_cong_bo_bang)."', ".
            "ngay_het_han = '".get_date($ngay_het_han)."', tai_lieu = '".serialize($tai_lieu)."', phan_loai_hinh = '".serialize($phan_loai_hinh)."', chu_cu = '".serialize($chu_cu)."', ".
            "so_lan_gia_han = ". ($so_lan_gia_han == "" ? 0 : $so_lan_gia_han) .", to_chuc_dai_dien_shtt = '$to_chuc_dai_dien_shtt' WHERE so_hieu = '$so_don';";
        $isNew = false;
    }
    $dbc->exec($script);
    $row_id = $dbc->lastInsertId();
    if($isNew) {
        foreach($nhom_ids as $nhom) {
            $dbc->exec("INSERT INTO thuong_hieu_loai(thuong_hieu, loai)VALUE($row_id, $nhom)");
        }
    }
    $hash = hash_file('md5', './data/'.$file);
    if($isNew) {
        $dbc->exec("INSERT INTO read_data(file_name, key_id, hash_data)VALUE('$file', '".$data['so_don']."','$hash')");
    }
    else {
        $dbc->exec("UPDATE read_data SET hash_data = '$hash' WHERE file_name = '$file'");
    }
}


function get_date($string){
    $matches = array();
    preg_match("/(\d+)\/(\d+)\/(\d+)/", $string, $matches);
    return $matches[3].'-'.$matches[2].'-'.$matches[1];
}
