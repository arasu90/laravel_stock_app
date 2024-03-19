<?php

$label_val = array_keys($chartData);
$chart_gain = array_column($chartData,'gain');
// print_r($chart_gain);
$chart_loss = array_column($chartData,'loss');
$max_gain_amt = !empty($chart_gain) ? max($chart_gain) : '0';
$max_loss_amt = !empty($chart_loss) ? max($chart_loss) : '0';
$chart_max_amt = $max_gain_amt;
if($max_loss_amt>$max_gain_amt){
  $chart_max_amt = $max_loss_amt;
}

?>
@include('header')
<div class="az-content az-content-dashboard">
      <div class="container">
        <div class="az-content-body">
          <div class="az-dashboard-one-title">
            <div>
              <h2 class="az-dashboard-title">Hi, welcome back Kalai!</h2>
              <p class="az-dashboard-text">Your web analytics dashboard template.</p>
            </div>
            <div class="az-content-header-right">
              
            </div>
          </div><!-- az-dashboard-one-title -->
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
                      <h2>0</h2>
                    </div>
                    <div>
                      <label class="mg-b-0">Bounce Rate</label>
                      <h2>0%</h2>
                    </div>
                    <div>
                      <label class="mg-b-0">Page Views</label>
                      <h2>0</h2>
                    </div>
                    <div>
                      <label class="mg-b-0">Sessions</label>
                      <h2>0</h2>
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
                      <h6>0% <i class="icon ion-md-trending-up tx-success"></i> <small>0%</small></h6>
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
                      <h6>0 <i class="icon ion-md-trending-down tx-danger"></i> <small>0%</small></h6>
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
                      <h6 style="font-size:26px">{{ number_format($gainlossAmt,2,'.',',') }}</h6>
                      <strong class="tx-success"><i class="icon {{ ($gainlosePer>0 ? 'ion-md-arrow-up' : 'ion-md-arrow-down') }}"></i>{{ $gainlosePer }} %</strong>
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
                @foreach ($topGainerPer as $result)
                    <div class="az-list-item">
                      <div>
                        <h6> <a href="stockData/{{$result->info_symbol}}"> {{$result->info_name}} </a><span style="color:green">{{number_format($result->priceinfo_lastprice,2,'.',',')}} </span></h6>
                        <span>{{$result->info_symbol}}<div class="az-toggle az-toggle-secondary {{ (in_array($result->info_symbol, $getWatchlist) ? 'on' : 'off') }}"  data-symbol="{{$result->info_symbol}}" ><span></span></div></span>
                        </div>
                        <div>
                        <h6 class="tx-primary">{{$result->priceinfo_pchange}} %</h6>
                        <span>{{number_format($result->priceinfo_change,2,'.',',')}}</span>
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
                        <h6><a href="stockData/{{$result->info_symbol}}"> {{$result->info_name}} </a> <span style="color:green">{{number_format($result->priceinfo_lastprice,2,'.',',')}}</span></h6>
                        <span>{{$result->info_symbol}}<div class="az-toggle az-toggle-secondary {{ (in_array($result->info_symbol, $getWatchlist) ? 'on' : 'off') }}"  data-symbol="{{$result->info_symbol}}" ><span></span></div></span>
                        </div>
                        <div>
                        <h6 class="tx-primary">{{number_format($result->priceinfo_change,2,'.',',')}}</h6>
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
                        <h6><a href="stockData/{{$result->info_symbol}}"> {{$result->info_name}} </a> <span style="color:green">{{number_format($result->priceinfo_lastprice,2,'.',',')}}</span></h6>
                        <span>{{$result->info_symbol}}<div class="az-toggle az-toggle-secondary {{ (in_array($result->info_symbol, $getWatchlist) ? 'on' : 'off') }}"  data-symbol="{{$result->info_symbol}}" ><span></span></div></span>
                        </div>
                        <div>
                        <h6 class="tx-danger">{{$result->priceinfo_pchange}} %</h6>
                        <span>{{number_format($result->priceinfo_change,2,'.',',')}}</span>
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
                        <h6><a href="stockData/{{$result->info_symbol}}"> {{$result->info_name}} </a> <span style="color:green">{{number_format($result->priceinfo_lastprice,2,'.',',')}}</span></h6>
                        <span>{{$result->info_symbol}}<div class="az-toggle az-toggle-secondary {{ (in_array($result->info_symbol, $getWatchlist) ? 'on' : 'off') }}"  data-symbol="{{$result->info_symbol}}" ><span></span></div></span>
                        </div>
                        <div>
                        <h6 class="tx-danger">{{number_format($result->priceinfo_change,2,'.',',')}}</h6>
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
                        <span><a href="stockData/{{$result->info_symbol}}"> {{$result->info_name}} </a> <div class="az-toggle az-toggle-secondary {{ (in_array($result->info_symbol, $getWatchlist) ? 'on' : 'off') }}"  data-symbol="{{$result->info_symbol}}" ><span></span></div></span>
                        </div>
                        <div>
                        <h6 class="{{ $result->priceinfo_pchange<0 ? 'tx-danger' : 'tx-primary' }}">{{number_format($result->priceinfo_lastprice,2,'.',',')}}</h6>
                        <span>{{number_format($result->priceinfo_change,2,'.',',')}} ({{$result->priceinfo_pchange}} %)</span>
                        </div>
                    </div>
                @endforeach
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
                        <span><a href="stockData/{{$result->info_symbol}}"> {{$result->info_name}} </a><div class="az-toggle az-toggle-secondary {{ (in_array($result->info_symbol, $getWatchlist) ? 'on' : 'off') }}"  data-symbol="{{$result->info_symbol}}" ><span></span></div></span>
                        </div>
                        <div>
                        <h6 class="{{ $result->priceinfo_pchange<0 ? 'tx-danger' : 'tx-primary' }}">{{number_format($result->priceinfo_lastprice,2,'.',',')}}</h6>
                        <span>{{number_format($result->priceinfo_change,2,'.',',')}} ({{$result->priceinfo_pchange}} %)</span>
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
                <span class="float-sm-right"> <a href="dashboard/yearlyhigh" class="btn btn-sm">More</a> </span>
                  <h6 class="card-title">52 Week High </h6>
                  <p class="card-text">All Time High Reached Stock</p>
                </div><!-- card-header -->
                <div class="card-body">
                @foreach ($week52High as $result)
                    <div class="az-list-item">
                      <div>
                        <h6><a href="stockData/{{$result->info_symbol}}"> {{$result->info_name}} </a> <span style="color:green">{{number_format($result->priceinfo_lastprice,2,'.',',')}}</span></h6>
                        <span>{{$result->info_symbol}} ({{$result->priceinfo_52HighDate}})<div class="az-toggle az-toggle-secondary {{ (in_array($result->info_symbol, $getWatchlist) ? 'on' : 'off') }}"  data-symbol="{{$result->info_symbol}}" ><span></span></div></span>
                        </div>
                        <div>
                        <h6 class="{{ $result->priceinfo_pchange<0 ? 'tx-danger' : 'tx-primary' }}">{{number_format($result->priceinfo_lastprice,2,'.',',')}}</h6>
                        <span>{{$result->priceinfo_change}} ({{$result->priceinfo_pchange}} %)</span>
                        </div>
                    </div>
                @endforeach
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
                        <h6><a href="stockData/{{$result->info_symbol}}"> {{$result->info_name}} </a> <span style="color:green">{{number_format($result->priceinfo_lastprice,2,'.',',')}}</span></h6>
                        <span>{{$result->info_symbol}} ({{$result->priceinfo_52lowdate}})<div class="az-toggle az-toggle-secondary {{ (in_array($result->info_symbol, $getWatchlist) ? 'on' : 'off') }}"  data-symbol="{{$result->info_symbol}}" ><span></span></div></span>
                        </div>
                        <div>
                        <h6 class="{{ $result->priceinfo_pchange<0 ? 'tx-danger' : 'tx-primary' }} ">{{number_format($result->priceinfo_lastprice,2,'.',',')}}</h6>
                        <span>{{$result->priceinfo_change}} ({{$result->priceinfo_pchange}} %)</span>
                        </div>
                    </div>
                @endforeach
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
              data: <?php echo json_encode($chart_loss); ?>,
              backgroundColor: '#dc3545'
            }]
          },
          options: {
            maintainAspectRatio: false,
            tooltips: {
              enabled: true,
            },
            legend: {
              display: true,
                labels: {
                  display: true
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
