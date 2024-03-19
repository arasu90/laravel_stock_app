<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Traits\watchListTraits;
use App\Models\DashboardModel;
use App\Traits\overallGainLossTraits;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    use watchListTraits, overallGainLossTraits;
    public function index(){
        $getWatchlist = $this->getWatchlist();

        $topGainer = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->orderBy('priceinfo_change','DESC')->limit(5)->get();
        
        $topGainerPer = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->where('priceinfo_pchange', '>',0)->orderBy('priceinfo_pchange','DESC')->limit(5)->get();

        $topLosser = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->where('priceinfo_change', '<',0)->orderBy('priceinfo_change','ASC')->limit(5)->get();

        $topLosserPer = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->orderBy('priceinfo_pchange','DESC')->limit(5)->get();
        
        $highestPrice = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->orderBy('priceinfo_lastprice','DESC')->limit(5)->get();
        
        $lowestPrice = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->orderBy('priceinfo_lastprice','ASC')->limit(5)->get();
        
        $week52High = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change','priceinfo_52HighDate')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->orderBy('priceinfo_52HighDate','DESC')->orderBy('priceinfo_pchange','DESC')->limit(5)->get();
        
        $week52Low = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change','priceinfo_52lowdate')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->orderBy('priceinfo_52lowdate','DESC')->orderBy('priceinfo_pchange','DESC')->limit(5)->get();


        $overallData = $this->getOverallGainLoss();
        $gainlossAmt = $overallData['gainlossAmt'];
        $gainlosePer = $overallData['gainlosePer'];

        $result = DB::table("portfolio_list")->get();
		$chartData = array();
		foreach($result as $row){
			$stock_qty = $row->stock_qty;
			$stock_price = $row->stock_price;
			$stock_symbol = $row->info_symbol;
			for($i=0;$i<10;$i++){
				$todate = date("Y-m-d", strtotime(" -$i day"));
				$query_1 = DB::table("all_stock_list_data")->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->where('info_symbol',$stock_symbol)->where('stock_last_date',$todate);
                $result_1 = $query_1->count();
				if($result_1 > 0){
                    $result_2 = $query_1->first();
					$tot_amt = round(($stock_qty* $result_2->priceinfo_lastprice)-($stock_qty* $stock_price),2);
					if($tot_amt>=0){
                        $chartData[$result_2->stock_last_date]['gain'] = $tot_amt + (isset($chartData[$result_2->stock_last_date]['gain']) ? $chartData[$result_2->stock_last_date]['gain'] : 0);
                        // $chartData[$result_2->stock_last_date]['gain_1'][] = abs($tot_amt);
					}else{
                        $chartData[$result_2->stock_last_date]['loss'] = $tot_amt + (isset($chartData[$result_2->stock_last_date]['loss']) ? $chartData[$result_2->stock_last_date]['loss'] : 0);
                        // $chartData[$result_2->stock_last_date]['loss_1'][] = abs($tot_amt);
					}
					if(count($chartData)>4){
						break;
					}
				}
			}
        }
        // dd($getWatchlist);
        return view('dashboard', ['topGainer'=> $topGainer,'topGainerPer'=> $topGainerPer,'topLosser'=> $topLosser,'topLosserPer'=> $topLosserPer,'highestPrice'=>$highestPrice,'lowestPrice'=>$lowestPrice,'week52High'=>$week52High,'week52Low'=>$week52Low, 'getWatchlist'=>$getWatchlist, 'gainlosePer'=>$gainlosePer, 'gainlossAmt'=>$gainlossAmt, 'chartData'=>$chartData]);
    }

    public function topgainer(){
        $getWatchlist = $this->getWatchlist();
        $topGainer = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change', 'priceinfo_prev_close','priceinfo_open','priceinfo_intraday_min','priceinfo_intraday_max','priceinfo_lowerCP','priceinfo_upperCP','priceinfo_52low','priceinfo_52lowdate','priceinfo_52High','priceinfo_52HighDate')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->orderBy('priceinfo_change','DESC')->limit(50)->get();

        $pageTitle = "Top Gainer";
        $pageTitleDesc = "Top gainer for 100 stocks";

        return view('dashboard_data', ['pagedata'=> $topGainer, 'pageTitle' => $pageTitle, 'pageTitleDesc' => $pageTitleDesc,'getWatchlist'=>$getWatchlist]);
    }

    public function topgainerPer(){
        $getWatchlist = $this->getWatchlist();
        // DB::connection()->enableQueryLog();
        $topGainerPer = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change', 'priceinfo_prev_close','priceinfo_open','priceinfo_intraday_min','priceinfo_intraday_max','priceinfo_lowerCP','priceinfo_upperCP','priceinfo_52low','priceinfo_52lowdate','priceinfo_52High','priceinfo_52HighDate')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->orderBy('priceinfo_pchange','DESC')->limit(50)->get();
        // $queries = DB::getQueryLog();

        //  dd($queries);
        $pageTitle = "Top Gainer %";
        $pageTitleDesc = "Top gainer % for 100 stocks";

        return view('dashboard_data', ['pagedata'=> $topGainerPer, 'pageTitle' => $pageTitle, 'pageTitleDesc' => $pageTitleDesc,'getWatchlist'=>$getWatchlist]);
    }
    public function topLooser(){
        $getWatchlist = $this->getWatchlist();
        $topGainer = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change', 'priceinfo_prev_close','priceinfo_open','priceinfo_intraday_min','priceinfo_intraday_max','priceinfo_lowerCP','priceinfo_upperCP','priceinfo_52low','priceinfo_52lowdate','priceinfo_52High','priceinfo_52HighDate')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->where('priceinfo_pchange', '<', 0)->orderBy('priceinfo_change','ASC')->orderBy('priceinfo_pchange','ASC')->limit(50)->get();

        $pageTitle = "Top Looser";
        $pageTitleDesc = "Top looser for 100 stocks";

        return view('dashboard_data', ['pagedata'=> $topGainer, 'pageTitle' => $pageTitle, 'pageTitleDesc' => $pageTitleDesc,'getWatchlist'=>$getWatchlist]);
    }

    public function topLooserPer(){
        $getWatchlist = $this->getWatchlist();
        $topGainerPer = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change', 'priceinfo_prev_close','priceinfo_open','priceinfo_intraday_min','priceinfo_intraday_max','priceinfo_lowerCP','priceinfo_upperCP','priceinfo_52low','priceinfo_52lowdate','priceinfo_52High','priceinfo_52HighDate')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->where('priceinfo_pchange', '<', 0)->orderBy('priceinfo_pchange','asc')->orderBy('priceinfo_change','ASC')->limit(50)->get();

        $pageTitle = "Top Looser %";
        $pageTitleDesc = "Top looser for 100 stocks";

        return view('dashboard_data', ['pagedata'=> $topGainerPer, 'pageTitle' => $pageTitle, 'pageTitleDesc' => $pageTitleDesc,'getWatchlist'=>$getWatchlist]);
    }

    public function highestPrice(){
        
        $getWatchlist = $this->getWatchlist();
        $topGainerPer = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change', 'priceinfo_prev_close','priceinfo_open','priceinfo_intraday_min','priceinfo_intraday_max','priceinfo_lowerCP','priceinfo_upperCP','priceinfo_52low','priceinfo_52lowdate','priceinfo_52High','priceinfo_52HighDate')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->where('priceinfo_pchange', '<>', 0)->orderBy('priceinfo_lastPrice','DESC')->limit(50)->get();

        $pageTitle = "Top High Price";
        $pageTitleDesc = "Top High Price for 100 stocks";

        return view('dashboard_data', ['pagedata'=> $topGainerPer, 'pageTitle' => $pageTitle, 'pageTitleDesc' => $pageTitleDesc,'getWatchlist'=>$getWatchlist]);
    }

    public function lowestPrice(){
        
        $getWatchlist = $this->getWatchlist();
        $lowestprice = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change', 'priceinfo_prev_close','priceinfo_open','priceinfo_intraday_min','priceinfo_intraday_max','priceinfo_lowerCP','priceinfo_upperCP','priceinfo_52low','priceinfo_52lowdate','priceinfo_52High','priceinfo_52HighDate')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->where('priceinfo_pchange', '<>', 0)->orderBy('priceinfo_lastPrice','asc')->limit(50)->get();

        $pageTitle = "Top Low Price";
        $pageTitleDesc = "Top Low Price for 100 stocks";

        return view('dashboard_data', ['pagedata'=> $lowestprice, 'pageTitle' => $pageTitle, 'pageTitleDesc' => $pageTitleDesc,'getWatchlist'=>$getWatchlist]);
    }

    public function yearlyHigh(){
        
        $getWatchlist = $this->getWatchlist();
        $yearlyhigh = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change', 'priceinfo_prev_close','priceinfo_open','priceinfo_intraday_min','priceinfo_intraday_max','priceinfo_lowerCP','priceinfo_upperCP','priceinfo_52low','priceinfo_52lowdate','priceinfo_52High','priceinfo_52HighDate')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->where('priceinfo_pchange', '<>', 0)->orderBy('priceinfo_52HighDate','DESC')->orderBy('priceinfo_pchange','DESC')->limit(50)->get();

        $pageTitle = "Top 52 Week High Stock";
        $pageTitleDesc = "Top 52 Week High Price for 100 stocks";
        
        return view('dashboard_data', ['pagedata'=> $yearlyhigh, 'pageTitle' => $pageTitle, 'pageTitleDesc' => $pageTitleDesc,'getWatchlist'=>$getWatchlist]);
    }

    public function yearlyLow(){
        
        $getWatchlist = $this->getWatchlist();
        $yearlylow = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change', 'priceinfo_prev_close','priceinfo_open','priceinfo_intraday_min','priceinfo_intraday_max','priceinfo_lowerCP','priceinfo_upperCP','priceinfo_52low','priceinfo_52lowdate','priceinfo_52High','priceinfo_52HighDate')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->where('priceinfo_pchange', '<>', 0)->orderBy('priceinfo_52lowdate','DESC')->orderBy('priceinfo_pchange','ASC')->limit(50)->get();

        $pageTitle = "Top 52 Week Low Stock";
        $pageTitleDesc = "Top 52 Week Low Price for 100 stocks";

        return view('dashboard_data', ['pagedata'=> $yearlylow, 'pageTitle' => $pageTitle, 'pageTitleDesc' => $pageTitleDesc,'getWatchlist'=>$getWatchlist]);
    }
}
