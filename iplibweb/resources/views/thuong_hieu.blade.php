<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tìm kiếm thương hiệu</title>
    </head>
    <body>
        <div class="container">
            <table class="bordered striped">
                <thead>
                    <tr>
                        <th>Tên trường</th>
                        <th>Giá trị</th>
                    </tr>
                </thead>
                <tbody>
                <tr>                
                    <td>SỐ ĐƠN</td>
                    <td>{{$thuong_hieu->so_hieu}}</td>
                </tr>
                <tr>
                    <td>NGÀY NỘP ĐƠN</td>
                    <td>{{$thuong_hieu->ngay_nop_don}}</td>
                </tr>


                <tr>

                    <td  >TÊN NHÃN HIỆU</td>
                    <td  >{{$thuong_hieu->ten_nhan_hieu}}</td>			  
                </tr>

                <tr>

                    <td>Logo</td>
                    <td  >
                        <img src="{{$thuong_hieu->logo}}" />
                    </td>
                </tr>

                <tr>

                <td  >LOẠI NHÃN HIỆU</td>
                <td  >{{$thuong_hieu->loai_nhan_hieu}}</td>
                </tr>


                <tr>

                <td  >MÀU NHÃN HIỆU</td>
                <td  >{{$thuong_hieu->mau_nhan_hieu}}</td>
                </tr>

                <tr >

                <td  >NHÓM SẢN PHẨM / DỊCH VỤ</td>
                <td  >{!!$thuong_hieu->get_nhoms()!!}</td>

                </tr>

                <tr>

                <td  >NỘI DUNG KHÁC</td>
                <td  >{{$thuong_hieu->noi_dung_khac}}</td>
                </tr>

                <tr>

                <td  >PHÂN LOẠI HÌNH</td>
                <td  >{{$thuong_hieu->get_phan_loai_hinh()}}</td>
                </tr>

                <tr>

                <td   >NGƯỜI NỘP ĐƠN / CHỦ SỞ HỮU </td>
                <td   >{{$thuong_hieu->chu_so_huu}}</td>
                </tr>
                <tr>

                <td   >ĐỊA CHỈ NGƯỜI NỘP ĐƠN</td>
                <td   >{{$thuong_hieu->dia_chi_nguoi_nop_don}}</td>
                </tr>

                <tr>

                <td   >ĐỊA CHỈ CHỦ SỞ HỮU </td>
                <td   >{{$thuong_hieu->dia_chi_nguoi_so_huu}}</td>
                </tr>

                <tr>

                <td   >SỐ VĂN BẰNG</td>
                <td   >{{$thuong_hieu->so_bang}}</td>
                </tr>

                <tr>

                <td   >NGÀY CẤP BẰNG</td>
                <td   >{{$thuong_hieu->ngay_cap_bang}}</td>
                </tr>

                <tr>

                <td   >NGÀY CÔNG BỐ BẰNG</td>
                <td   >{{$thuong_hieu->ngay_cong_bo_bang}}</td>
                </tr>

                <tr>

                <td   >SỐ LẦN GIA HẠN</td>
                <td   >{{$thuong_hieu->so_lan_gia_han}}</td>
                </tr>

                <tr>

                <td   >NGÀY HẾT HẠN</td>
                <td   >{{$thuong_hieu->ngay_het_han}}</td>
                </tr>

                <tr>

                <td   >TỔ CHỨC ĐẠI DIỆN</td>
                <td   >{{$thuong_hieu->to_chuc_dai_dien_shtt}}</td>
                </tr>
                <tr>

                <td   >TÀI LIỆU TRUNG GIAN</td>
                <td   >
                    {{$thuong_hieu->get_tai_lieu()}}
                </tr>

                

    </tbody>
            </table>           
        </div>
                
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.1/js/materialize.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.1/css/materialize.min.css" />
    </body>
</html>
