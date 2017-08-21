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
            <div class="pagination row">
                <div class="col s6">
                    Trang {{app('request')->input('page') ?? 1}} / {{$total_page}} 
                </div>
                <div class="col s6">
                    @for($i = 1; $i < $total_page; $i++)
                    <li><a href="{{url()->current()}}">{{$i}}</a></li>
                    @endfor
                </div>
            </div>
            <table class="bordered striped responsive-table">
                <thead><tr>
                    <th>#</th>
                    <th>Nhãn hiệu</th>
                    <th>Số đơn</th>
                    <th>Ngày nộp đơn</th>
                    <th>Số bằng</th>
                    <th>Tên chủ đơn</th>
                    <th>Nhóm sản phẩm</th>
                    <th>Ảnh</th>
                </tr></thead>
                <tbody>
                @foreach ($thuong_hieus as $thuong_hieu)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$thuong_hieu->ten_nhan_hieu}}</td>
                        <td><a href="{{url('/thuong_hieu/'.$thuong_hieu->so_hieu)}}">{{$thuong_hieu->so_hieu}}</a></td>
                        <td>{{$thuong_hieu->ngay_nop_don}}</td>
                        <td>{{$thuong_hieu->so_bang}}</td>
                        <td>{{$thuong_hieu->chu_so_huu}}</td>
                        <td>{!!$thuong_hieu->get_nhoms()!!}</td>
                        <td><img width="128" src="{{$thuong_hieu->logo}}" /></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <style>
            
            .more {display:none;}
            .expanded .more {
                display:inherit;
            }
            .search {
                position: relative;
            }
            .expand-link {
                position: absolute;
                bottom: 20px;
                right: 0px;
            }
        </style>
        
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.1/js/materialize.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.1/css/materialize.min.css" />
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $(".expand-link").click(function(e){
                    e.preventDefault();
                    $(".search").toggleClass("expanded");
                });
            });
        </script>
    </body>
</html>
