<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Traits\watchListTraits;
use Illuminate\Support\Facades\Http;

class Allstock extends Controller
{
    use watchListTraits;
    public function index(Request $request)
    {
        $getWatchlist = $this->getWatchlist();
        $sort_by_data = $request->input('sort_by');
        $search_stock_data = $request->input('search_stock');
        $price_start_data = $request->input('price_start');
        $price_end_data = $request->input('price_end');

        $dbQuery = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change', 'priceinfo_prev_close','priceinfo_open','priceinfo_intraday_min','priceinfo_intraday_max','priceinfo_lowerCP','priceinfo_upperCP','priceinfo_52low','priceinfo_52lowdate','priceinfo_52HighDate','priceinfo_52High')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->where('priceinfo_pchange', '<>', 0);

        if($search_stock_data != ""){
            $dbQuery->where("info_symbol",$search_stock_data);
        }

        if($price_start_data != ""){
            $dbQuery->where("priceinfo_lastprice", '>=', $price_start_data);
        }
        if($price_end_data != ""){
            $dbQuery->where("priceinfo_lastprice", '<=', $price_end_data);
        }

        if($sort_by_data == "pricelowtohigh"){
			$dbQuery->orderBy("priceinfo_lastprice");
		}elseif($sort_by_data == "pricehightolow"){
			$dbQuery->orderBy("priceinfo_lastprice","desc");
		}elseif($sort_by_data == "todaychangeperasc"){
			$dbQuery->orderBy("priceinfo_pchange");
		}elseif($sort_by_data == "todaychangeperdesc"){
			$dbQuery->orderBy("priceinfo_pchange","desc");
		}elseif($sort_by_data == "todaychangeasc"){
			$dbQuery->orderBy("priceinfo_change");
		}elseif($sort_by_data == "todaychangedesc"){
			$dbQuery->orderBy("priceinfo_change","desc");
		}elseif($sort_by_data == "52weeklow"){
			$dbQuery->orderBy("priceinfo_52lowdate","desc");
		}elseif($sort_by_data == "52weekhigh"){
			$dbQuery->orderBy("priceinfo_52HighDate","desc");
		}else{
            $dbQuery->orderBy('info_name');
        }


        $queryDataResult = $dbQuery->get();
        $allStockList = DB::table('all_stock')->where('stock_status','1')->groupBy('stock_name')->orderBy('stock_name')->get();

        return view('allstock_show', ['queryDataResult'=> $queryDataResult, 'allStockList'=>$allStockList,'getWatchlist'=>$getWatchlist]);
    }

    public function stockData($stock_symbol){
        $stockDataDetail = DB::table('all_stock_list_data')->where('info_symbol',$stock_symbol)->orderBy('stock_last_date','Desc')->get();
        
        return view('show_stock_data', ['stockDataDetail'=> $stockDataDetail, 'pageTitle' => 'Stock Data', 'pageTitleDesc' => 'show stock data']);
    }

