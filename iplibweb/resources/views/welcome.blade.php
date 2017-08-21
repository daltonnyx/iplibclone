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
            <div class="row valign-wrapper">
                <form class="col s12 search" action="search" method="get">
                    <div class="row">
                        <div class="input-field col s12">
                          <input id="ten-nhan-hieu" name="ten_nhan_hieu" type="text" class="validate">
                          <label for="ten-nhan-hieu">Tên nhãn hiệu</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                          <input id="nhom-sp-dv" name="nhom" type="text" class="validate">
                          <label for="nhom-sp-dv">Nhóm SP/DV</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                          <input id="ten-sp-dv" name="ten_nhom" type="text" class="validate">
                          <label for="ten-sp-dv">Tên SP/DV</label>
                        </div>
                    </div>
                    <div class="row more">
                        <div class="input-field col s12">
                          <input id="dai-dien-shtt" name="dai_dien_shtt" type="text" class="validate">
                          <label for="dai-dien-shtt">Đại diện SHTT</label>
                        </div>
                    </div>
                    <div class="row more">
                        <div class="input-field col s12">
                          <input id="so-don" name="so_hieu" type="text" class="validate">
                          <label for="so-don">Số đơn</label>
                        </div>
                    </div>
                    <div class="row more">
                        <div class="input-field col s12">
                          <input id="nguoi-nop-don" name="nguoi_nop_don" type="text" class="validate">
                          <label for="nguoi-nop-don">Người nộp đơn</label>
                        </div>
                    </div>
                    <div class="row more">
                        <div class="input-field col s12">
                          <input id="dia-chi-nguoi-nop-don" name="dia_chi_nguoi_nop_don" type="text" class="validate">
                          <label for="dia-chi-nguoi-nop-don">Địa chỉ người nộp đơn</label>
                        </div>
                    </div>
                    <div class="row more">
                        <div class="input-field col s12">
                          <input id="ngay-nop-don" name="ngay_nop_don" type="text" class="validate">
                          <label for="ngay-nop-don">Ngày nộp đơn</label>
                        </div>
                    </div>
                    <div class="row more">
                        <div class="input-field col s12">
                          <input id="so-bang" name="so_bang" type="text" class="validate">
                          <label for="so-bang">Số bằng</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 center-align">
                            <button type="submit" class="waves-effect waves-light btn">Tìm kiếm</button>
                        </div>
                    </div>
                    <a class="valign-wrapper expand-link" href="#more">Mở rộng <i class="material-icons">expand_more</i></a>
                </form>
            </div>
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
