<?php


$label_val = array('dec','jan','sss');
$chart_gain = array('123','323','4123');
$chart_lose = array('123','323','4123');
$max_gain_amt = max($chart_gain);
$max_loss_amt = max($chart_lose);
$chart_max_amt = $max_gain_amt;
if($max_loss_amt>$max_gain_amt){
  $chart_max_amt = $max_loss_amt;
}
$OerallSessionAmt['OverallGain']=100;
$OerallSessionAmt['OverallPer']=100;
$chart_max_amt = 100;


?>

@include('header')
<div class="az-content az-content-dashboard">
      <div class="container">
        <div class="az-content-body">
          <div class="az-dashboard-one-title">
            <div>
              <h2 class="az-dashboard-title">Hi, welcome back!</h2>
              <p class="az-dashboard-text">Your web analytics dashboard template.</p>
            </div>
            <div class="az-content-header-right">
              
            </div>
          </div><!-- az-dashboard-one-title -->

          <!-- <div class="az-dashboard-nav"> 
            <nav class="nav">
              <a class="nav-link active" data-toggle="tab" href="#">Overview</a>
              <a class="nav-link" data-toggle="tab" href="#">Audiences</a>
              <a class="nav-link" data-toggle="tab" href="#">Demographics</a>
              <a class="nav-link" data-toggle="tab" href="#">More</a>
            </nav>

            <nav class="nav">
              <a class="nav-link" href="#"><i class="far fa-save"></i> Save Report</a>
              <a class="nav-link" href="#"><i class="far fa-file-pdf"></i> Export to PDF</a>
              <a class="nav-link" href="#"><i class="far fa-envelope"></i>Send to Email</a>
              <a class="nav-link" href="#"><i class="fas fa-ellipsis-h"></i></a>
            </nav>
          </div> -->

          <div class="row row-sm mg-b-20">
            <div class="col-lg-7 ht-lg-100p">
              <div class="card card-dashboard-one">
                <div class="card-header">
                  <div>
                    <h6 class="card-title">Website Audience Metrics</h6>
                    <p class="card-text">Audience to which the users belonged while on the current date range.</p>
                  </div>
                  <div class="btn-group">
                    <button class="btn active">Day</button>
                    <button class="btn">Week</button>
                    <button class="btn">Month</button>
                  </div>
                </div><!-- card-header -->
                <div class="card-body">
                  <div class="card-body-top">
                    <div>
                      <label class="mg-b-0">Users</label>
                      <h2>13,956</h2>
                    </div>
                    <div>
                      <label class="mg-b-0">Bounce Rate</label>
                      <h2>33.50%</h2>
                    </div>
                    <div>
                      <label class="mg-b-0">Page Views</label>
                      <h2>83,123</h2>
                    </div>
                    <div>
                      <label class="mg-b-0">Sessions</label>
                      <h2>16,869</h2>
                    </div>
                  </div><!-- card-body-top -->
                  <div class="flot-chart-wrapper">
                    <div id="flotChart" class="flot-chart"></div>
                  </div><!-- flot-chart-wrapper -->
                </div><!-- card-body -->
              </div><!-- card -->
            </div><!-- col -->
            <div class="col-lg-5 mg-t-20 mg-lg-t-0">
              <div class="row row-sm">
                <div class="col-sm-6">
                  <div class="card card-dashboard-two">
                    <div class="card-header">
                      <h6>33.50% <i class="icon ion-md-trending-up tx-success"></i> <small>18.02%</small></h6>
                      <p>Bounce Rate</p>
                    </div><!-- card-header -->
                    <div class="card-body">
                      <div class="chart-wrapper">
                        <div id="flotChart1" class="flot-chart"></div>
                      </div><!-- chart-wrapper -->
                    </div><!-- card-body -->
                  </div><!-- card -->
                </div><!-- col -->
                <div class="col-sm-6 mg-t-20 mg-sm-t-0">
                  <div class="card card-dashboard-two">
                    <div class="card-header">
                      <h6><?php echo $chart_max_amt;?> <i class="icon ion-md-trending-down tx-danger"></i> <small>0.86%</small></h6>
                      <p>Total Users</p>
                    </div><!-- card-header -->
                    <div class="card-body">
                      <div class="chart-wrapper">
                        <div id="flotChart2" class="flot-chart"></div>
                      </div><!-- chart-wrapper -->
                    </div><!-- card-body -->
                  </div><!-- card -->
                </div><!-- col -->
                <div class="col-sm-12 mg-t-20">
                  <div class="card card-dashboard-three">
                    <div class="card-header">
                      <p>All Sessions</p>
                      <h6><?php echo $OerallSessionAmt['OverallGain']; ?> <small class="tx-success"><i class="icon <?php echo ($OerallSessionAmt['OverallPer']>0 ? 'ion-md-arrow-up' : 'ion-md-arrow-down'); ?>"></i><?php echo $OerallSessionAmt['OverallPer']; ?>%</small></h6>
                      <!-- <small>The total number of sessions within the date range. It is the period time a user is actively engaged with your website, page or app, etc.</small> -->
                    </div><!-- card-header -->
                    <div class="card-body">
                      <div class="chart"><canvas id="chartBar5"></canvas></div>
                    </div>
                  </div>
                </div>
              </div><!-- row -->
            </div><!--col -->
          </div><!-- row -->

          <div class="row row-sm mg-b-20">
            <div class="col-lg-6">
              <div class="card card-dashboard-pageviews">
                <div class="card-header">
                  <span class="float-sm-right"> <a href="dashboard/topgainer" class="btn btn-sm">More</a> </span>
                  <h6 class="card-title">Top Gainer(%) </h6>
                  <p class="card-text">Overall top gainer Percentage(%).</p>
                </div><!-- card-header -->
                <div class="card-body">
                @foreach ($topGainer as $result)
                    <div class="az-list-item">
                      <div>
                        <h6>{{$result->info_name}} <span style="color:green">{{$result->priceinfo_lastprice}}</span></h6>
                        <span>{{$result->info_symbol}}<div class="az-toggle az-toggle-secondary @if(1==1) off @endif"  data-symbol="{{$result->info_symbol}}" ><span></span></div></span>
                        </div>
                        <div>
                        <h6 class="tx-primary">{{$result->priceinfo_pchange}} %</h6>
                        <span>{{$result->priceinfo_change}}</span>
                        </div>
                    </div>
                @endforeach
                </div><!-- card-body -->
              </div><!-- card -->
            </div><!-- col -->
            <div class="col-lg-6">
              <div class="card card-dashboard-pageviews">
                <div class="card-header">
                <span class="float-sm-right"> <a href="dashboard/topgainerper" class="btn btn-sm">More</a> </span>
                  <h6 class="card-title">Top Gainer(Rs.) </h6>
                  <p class="card-text">Overall top gainer Amount(Rs)</p>
                </div><!-- card-header -->
                <div class="card-body">
                @foreach ($topGainer as $result)
                    <div class="az-list-item">
                      <div>
                        <h6>{{$result->info_name}} <span style="color:green">{{$result->priceinfo_lastprice}}</span></h6>
                        <span>{{$result->info_symbol}}<div class="az-toggle az-toggle-secondary @if(1==1) off @endif"  data-symbol="{{$result->info_symbol}}" ><span></span></div></span>
                        </div>
                        <div>
                        <h6 class="tx-primary">{{$result->priceinfo_change}}</h6>
                        <span>{{$result->priceinfo_pchange}} %</span>
                        </div>
                    </div>
                @endforeach
                </div><!-- card-body -->
              </div><!-- card -->

            </div><!-- col -->
            </div><!-- row -->

          <div class="row row-sm mg-b-20">
            <div class="col-lg-6">
              <div class="card card-dashboard-pageviews">
                <div class="card-header">
                <span class="float-sm-right"> <a href="dashboard/toplooserper" class="btn btn-sm">More</a> </span>
                  <h6 class="card-title">Top Loser(%) </h6>
                  <p class="card-text">Overall top Loser Percentage(%).</p>
                </div><!-- card-header -->
                <div class="card-body">
                @foreach ($topLosserPer as $result)
                    <div class="az-list-item">
                      <div>
                        <h6>{{$result->info_name}} <span style="color:green">{{$result->priceinfo_lastprice}}</span></h6>
                        <span>{{$result->info_symbol}}<div class="az-toggle az-toggle-secondary @if(1==1) off @endif"  data-symbol="{{$result->info_symbol}}" ><span></span></div></span>
                        </div>
                        <div>
                        <h6 class="tx-danger">{{$result->priceinfo_pchange}} %</h6>
                        <span>{{$result->priceinfo_change}}</span>
                        </div>
                    </div>
                @endforeach
                </div><!-- card-body -->
              </div><!-- card -->

            </div><!-- col -->
            <div class="col-lg-6">
              <div class="card card-dashboard-pageviews">
                <div class="card-header">
                <span class="float-sm-right"> <a href="dashboard/toplooser" class="btn btn-sm">More</a> </span>
                  <h6 class="card-title">Top Loser(Rs.) </h6>
                  <p class="card-text">Overall top Loser Amount(Rs)</p>
                </div><!-- card-header -->
                <div class="card-body">
                @foreach ($topLosser as $result)
                    <div class="az-list-item">
                      <div>
                        <h6>{{$result->info_name}} <span style="color:green">{{$result->priceinfo_lastprice}}</span></h6>
                        <span>{{$result->info_symbol}}<div class="az-toggle az-toggle-secondary @if(1==1) off @endif"  data-symbol="{{$result->info_symbol}}" ><span></span></div></span>
                        </div>
                        <div>
                        <h6 class="tx-danger">{{$result->priceinfo_change}}</h6>
                        <span>{{$result->priceinfo_pchange}} %</span>
                        </div>
                    </div>
                @endforeach
                </div><!-- card-body -->
              </div><!-- card -->

            </div><!-- col -->
            
          </div><!-- row -->

          <div class="row row-sm mg-b-20">
            <div class="col-lg-6">
              <div class="card card-dashboard-pageviews">
                <div class="card-header">
                <span class="float-sm-right"> <a href="dashboard/highprice" class="btn btn-sm">More</a> </span>
                  <h6 class="card-title">Highest Price </h6>
                  <p class="card-text">Overall Highest Price Stock</p>
                </div><!-- card-header -->
                <div class="card-body">
                @foreach ($highestPrice as $result)
                    <div class="az-list-item">
                      <div>
                        <h6>{{$result->info_name}}</h6>
                        <span>{{$result->info_symbol}} <div class="az-toggle az-toggle-secondary @if(1==1) off @endif"  data-symbol="{{$result->info_symbol}}" ><span></span></div></span>
                        </div>
                        <div>
                        <h6 class="{{ $result->priceinfo_pchange<0 ? 'tx-danger' : 'tx-primary' }}">{{$result->priceinfo_lastprice}}</h6>
                        <span>{{$result->priceinfo_change}} ({{$result->priceinfo_pchange}} %)</span>
                        </div>
                    </div>
                @endforeach
                <?php
                  // $highestPrice = $objClass->topHighestPrice();
                  // foreach($highestPrice as $highprice){
                  //   $div_off_on = "off";
                  //   if(in_array($highprice['info_symbol'], $watchList)){
                  //     $div_off_on = "on";
                  //   }
                  //   echo '<div class="az-list-item">
                  //       <div>
                  //       <h6>'.$highprice['info_name'].'</h6>
                  //       <span>'.$highprice['info_symbol'].'</span><div class="az-toggle az-toggle-secondary '.$div_off_on.'"  data-symbol="'.$highprice['info_symbol'].'" ><span></span></div>
                  //       </div>
                  //       <div>
                  //       <h6 class="tx-'.($highprice['priceinfo_pchange'] < 0 ? "danger" : "primary").'">'.$highprice['priceinfo_lastprice'].'</h6>
                  //       <span>'.$highprice['priceinfo_change'].' ('.$highprice['priceinfo_pchange'].'%)</span>
                  //       </div>
                  //   </div>';
                  // }
                ?>
                </div><!-- card-body -->
              </div><!-- card -->

            </div><!-- col -->
            <div class="col-lg-6">
              <div class="card card-dashboard-pageviews">
                <div class="card-header">
                <span class="float-sm-right"> <a href="dashboard/lowprice" class="btn btn-sm">More</a> </span>
                  <h6 class="card-title">Lowest Price </h6>
                  <p class="card-text">Overall Lowest Price Stock</p>
                </div><!-- card-header -->
                <div class="card-body">
                @foreach ($lowestPrice as $result)
                    <div class="az-list-item">
                      <div>
                        <h6>{{$result->info_name}}</h6>
                        <span>{{$result->info_symbol}}<div class="az-toggle az-toggle-secondary @if(1==1) off @endif"  data-symbol="{{$result->info_symbol}}" ><span></span></div></span>
                        </div>
                        <div>
                        <h6 class="{{ $result->priceinfo_pchange<0 ? 'tx-danger' : 'tx-primary' }}">{{$result->priceinfo_lastprice}}</h6>
                        <span>{{$result->priceinfo_change}} ({{$result->priceinfo_pchange}} %)</span>
                        </div>
                    </div>
                @endforeach
                <?php
                  // $lowestPrice = $objClass->topLowestPrice();
                  // foreach($lowestPrice as $lowprice){
                  //   $div_off_on = "off";
                  //   if(in_array($lowprice['info_symbol'], $watchList)){
                  //     $div_off_on = "on";
                  //   }
                  //   echo '<div class="az-list-item">
                  //       <div>
                  //       <h6>'.$lowprice['info_name'].'</h6>
                  //       <span>'.$lowprice['info_symbol'].'</span><div class="az-toggle az-toggle-secondary '.$div_off_on.'"  data-symbol="'.$lowprice['info_symbol'].'" ><span></span></div>
                  //       </div>
                  //       <div>
                  //       <h6 class="tx-'.($lowprice['priceinfo_pchange'] < 0 ? "danger" : "primary").'">'.$lowprice['priceinfo_lastprice'].'</h6>
                  //       <span>'.$lowprice['priceinfo_change'].' ('.$lowprice['priceinfo_change'].'%)</span>
                  //       </div>
                  //   </div>';
                  // }
                ?>
                </div><!-- card-body -->
              </div><!-- card -->

            </div><!-- col -->
            
          </div><!-- row -->

          <div class="row row-sm mg-b-20">
            <div class="col-lg-6">
              <div class="card card-dashboard-pageviews">
                <div class="card-header">
                <span class="float-sm-right"> <a href="dashboard/yearlyhigh" class="btn btn-sm">More</a> </span>
                  <h6 class="card-title">52 Week High </h6>
                  <p class="card-text">All Time High Reached Stock</p>
                </div><!-- card-header -->
                <div class="card-body">
                @foreach ($week52High as $result)
                    <div class="az-list-item">
                      <div>
                        <h6>{{$result->info_name}} <span style="color:green">{{$result->priceinfo_lastprice}}</span></h6>
                        <span>{{$result->info_symbol}} ({{$result->priceinfo_52HighDate}})<div class="az-toggle az-toggle-secondary @if(1==1) off @endif"  data-symbol="{{$result->info_symbol}}" ><span></span></div></span>
                        </div>
                        <div>
                        <h6 class="{{ $result->priceinfo_pchange<0 ? 'tx-danger' : 'tx-primary' }}">{{$result->priceinfo_lastprice}}</h6>
                        <span>{{$result->priceinfo_change}} ({{$result->priceinfo_pchange}} %)</span>
                        </div>
                    </div>
                @endforeach
                <?php
                  // $alltimeHighPrice = $objClass->allTimeHigh();
                  // foreach($alltimeHighPrice as $alltimeHigh){
                  //   $div_off_on = "off";
                  //   if(in_array($alltimeHigh['info_symbol'], $watchList)){
                  //     $div_off_on = "on";
                  //   }
                  //   echo '<div class="az-list-item">
                  //       <div>
                  //       <h6>'.$alltimeHigh['info_name'].' <span style="color:green">'.$alltimeHigh['priceinfo_lastprice'].'</span></h6>
                  //       <span>'.$alltimeHigh['info_symbol'].' ('.$alltimeHigh['priceinfo_52HighDate'].')</span><div class="az-toggle az-toggle-secondary '.$div_off_on.'"  data-symbol="'.$alltimeHigh['info_symbol'].'" ><span></span></div>
                  //       </div>
                  //       <div>
                  //       <h6 class="tx-'.($alltimeHigh['priceinfo_pchange'] < 0 ? "danger" : "primary").'">'.$alltimeHigh['priceinfo_52High'].'</h6>
                  //       <span>'.$alltimeHigh['priceinfo_change'].' ('.$alltimeHigh['priceinfo_pchange'].'%)</span>
                  //       </div>
                  //   </div>';
                  // }
                ?>
                </div><!-- card-body -->
              </div><!-- card -->

            </div><!-- col -->
            <div class="col-lg-6">
              <div class="card card-dashboard-pageviews">
                <div class="card-header">
                <span class="float-sm-right"> <a href="dashboard/yearlylow" class="btn btn-sm">More</a> </span>
                  <h6 class="card-title">52 Week Low</h6>
                  <p class="card-text">All Time Low Reached Stock</p>
                </div><!-- card-header -->
                <div class="card-body">
                @foreach ($week52Low as $result)
                    <div class="az-list-item">
                      <div>
                        <h6>{{$result->info_name}} <span style="color:green">{{$result->priceinfo_lastprice}}</span></h6>
                        <span>{{$result->info_symbol}} ({{$result->priceinfo_52lowdate}})<div class="az-toggle az-toggle-secondary @if(1==1) off @endif"  data-symbol="{{$result->info_symbol}}" ><span></span></div></span>
                        </div>
                        <div>
                        <h6 class="{{ $result->priceinfo_pchange<0 ? 'tx-danger' : 'tx-primary' }} ">{{$result->priceinfo_lastprice}}</h6>
                        <span>{{$result->priceinfo_change}} ({{$result->priceinfo_pchange}} %)</span>
                        </div>
                    </div>
                @endforeach
                <?php
                  // $alltimeLowPrice = $objClass->allTimeLow();
                  // foreach($alltimeLowPrice as $alltimeLow){
                  //   $div_off_on = "off";
                  //   if(in_array($alltimeLow['info_symbol'], $watchList)){
                  //     $div_off_on = "on";
                  //   }
                  //   echo '<div class="az-list-item">
                  //       <div>
                  //       <h6>'.$alltimeLow['info_name'].' <span style="color:red">'.$alltimeLow['priceinfo_lastprice'].'</span></h6>
                  //       <span>'.$alltimeLow['info_symbol'].' ('.$alltimeLow['priceinfo_52lowdate'].')</span><div class="az-toggle az-toggle-secondary '.$div_off_on.'"  data-symbol="'.$alltimeLow['info_symbol'].'" ><span></span></div>
                  //       </div>
                  //       <div>
                  //       <h6 class="tx-'.($alltimeLow['priceinfo_pchange'] < 0 ? "danger" : "primary").'">'.$alltimeLow['priceinfo_52low'].'</h6>
                  //       <span>'.$alltimeLow['priceinfo_change'].' ('.$alltimeLow['priceinfo_pchange'].'%)</span>
                  //       </div>
                  //   </div>';
                  // }
                ?>
                </div><!-- card-body -->
              </div><!-- card -->

            </div><!-- col -->
            
          </div><!-- row -->
        </div><!-- az-content-body -->
      </div>
    </div><!-- az-content -->