    public function insertStockData(){
        // $stock_symbol = 'ATLANTA';
        // $allStockList = DB::table('all_stock')->where('stock_status','1')->where('stock_name',$stock_symbol)->groupBy('stock_name')->orderBy('stock_name')->get();
        $allStockList = DB::table('all_stock')->where('stock_status','1')->groupBy('stock_name')->orderBy('stock_name')->get();
        foreach($allStockList as $stock_name){
            echo $stock_symbol = $stock_name->stock_name;
            echo "</br>";
            $response = Http::get("http://host.docker.internal:3001/api/equity/$stock_symbol");
            $response_data =$response->json();
            // dd($response_data);
            if (!isset($response_data['info'])) {
                echo "failed";
            }else{
                if (isset($response_data['info']['symbol'])) {
                    $insertVal['info_symbol'] = $response_data['info']['symbol'];
                }
                if (isset($response_data['info']['companyName'])) {
                    $insertVal['info_name'] = addslashes($response_data['info']['companyName']);
                }
                if (isset($response_data['info']['industry'])) {
                    $insertVal['info_industry'] = $response_data['info']['industry'];
                }
                if (isset($response_data['info']['isin'])) {
                    $insertVal['info_isin'] = $response_data['info']['isin'];
                }
                if (isset($response_data['info']['isDelisted'])) {
                    $insertVal['info_isdelisted'] = $response_data['info']['isDelisted'];
                }
                if (isset($response_data['info']['isSuspended'])) {
                    $insertVal['info_is_suspended'] = $response_data['info']['isSuspended'];
                }
                if (isset($response_data['metadata']['series'])) {
                    $insertVal['metadata_series'] = $response_data['metadata']['series'];
                }
                if (isset($response_data['metadata']['industry'])) {
                    $insertVal['metadata_industry'] = $response_data['metadata']['industry'];
                }
                if (isset($response_data['metadata']['status'])) {
                    $insertVal['metadata_status'] = $response_data['metadata']['status'];
                }
                if (isset($response_data['metadata']['listingDate'])) {
                    $insertVal['metadata_listdate'] = date("Y-m-d", strtotime($response_data['metadata']['listingDate']));
                }
                if (isset($response_data['metadata']['pdSectorInd'])) {
                    $insertVal['metadata_pd_sectorind'] = trim($response_data['metadata']['pdSectorInd']);
                }
                if (isset($response_data['securityInfo']['boardStatus'])) {
                    $insertVal['securityinfo_boardStatus'] = str_replace("-","",$response_data['securityInfo']['boardStatus']);
                }
                if (isset($response_data['securityInfo']['tradingStatus'])) {
                    $insertVal['securityinfo_tradingStatus'] = str_replace("-","",$response_data['securityInfo']['tradingStatus']);
                }
                if (isset($response_data['securityInfo']['tradingSegment'])) {
                    $insertVal['securityinfo_tradingSegment'] = str_replace("-","",$response_data['securityInfo']['tradingSegment']);
                }
                if (isset($response_data['securityInfo']['faceValue'])) {
                    $insertVal['securityinfo_facevalue'] = str_replace("-","0",$response_data['securityInfo']['faceValue']);
                }
                if (isset($response_data['securityInfo']['issuedSize'])) {
                    $insertVal['securityinfo_issuedsize'] = str_replace("-","0",$response_data['securityInfo']['issuedSize']);
                }
                if (isset($response_data['securityInfo']['surveillance']['surv'])) {
                    $insertVal['securityinfo_surveillance_surv'] = $response_data['securityInfo']['surveillance']['surv'];
                }
                if (isset($response_data['securityInfo']['surveillance']['desc'])) {
                    $insertVal['securityinfo_surveillance_desc'] = $response_data['securityInfo']['surveillance']['desc'];
                }
                $priceInfo = $response_data['priceInfo'];
                if (isset($priceInfo['lastPrice'])) {
                    $insertVal['priceinfo_lastprice'] = $priceInfo['lastPrice'];
                }
                if (isset($priceInfo['change'])) {
                    $insertVal['priceinfo_change'] = $priceInfo['change'];
                }
                if (isset($priceInfo['pChange'])) {
                    $insertVal['priceinfo_pchange'] = $priceInfo['pChange'];
                }
                if (isset($priceInfo['previousClose'])) {
                    $insertVal['priceinfo_prev_close'] = $priceInfo['previousClose'];
                }
                if (isset($priceInfo['open'])) {
                    $insertVal['priceinfo_open'] = $priceInfo['open'];
                }
                if (isset($priceInfo['intraDayHighLow']['min'])) {
                    $insertVal['priceinfo_intraday_min'] = $priceInfo['intraDayHighLow']['min'];
                }
                if (isset($priceInfo['intraDayHighLow']['max'])) {
                    $insertVal['priceinfo_intraday_max'] = $priceInfo['intraDayHighLow']['max'];
                }
                if (isset($priceInfo['close'])) {
                    $insertVal['priceinfo_close'] = $priceInfo['close'];
                }
                if (isset($priceInfo['lowerCP'])) {
                    $insertVal['priceinfo_lowerCP'] = str_replace("-","0",$priceInfo['lowerCP']);
                }
                if (isset($priceInfo['upperCP'])) {
                    $insertVal['priceinfo_upperCP'] = str_replace("-","0",$priceInfo['upperCP']);
                }
                if (isset($priceInfo['weekHighLow']['min'])) {
                    $insertVal['priceinfo_52low'] = $priceInfo['weekHighLow']['min'];
                }
                if (isset($priceInfo['weekHighLow']['minDate'])) {
                    $insertVal['priceinfo_52lowdate'] = date("Y-m-d", strtotime($priceInfo['weekHighLow']['minDate']));
                }
                if (isset($priceInfo['weekHighLow']['max'])) {
                    $insertVal['priceinfo_52High'] = $priceInfo['weekHighLow']['max'];
                }
                if (isset($priceInfo['weekHighLow']['maxDate'])) {
                    $insertVal['priceinfo_52HighDate'] = date("Y-m-d", strtotime($priceInfo['weekHighLow']['maxDate']));
                }
                if (isset($response_data['industryInfo']['macro'])) {
                    $insertVal['industryinfo_macro'] = $response_data['industryInfo']['macro'];
                }
                if (isset($response_data['industryInfo']['sector'])) {
                    $insertVal['industryinfo_sector'] = $response_data['industryInfo']['sector'];
                }
                if (isset($response_data['industryInfo']['industry'])) {
                    $insertVal['industryinfo_industry'] = $response_data['industryInfo']['industry'];
                }
                if (isset($response_data['industryInfo']['basicIndustry'])) {
                    $insertVal['industryinfo_basicindustry'] = $response_data['industryInfo']['basicIndustry'];
                }
                $metadata_last = $response_data['metadata']['lastUpdateTime'];
                if (isset($metadata_last)) {
                    $insertVal['metadata_lastUpdateTime'] = ($metadata_last == "-") ? date("Y-m-d H:i:s") : date("Y-m-d H:i:s", strtotime($metadata_last));
                }
                $insertVal['today_process_status'] = "success";
                $insertVal['stock_log_date'] = date("Y-m-d H:i:s");
                $insertVal['stock_last_date'] = date("Y-m-d", strtotime($insertVal['metadata_lastUpdateTime']));
            
                DB::table('all_stock_list_data')
                    ->updateOrInsert(
                        ['info_symbol' => $insertVal['info_symbol'], 'stock_last_date' => $insertVal['stock_last_date']],
                        $insertVal
                    );
                DB::table('all_stock_list_data_uniq')
                ->updateOrInsert(
                    ['info_symbol' => $insertVal['info_symbol']],
                    $insertVal
                );
            }
        }

        return "success";
    }

}
