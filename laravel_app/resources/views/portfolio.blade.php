
@include('header')
<style>
  .tx-success {
    color: #3bb001 !important;
}
  .tx-danger {
    color: #dc3545 !important;
}
  </style>

    <div class="az-content az-content-dashboard">
      <div class="container">
        <div class="az-content-body pd-lg-l-40 d-flex flex-column">
          <h2 class="az-content-title">Protfolio</h2>
          <div class="az-content-label mg-b-5">Add New Protfolio</div>
          <p class="mg-b-20"></p>
          <form action="savePortfolio" method="POST">
          {{ csrf_field() }}
          <div class="row row-sm">
            <div class="col-lg-3 mg-t-20 mg-lg-t-0">
              <p class="mg-b-10">Stock List</p>
              <select class="form-control select2" name="purchase_stock">
                <option label="Choose one"></option>
                  @foreach ($allstocklist as $stock)
                    <option value="{{ $stock->stock_name }}">{{ $stock->stock_name }} - {{ $stock->stock_fullname }}</option>
                  @endforeach
              </select>
            </div><!-- col-4 -->
            <div class="col-lg-3 mg-t-20 mg-lg-t-0">
              <p class="mg-b-10">Qty</p>
              <input class="form-control" autocomplete="off"  placeholder="Input box" name="purchase_qty" type="text">
            </div><!-- col-4 -->
            <div class="col-lg-3 mg-t-20 mg-lg-t-0">
              <p class="mg-b-10">Purchase Rate</p>
              <input class="form-control" autocomplete="off" placeholder="Input box" name="purchase_rate" type="text">
            </div><!-- col-4 -->
            <div class="col-lg-3 mg-t-20 mg-lg-t-0">
              <p class="mg-b-10">Purchase Date</p>
              <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                </div>
              </div>
              <input type="text" autocomplete="off"  class="form-control fc-datepicker" name="purhcase_date" placeholder="MM/DD/YYYY">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-12 mg-t-20 mg-lg-t-0 tx-right">
              </br>
              <button class="btn btn-success" placeholder="Input box" type="submit">Save</button>
            </div><!-- col-4 -->
          </div><!-- row -->
          </form>
          </br>
          <div class="row row-sm mg-b-20 mg-lg-b-0">
            <div class="col-lg-12 col-xl-12">
              <div class="row row-sm">
                <div class="col-md-6 col-lg-6 mg-b-20 mg-md-b-0 mg-lg-b-20">
                  <div class="card card-dashboard-five">
                    <div class="card-header">
                      <h6 class="card-title">Total Amount</h6>
                      <span class="card-text">Tells you where your visitors originated from, such as search engines, social networks or website referrals.</span>
                    </div><!-- card-header -->
                    <div class="card-body row row-sm">
                      <div class="col-6 d-sm-flex align-items-center">
                        <div class="card-chart bg-primary">
                          <span class="peity-bar" data-peity='{"fill": ["#fff"], "width": 20, "height": 20 }'>6,4,7,5,7</span>
                        </div>
                        <div>
                          <label>Invest Amount</label>
                          <h4>{{ number_format($totalInvAmt,2,'.',',') }}</h4>
                        </div>
                      </div><!-- col -->
                      <div class="col-6 d-sm-flex align-items-center">
                        <div class="card-chart bg-purple">
                          <span class="peity-bar" data-peity='{"fill": ["#fff"], "width": 21, "height": 20 }'>7,4,5,7,2</span>
                        </div>
                        <div>
                          <label>Overall Amount</label>
                          <h4>{{ number_format($overAllAmt,2,'.',',') }}</h4>
                        </div>
                      </div><!-- col -->
                    </div><!-- card-body -->
                  </div><!-- card-dashboard-five -->
                </div><!-- col -->
                <div class="col-md-6 col-lg-6 mg-b-20 mg-md-b-0 mg-lg-b-20">
                  <div class="card card-dashboard-five">
                    <div class="card-header">
                      <h6 class="card-title">Gain/Loss</h6>
                      <span class="card-text">Tells you where your visitors originated from, such as search engines, social networks or website referrals.</span>
                    </div><!-- card-header -->
                    <div class="card-body row row-sm">
                      <div class="col-6 d-sm-flex align-items-center">
                        <div class="card-chart {{ ($gainlossPer > 0) ? 'bg-success' : 'bg-danger' }}">
                          <span class="peity-bar" data-peity='{"fill": ["#fff"], "width": 20, "height": 20 }'>6,4,7,5,7</span>
                        </div>
                        <div>
                          <label>Gain/Loss Amount</label>
                          <h4 class="{{ ($gainlossPer > 0) ? 'tx-success' : 'tx-danger' }}">{{ number_format($gainlossAmt,2,'.',',') }}</h4>
                        </div>
                      </div><!-- col -->
                      <div class="col-6 d-sm-flex align-items-center">
                        <div class="card-chart {{ ($gainlossPer > 0) ? 'bg-success' : 'bg-danger' }}">
                          <span class="peity-bar" data-peity='{"fill": ["#fff"], "width": 21, "height": 20 }'>7,4,5,7,2</span>
                        </div>
                        <div>
                          <label>Gain/Loss Per</label>
                          <h4 class="{{ ($gainlossPer > 0) ? 'tx-success' : 'tx-danger' }}">{{ $gainlossPer }} %</h4>
                        </div>
                      </div><!-- col -->
                    </div><!-- card-body -->
                  </div><!-- card-dashboard-five -->
                </div><!-- col -->
              </div><!-- row -->
            </div><!-- col-lg-3 -->
              </div>
          <div class="az-content-label mg-b-5">My Portfolio</div>
          <div class="row row-sm mg-b-20 mg-lg-b-0">
            <div class="col-lg-12 col-xl-12 mg-t-20 mg-lg-t-0">
            <div class="table-responsive">
            <table class="table table-bordered mg-b-0">
              <thead>
                <tr>
                  <th class="wd-5p">&nbsp;</th>
                  <th class="wd-25p">Stock</th>
                  <th>Qty</th>
                  <th>InvRate</th>
                  <th>Inv Amt</th>
                  <th>Price</th>
                  <th>Today</th>
                  <th>Overall</th>
                  <th>Total Amt</th>
                </tr>
              </thead>
              <tbody>
                @foreach($myProtfolioData as $result)
                <tr>
                  <td>
                      {{ ($loop->index+1)}}
                      <div class="az-toggle az-toggle-secondary {{ (in_array($result->info_symbol, $getWatchlist) ? 'on' : 'off') }}"  data-symbol="{{ $result->info_symbol }}" ><span></span></div>
                  </td>
                        <td><strong><a href="stockData/{{$result->info_symbol}}"> {{$result->info_name}} </a></strong> <p>{{ $result->info_symbol }}</p> </td>
                        <td><strong>{{ $result->stock_qty }}</strong><p class="tx-primary">{{ date("d-m-Y", strtotime( $result->purchase_date)) }}</p></td>
                        <td><p><strong>{{ $result->stock_price }}</strong></p></td>
                        <td><strong>{{ number_format($result->inv_amt,2,'.',',') }}</strong></td>
                        <td><p><strong class="tx-primary">{{ number_format($result->live_price,2,'.',',') }}</strong></p><p class="tx-bold {{ ($result->today_amt > 0 ? 'tx-success' : 'tx-danger') }}">{{ number_format($result->price_change,2,'.',',') }}</p><p>{{ $result->price_change_per }}%</p></td>
                        <td class="tx-bold {{ ($result->today_amt > 0 ? 'tx-success' : 'tx-danger') }}">{{ number_format($result->today_amt,2,'.',',') }}</td>
                        <td class="tx-bold {{ ($result->overall_amt > 0 ? 'tx-success' : 'tx-danger') }}">{{ number_format($result->overall_amt,2,'.',',') }}</td>
                        <td class="tx-bold {{ ($result->overall_amt > 0 ? 'tx-success' : 'tx-danger') }}">{{ number_format($result->total_amt,2,'.',',') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            
          </div><!-- table-responsive -->
            </div><!-- col-lg -->

          </div><!-- row -->
          </br>
          <div class="az-content-label mg-b-5">My Portfolio Details</div>
          <div class="row row-sm mg-b-20 mg-lg-b-0">
            <div class="col-lg-12 col-xl-12 mg-t-20 mg-lg-t-0">
            <div class="table-responsive">
            <table class="table table-bordered mg-b-0">
              <thead>
                <tr>
                  <th class="wd-5p">&nbsp;</th>
                  <th class="wd-25p">Stock</th>
                  <th>Qty</th>
                  <th>Inv Rate</th>
                  <th>Inv Amt</th>
                  <th>Price</th>
                  <th>Today</th>
                  <th>Overall</th>
                  <th>Total Amt</th>
                </tr>
              </thead>
              <tbody>
              @foreach($myProtfolioDetails as $result)
                <tr>
                  <td>
                        <a href="deletePortfolio?del_id={{ $result->list_id }}"><i class="fa fa-trash tx-danger"></i></a>
                  </td>
                        <td><strong><a href="stockData/{{$result->info_symbol}}"> {{$result->info_name}} </a></strong> <p>{{ $result->info_symbol }}</p> </td>
                        <td><strong>{{ $result->stock_qty }}</strong><p class="tx-primary">{{ date("d-m-Y", strtotime( $result->purchase_date)) }}</p></td>
                        <td><p><strong>{{ number_format($result->stock_price,2,'.',',') }}</strong></p></td>
                        <td><strong>{{ number_format($result->inv_amt,2,'.',',') }}</strong></td>
                        <td><p><strong class="tx-primary">{{ number_format($result->live_price,2,'.',',') }}</strong></p><p class="tx-bold {{ ($result->today_amt > 0 ? 'tx-success' : 'tx-danger') }}">{{ number_format($result->price_change,2,'.',',') }}</p><p>{{ $result->price_change_per }}%</p></td>
                        <td class="tx-bold {{ ($result->today_amt > 0 ? 'tx-success' : 'tx-danger') }}">{{ number_format($result->today_amt,2,'.',',') }}</td>
                        <td class="tx-bold {{ ($result->overall_amt > 0 ? 'tx-success' : 'tx-danger') }}">{{ number_format($result->overall_amt,2,'.',',') }}</td>
                        <td class="tx-bold {{ ($result->overall_amt > 0 ? 'tx-success' : 'tx-danger') }}">{{ number_format($result->total_amt,2,'.',',') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            
          </div><!-- table-responsive -->
            </div><!-- col-lg -->

          </div><!-- row -->
        </div><!-- az-content-body -->
        
      </div>
    </div><!-- az-content -->
@include("footer");
<script>
      $(function(){
        'use strict'     
          // Line chart
          $('.peity-line').peity('line');

          // Bar charts
          $('.peity-bar').peity('bar');
      });
</script>
  </body>
</html>