@include("footer");
    <script>
      $(function(){
        'use strict'

        var ctx5 = document.getElementById('chartBar5');
        new Chart(ctx5, {
          type: 'bar',
          data: {
            labels: <?php echo json_encode($label_val); ?>,
            datasets: [{
              label:"Gain",
              data: <?php echo json_encode($chart_gain); ?>,
              backgroundColor: '#3bb001'
            }, {
              label:"Lose",
              data: <?php echo json_encode($chart_lose); ?>,
              backgroundColor: '#dc3545'
            }]
          },
          options: {
            maintainAspectRatio: false,
            tooltips: {
              enabled: true
            },
            legend: {
              display: true,
                labels: {
                  display: false
                }
            },
            scales: {
              yAxes: [{
                display: false,
                ticks: {
                  beginAtZero:true,
                  fontSize: 11,
                  max: <?php echo $chart_max_amt; ?>
                }
              }],
              xAxes: [{
                barPercentage: 0.5,
                gridLines: {
                  color: 'rgba(0,0,0,0.08)'
                },
                ticks: {
                  beginAtZero:true,
                  fontSize: 11,
                  display: true
                }
              }]
            }
          }
        });


        var plot = $.plot('#flotChart', [{
          data: flotSampleData3,
          color: '#007bff',
          lines: {
            fillColor: { colors: [{ opacity: 0 }, { opacity: 0.2 }]}
          }
        },{
          data: flotSampleData4,
          color: '#560bd0',
          lines: {
            fillColor: { colors: [{ opacity: 0 }, { opacity: 0.2 }]}
          }
        }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 2,
              fill: true
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 8
          },
    			yaxis: {
            show: true,
    				min: 0,
    				max: 100,
            ticks: [[0,''],[20,'20K'],[40,'40K'],[60,'60K'],[80,'80K']],
            tickColor: '#eee'
    			},
    			xaxis: {
            show: true,
            color: '#fff',
            ticks: [[25,'OCT 21'],[75,'OCT 22'],[100,'OCT 23'],[125,'OCT 24']],
          }
        });
      });
    </script>
  </body>
</html>
