@include('header')
<div class="az-content az-content-dashboard">
      <div class="container">
        <div class="az-content-body pd-lg-l-40 d-flex flex-column">
          <h2 class="az-content-title">AllStock List</h2>
          <div class="az-content-label mg-b-5">Search Stocks</div>
          <p class="mg-b-20"></p>
          <form action="/showallstock" method="get">
          <div class="row row-sm">
            <div class="col-lg-3 mg-t-20 mg-lg-t-0">
              <p class="mg-b-10">Stock List</p>
              <select class="form-control select2" name="search_stock">
                <option label="Choose one"></option>
                @foreach($allStockList as $stock)
                <option value="{{ $stock->stock_name }}">{{ $stock->stock_name }} - {{ $stock->stock_fullname}}</option>
                @endforeach
              </select>
            </div><!-- col-4 -->
            <div class="col-lg-3 mg-t-20 mg-lg-t-0">
              <p class="mg-b-10">Price Range Start</p>
              <input class="form-control" autocomplete="off"  placeholder="Input box" name="price_start" type="text">
            </div><!-- col-4 -->
            <div class="col-lg-3 mg-t-20 mg-lg-t-0">
              <p class="mg-b-10">Price Range End</p>
              <input class="form-control" autocomplete="off"  placeholder="Input box" name="price_end" type="text">
            </div><!-- col-4 -->
            <div class="col-lg-3 mg-t-20 mg-lg-t-0">
              <p class="mg-b-10">Sortby</p>
              <select class="form-control" name="sort_by">
                <option label="Choose one"></option>
                <option value="pricelowtohigh">Price Low to High</option>
                <option value="pricehightolow">Price High to Low</option>
                <option value="todaychangeperasc">Today Change(%) Low to High</option>
                <option value="todaychangeperdesc">Today Change(%) High to Low</option>
                <option value="todaychangeasc">Today Change(Rs) Low to High</option>
                <option value="todaychangedesc">Today Change(Rs) High to Low</option>
                <option value="52weekhigh">52Week High</option>
                <option value="52weeklow">52Week Low</option>
              </select>
            </div><!-- col-4 -->
            <div class="col-lg-12 mg-t-20 mg-lg-t-0 tx-right">
              </br>
              <a class="btn btn-info" href="/showallstock">Reset</a>
              <button class="btn btn-success" placeholder="Input box" type="submit">Search</button>
            </div><!-- col-4 -->
          </div><!-- row -->
          </form>
          </br>
          <div class="az-content-label mg-b-5">AllStock</div>
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
                @forelse($queryDataResult as $result)
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
