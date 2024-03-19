@include('header')
<div class="az-content az-content-dashboard">
      <div class="container">
        <div class="az-content-body pd-lg-l-40 d-flex flex-column">
          <h2 class="az-content-title">Stock Watch List</h2>
          <div class="az-content-label mg-b-5">Stock List</div>
          <div class="row row-sm mg-b-20 mg-lg-b-0">
            <div class="col-lg-12 col-xl-12 mg-t-20 mg-lg-t-0">
            <div class="table-responsive">
            <table class="table table-bordered mg-b-0">
              <thead>
                <tr>
                  <th class="wd-5p">&nbsp;</th>
                  <th class="wd-25p">Stock</th>
                  <th>PreviousClose</th>
                  <th>Open</th>
                  <th class="wd-15p">LastPrice</th>
                  <th>TodayChange</th>
                  <th>Lower/Upper</th>
                  <th class="wd-10p">52WeekLow</th>
                  <th class="wd-10p">52WeekHigh</th>
                </tr>
              </thead>
              <tbody>
                @forelse($watchList as $result)
                <tr>
                    <td>
                      {{ ($loop->index+1)}}
                      <div class="az-toggle az-toggle-secondary {{ (in_array($result->info_symbol, $getWatchlist) ? 'on' : 'off') }}"  data-symbol="{{ $result->info_symbol }}" ><span></span></div>
                    </td>
                    <td>
                        <strong><a href="stockData/{{$result->info_symbol}}"> {{$result->info_name}} </a></strong>
                        <p>{{ $result->info_symbol }}</p>
                    </td>
                    <td>
                      <strong>{{ number_format($result->priceinfo_prev_close,2,'.',',') }}</strong>
                    </td>
                    <td>
                      <strong class="{{ ($result->priceinfo_open>$result->priceinfo_prev_close) ? 'tx-primary' : (($result->priceinfo_open < $result->priceinfo_prev_close) ? 'tx-danger' : '') }}">{{ number_format($result->priceinfo_open,2,'.',',') }}</strong>
                    </td>
                    <td>
                      <strong class="{{ ($result->priceinfo_pchange > 0) ? 'tx-success' : (($result->priceinfo_pchange < 0) ? 'tx-danger' : '') }}">{{ number_format($result->priceinfo_lastprice,2,'.',',') }}</strong>
                      <p class="{{ ($result->priceinfo_intraday_min == $result->priceinfo_lastprice) ? 'tx-info' : '' }}">
                          <strong>Min:</strong>
                            {{ number_format($result->priceinfo_intraday_min,2,'.',',') }}
                      </p>
                      <p class="{{ ($result->priceinfo_intraday_max == $result->priceinfo_lastprice) ? 'tx-info' : '' }}">
                          <strong>Max:</strong> 
                          {{ number_format($result->priceinfo_intraday_max,2,'.',',') }}
                      </p>
                    </td>
                    <td>
                      <strong class="{{ ($result->priceinfo_pchange > 0) ? 'tx-success' : (($result->priceinfo_pchange < 0) ? 'tx-danger' : '') }}">
                        {{ number_format($result->priceinfo_change,2,'.',',') }}
                      </strong>
                      <p>{{ $result->priceinfo_pchange }} %</p>
                    </td>
                    <td>
                        <p class="{{ ($result->priceinfo_lowerCP == $result->priceinfo_lastprice) ? 'tx-info' : '' }}"><strong>LCP:</strong>{{ number_format($result->priceinfo_lowerCP,2,'.',',') }}</p>
                        <p class="{{ ($result->priceinfo_upperCP == $result->priceinfo_lastprice) ? 'tx-info' : '' }}"><strong>UCP:</strong>{{ number_format($result->priceinfo_upperCP,2,'.',',') }}</p>
                    </td>
                    <td>
                      <strong class="{{ ($result->priceinfo_52low == $result->priceinfo_lastprice) ? 'tx-info' : '' }}">{{ number_format($result->priceinfo_52low,2,'.',',') }}</strong>
                      <p>{{ $result->priceinfo_52lowdate }}</p>
                      <p> {{ round(100-(($result->priceinfo_lastprice/$result->priceinfo_52low)*100),2) }} %</p>
                    </td>
                    <td>
                        <strong class="{{ ($result->priceinfo_52High == $result->priceinfo_lastprice) ? 'tx-info' : '' }}"> {{ number_format($result->priceinfo_52High,2,'.',',') }}</strong>
                        <p>{{ $result->priceinfo_52HighDate }}</p>
                        <p>{{ round(100-(($result->priceinfo_lastprice/$result->priceinfo_52High)*100),2) }} %</p>
                    </td>
                  </tr>
                  @empty
                  <tr><td colspan="9" class="tx-center">No Data founds</td></tr>
                  @endforelse
              </tbody>
            </table>
            
          </div><!-- table-responsive -->
            </div><!-- col-lg -->

          </div><!-- row -->
        </div><!-- az-content-body -->
        
      </div>
    </div><!-- az-content -->
  @include("footer");
  </body>
</html>
