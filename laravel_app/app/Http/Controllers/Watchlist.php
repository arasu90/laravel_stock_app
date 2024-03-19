<?php

namespace App\Http\Controllers;

use App\Traits\watchListTraits;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Watchlist extends Controller
{
    use watchListTraits;
    public function index()
    {
        $getWatchlist = $this->getWatchlist();
        $queryList = DB::table('watchlist_stock')->select(DB::raw('group_concat(watchlist_stock_id) as watchlist_stock_ids'))->where('watchlist_status', 1)->first();
        $whereIn = explode(",",$queryList->watchlist_stock_ids);

        $watchList = DB::table('all_stock_list_data_uniq')->select('info_symbol','priceinfo_lastprice','info_name','priceinfo_pchange','priceinfo_change', 'priceinfo_prev_close','priceinfo_open','priceinfo_intraday_min','priceinfo_intraday_max','priceinfo_lowerCP','priceinfo_upperCP','priceinfo_52low','priceinfo_52lowdate','priceinfo_52HighDate','priceinfo_52High')->where('info_is_suspended', '<>', 1)->where('securityinfo_tradingStatus', 'Active')->where('securityinfo_tradingSegment', 'Normal Market')->whereIn('info_symbol', $whereIn)->orderBy('info_symbol')->get();

        return view('watchlist', ['watchList'=> $watchList, 'getWatchlist'=>$getWatchlist]);
    }

    public function addwatchlist($delete_id)
    {
        $queryList = DB::table('watchlist_stock')->where('watchlist_stock_id', $delete_id)->count();
        if($queryList>0){
            DB::table('watchlist_stock')->where(['watchlist_stock_id'=>$delete_id])->delete();
        }else{
            DB::table('watchlist_stock')->insert(['watchlist_stock_id'=>$delete_id, 'watchlist_user_id'=>100,'watchlist_status'=>1]);
        }
        return redirect()->back();
    }
}
