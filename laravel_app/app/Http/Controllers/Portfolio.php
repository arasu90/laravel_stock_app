<?php

namespace App\Http\Controllers;

use App\Traits\overallGainLossTraits;
use App\Traits\watchListTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Portfolio extends Controller
{
    use watchListTraits, overallGainLossTraits;
    public function index()
    {
        $getWatchlist = $this->getWatchlist();
        $allStockList = DB::table('all_stock')->where('stock_status','1')->groupBy('stock_name')->orderBy('stock_name')->get();
        $totalInvAmt = 0;
        $overAllAmt = 0;
        $gainlossAmt = 0;
        $gainlosePer = 0;

        $myProtfolioData = DB::table('portfolio_list as pl')->select('pl.list_id', 'pl.info_symbol', 'asld.info_name', DB::raw('round(sum(pl.stock_qty)) stock_qty'),  DB::raw('round(sum(pl.stock_price*pl.stock_qty),2) inv_amt'),  DB::raw('round(sum(pl.stock_price*pl.stock_qty)/sum(pl.stock_qty),2) stock_price'),  DB::raw('round(asld.priceinfo_change*sum(pl.stock_qty),2) as today_amt'),  DB::raw('round((sum(pl.stock_qty)* asld.priceinfo_lastPrice)-(sum(pl.stock_price*pl.stock_qty)),2) overall_amt'),  DB::raw('round(sum(pl.stock_qty)* asld.priceinfo_lastPrice,2) total_amt'),  DB::raw('asld.priceinfo_lastPrice as live_price'),  DB::raw('max(pl.purchase_date) purchase_date'),  DB::raw('asld.priceinfo_pchange price_change_per'),  DB::raw('asld.priceinfo_change price_change'))->join('all_stock_list_data_uniq as asld', 'asld.info_symbol', '=','pl.info_symbol')->groupBy('pl.info_symbol')->orderBy('pl.info_symbol','ASC')->get();

        $myProtfolioDetails = DB::table('portfolio_list as pl')->select('pl.list_id', 'pl.info_symbol', 'asld.info_name', DB::raw('round(sum(pl.stock_qty)) stock_qty'),  DB::raw('round(sum(pl.stock_price*pl.stock_qty),2) inv_amt'),  DB::raw('round(sum(pl.stock_price*pl.stock_qty)/sum(pl.stock_qty),2) stock_price'),  DB::raw('round(asld.priceinfo_change*sum(pl.stock_qty),2) as today_amt'),  DB::raw('round((sum(pl.stock_qty)* asld.priceinfo_lastPrice)-(sum(pl.stock_price*pl.stock_qty)),2) overall_amt'),  DB::raw('round(sum(pl.stock_qty)* asld.priceinfo_lastPrice,2) total_amt'),  DB::raw('asld.priceinfo_lastPrice as live_price'),  DB::raw('max(pl.purchase_date) purchase_date'),  DB::raw('asld.priceinfo_pchange price_change_per'),  DB::raw('asld.priceinfo_change price_change'))->join('all_stock_list_data_uniq as asld', 'asld.info_symbol', '=','pl.info_symbol')->groupBy('pl.list_id')->orderBy('pl.info_symbol','ASC')->get();

        $overallData = $this->getOverallGainLoss();
        $overAllAmt = $overallData['overAllAmt'];
        $gainlossAmt = $overallData['gainlossAmt'];
        $gainlosePer = $overallData['gainlosePer'];
        $totalInvAmt = $overallData['totalInvAmt'];
        return view('portfolio', ['allstocklist'=> $allStockList, 'totalInvAmt'=>$totalInvAmt, 'overAllAmt'=>$overAllAmt, 'gainlossAmt'=>$gainlossAmt, 'gainlossPer'=>$gainlosePer, 'myProtfolioData'=>$myProtfolioData, 'myProtfolioDetails'=>$myProtfolioDetails,'getWatchlist'=>$getWatchlist]);
    }

    public function saveportfolio(Request $request)
    {
        $buy_stock = $request->input('purchase_stock');
        $buy_qty = $request->input('purchase_qty');
        $buy_rate = $request->input('purchase_rate');
        $buy_date = date("Y-m-d", strtotime($request->input('purhcase_date')));

        DB::table('portfolio_list')->insert(['user_id'=>'100','info_symbol'=>$buy_stock,'stock_qty'=>$buy_qty,'stock_price'=>$buy_rate,'purchase_date'=>$buy_date, 'list_status'=>1]);
        return redirect('/myportfolio');

    }

    public function deletePortfolio(Request $request)
    {
        $list_id = $request->input('del_id');

        DB::table('portfolio_list')->where(['list_id'=>$list_id])->delete();
        return redirect('/myportfolio');

    }
}
