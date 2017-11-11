
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="../../favicon.ico">

    <title>NhaNghiViet.com</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ url('/') }}/public/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/') }}/public/font-awesome/css/font-awesome.min.css">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ url('/') }}/public/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ url('/') }}/public/css/jumbotron-narrow.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/public/css/sweetalert.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link  href="{{ url('/') }}/public/css/jquery.fancybox.min.css" rel="stylesheet">
    <script src="{{ url('/') }}/public/js/jquery.fancybox.min.js"></script>
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="{{ url('/') }}/public/js/ie-emulation-modes-warning.js"></script>

    <script src="{{ url('/') }}/public/js/sweetalert.min.js"></script>
    <script src="{{ url('/') }}/public/js/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">

      #loading{
        position: fixed;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);;
        z-index: 999;
        margin: 0;
        margin: -50px -30px;
        opacity: 1;
      }
      #loading .circle {
        width: 200px;
        height: 200px;
        background: #003a34;
        border-radius: 50%;
        overflow: hidden;
        border: 6px solid #fff;
        box-shadow: 0 0 1px rgba(0, 0, 0, .7),
          inset 0 0 1px rgba(0, 0, 0, .7),
          0 4px 4px rgba(0, 0, 0, .3),
          inset 0px 0px 0px 29px rgba(0, 58, 52, 1),
          inset 0px 0px 0px 30px rgba(50, 120, 80, 1),
          inset 0px 0px 0px 59px rgba(0, 58, 52, 1),
          inset 0px 0px 0px 60px rgba(50, 120, 80, 1),
          inset 0px 0px 0px 89px rgba(0, 58, 52, 1),
          inset 0px 0px 0px 90px rgba(50, 120, 80, 1);
        position: absolute;
        top:50%;
        left:50%;
        margin-top:-100px; /* this is half the height of your div*/  
        margin-left:-100px;
        z-index: 1000;
      }
      #loading .tr {
        width: 200px;
        height: 200px;
        position: relative;
        animation: rt 3s infinite linear;
        border-radius: 50%;
        overflow: hidden;
        left: -6px;
        top: -6px;
      }
      #loading .tr:after {
        content: '';
        width: 50%;
        height: 50%;
        top: 0px;
        background: linear-gradient(-90deg, rgba(0,58,52,.5) 0%,rgba(0,0,0,0) 100%),
        linear-gradient(to bottom, rgba(0,244,0,1) 0%,rgba(0,58,52,0) 100%);
        transform:rotate(90deg);
        position: absolute;
        border-top: 1px solid #29eb2b;
      }

      #data-return{
        text-align: left;
      }

      #data-return p{
        font-size: 14px;
        margin: 0 0 5px 0;
      }

      #data-return .product{
        border-top: 1px solid #eee;
        margin-bottom: 5px;
      }

      #data-return .number-room{
        font-size: 16px;
        color: blue;
      }

      #data-return .min-price{
        font-size: 16px;
        color: #ff00a3;
        font-weight: bold;
      }

      #data-return .text-uppercase{
        font-size: 24px;
      }

      .hotel-name{
        color:#2196F3;
        cursor: pointer;
      }

      @keyframes rt {
        from {
          transform:rotate(0deg);
        }
        to {
          transform:rotate(360deg);
        }
      }

    </style>
  </head>
  <body>
    <?php 
        $cities = \App\City::where('active', '=', '1')->pluck('name', 'id');
    ?>
    <div id="loading" style="display: none;">
      <div class="circle">
        <div class="tr"></div>
      </div>
    </div>
    <div class="container">
      <div class="header clearfix">
        <h3 class="text-muted">NhaNghiViet.com</h3>
      </div>

      <div class="jumbotron">
        <h1>Chọn khu vực <br/> tìm kiếm</h1>
        <p class="lead">
            <form class="form-horizontal">
              <div class="form-group">
                <div class="col-sm-12">
                    <select class="form-control" id="city" name="city">
                        <option value="0">Chọn Tỉnh / Thành phố</option>
                        @foreach($cities as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-12">
                    <select class="form-control" id="district" name="district">
                        <option value="0">Chọn Quận / Huyện</option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-12">
                    <select class="form-control" id="town" name="town">
                        <option value="0">Chọn Phường / Xã</option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-12">
                  <div class="btn btn-lg btn-success" id="search-btn">Tìm kiếm</div>
                </div>
              </div>
            </form>
        </p>
      </div>

      <div class="jumbotron" id="data-return" style="display: none;">
      </div>
      <footer class="footer">
        <p>&copy; 2017 NhaNghiViet.com</p>
      </footer>
    </div> <!-- /container -->

    <!-- Modal -->
    <div class="modal fade" id="showMap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Chỉ đường</h4>
          </div>
          <div class="modal-body">
            <div id="mapCanvas" style="width: 100%; height: 400px"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="{{ url('/') }}/public/js/ie10-viewport-bug-workaround.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#city").change(function () {
                var citId = $("#city").val();
                $('#loading').show();
                var request = $.ajax({
                    url: "{{ URL::to('/') }}/getDistrict/" + citId,
                    method: "GET",
                    dataType: "html"
                });

                request.done(function (msg) {
                  $('#loading').hide();
                  $("#district").html(msg);
                });

                request.fail(function (jqXHR, textStatus) {
                  $('#loading').hide();
                  swal("Cảnh báo", "Đã có lỗi khi lấy Quận / Huyện!", "error");
                });
            });

            $("#district").change(function () {
                var districtId = $("#district").val();
                $('#loading').show();
                var request = $.ajax({
                    url: "{{ URL::to('/') }}/getTown/" + districtId,
                    method: "GET",
                    dataType: "html"
                });

                request.done(function (msg) {
                    $('#loading').hide();
                    $("#town").html(msg);
                });

                request.fail(function (jqXHR, textStatus) {
                  $('#loading').hide();
                  swal("Cảnh báo", "Đã có lỗi khi lấy Phường / Xã!", "error");
                });
            });

            $('#search-btn').click(function(){
                if($('#city').val() <= 0){
                    swal("Thông báo", "Bạn chưa chọn Tỉnh / Thành Phố!", "error");
                    return false;
                }else{
                    if($('#district').val() <= 0){
                        swal("Thông báo", "Bạn chưa chọn Quận / Huyện!", "error");
                        return false;
                    }else{
                        if($('#town').val() <= 0){
                            swal("Thông báo", "Bạn chưa chọn Phường / Xã!", "error");
                            return false;
                        }
                    }
                }

                $('#loading').show();

                var cityId = $("#city").val();
                var districtId = $("#district").val();
                var townId = $("#town").val();
                var from = 0;
                var number_get = 10;
                var request = $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ URL::to('/') }}/getHotelInTown",
                    method: "POST",
                    data: {
                            'city'          : cityId,
                            'district'      : districtId,
                            'town'          : townId,
                            'from'          : from,
                            'number_get'    : number_get,
                        },
                    dataType: "json"
                });

                request.done(function (msg) {
                  $('#loading').hide();
                  if(msg.code == 200){
                    $('#data-return').show();
                    var $html = '';
                    $(msg.dataReturn).each(function( index ) {
                      var this1 = $(this)[0][1];
                      $html += '<div class="row product" style="display: block;">';
                      $html += '<div class="col-md-3 col-lg-4">';
                      for(var z = 0; z < this1.images.length; z++){
                        if(z==0){
                        $html += '<a data-fancybox="gallery'+ this1.id +'" href="http://quanlynhanghi.local/public/images/'+ this1.images[z] +'">';
                        }else{
                        $html += '<a data-fancybox="gallery'+ this1.id +'" href="http://quanlynhanghi.local/public/images/'+ this1.images[z] +'" class="hide">';
                        }
                        $html += '<img src="http://quanlynhanghi.local/public/images/'+ this1.images[z] +'" alt="Lights" style="width:100%">';
                        $html += '</a>';
                      };
                      $html += '</div>';
                      $html += '<div class="col-md-9 col-lg-8">';
                      $html += '<h3 class="hotel-name">Nhà nghỉ '+ this1.hotelName +'</h3>';
                      $(this1.room_type).each(function( index ) {
                        var this2 = $(this)[0];
                        $html += '<p>Giá '+ this2.name +' : <span class="min-price">'+ Number(this2.rtP1).toLocaleString('de-DE') +'</span> / Giờ, <span class="min-price">'+ Number(this2.rtP2).toLocaleString('de-DE') +'</span> / Đêm, <span class="min-price">'+ Number(this2.rtP3).toLocaleString('de-DE') +'</span> / Ngày</p>';
                      });
                      $html += '<p>Địa chỉ : '+ this1.address +' - '+ this1.townName +' - '+ this1.districtName +' - '+ this1.cityName +'</p>';
                      $html += '<p>Điện thoại : <span class="min-price">'+ this1.phone +'</span></p>';
                      $html += '<i class="fa fa-heart" aria-hidden="true" style="color: red;"></i>160';
                      $html += '</div>';
                      $html += '</div>';
                    });
                    $('#data-return').html($html);

                    $('.hotel-name').off('click');
                    $('.hotel-name').click(function(){
                      $('#showMap').modal('show');
                    });
                    $('#data-return').show();
                    $('html,body').animate({
                      scrollTop: $("#data-return").offset().top},
                      'slow');
                  }
                });

                request.fail(function (jqXHR, textStatus) {
                  $('#loading').hide();
                  swal("Cảnh báo", "Đã có lỗi khi lấy Phường / Xã!", "error");
                });
            });
        });

        function initMap() {
          var uluru = {lat: -25.363, lng: 131.044};
          var map = new google.maps.Map(document.getElementById('mapCanvas'), {
            zoom: 13,
            center: uluru
          });
          var marker = new google.maps.Marker({
            position: uluru,
            map: map
          });
        }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAB_t6mHxRBgGoBNEQx8vpFUkWxHX5WOZA&callback=initMap">
    </script>
  </body>
</html>
