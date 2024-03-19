    <div class="az-footer ht-40">
      <div class="container ht-100p pd-t-0-f">
        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © Kalai<?php echo date("Y");?></span>
        <!-- <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin templates</a> from Bootstrapdash.com</span> -->
      </div><!-- container -->
    </div><!-- az-footer -->


    <script src="../resources/lib/jquery/jquery.min.js"></script>
    <script src="../resources/lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="../resources/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../resources/lib/ionicons/ionicons.js"></script>
    <script src="../resources/lib/jquery.flot/jquery.flot.js"></script>
    <script src="../resources/lib/jquery.flot/jquery.flot.resize.js"></script>
    <script src="../resources/lib/chart.js/Chart.bundle.min.js"></script>
    <script src="../resources/lib/peity/jquery.peity.min.js"></script>
    <script src="../resources/lib/select2/js/select2.min.js"></script>
    <script src="../resources/js/azia.js"></script>
    <script src="../resources/js/chart.flot.sampledata.js"></script>
    <script src="../resources/lib/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
    <script src="../resources/js/dashboard.sampledata.js"></script>
    <script src="../resources/lib/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>
    <script src="../resources/lib/jquery-simple-datetimepicker/jquery.simple-dtpicker.js"></script>
    <script src="../resources/lib/pickerjs/picker.min.js"></script>
    <script>
       $(function(){
        $('.select2').select2({
            placeholder: 'Choose one',
            searchInputPlaceholder: 'Search'
          });

           // Datepicker
        $('.fc-datepicker').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true
        });
        
        // Toggle Switches
        $('.az-toggle').on('click', function(event){
          let retrunval = false;
          var symbol = $(this).data("symbol");
          // console.log(symbol);
          window.location.href = "http://localhost:8086/addwatchlist/"+symbol;


          // var watchlistID = $(this).data("listid");
          // let this_val = $(this);
          // this_val.toggleClass('on');
          // $.ajax({
          //   type: "POST",
          //   data: {info_symbol:symbol},
          //   url: "/addwatchlist",
          //   dataType: 'JSON',
          //   success: function(dataval){
              
          //     console.log(dataval);
              
          //     }
          //   });

        });
      });
      </script>
  </body>
</html>
