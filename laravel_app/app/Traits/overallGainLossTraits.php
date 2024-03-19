<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait overallGainLossTraits {

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function getOverallGainLoss() {

        $portfoliList = DB::table('portfolio_list')->get();
		$overAllAmt = 0;
		$totalInvAmt = 0;
		foreach($portfoliList as $row){
			$stock_qty = $row->stock_qty;
			$stock_price = $row->stock_price;
			$stock_symbol = $row->info_symbol;

			$query_1 = DB::table('all_stock_list_data_uniq')->where('info_is_suspended', '<>', '1')->where('info_symbol',$stock_symbol)->where('securityinfo_tradingStatus','Active')->where('securityinfo_tradingSegment','Normal Market')->first();
			if(!empty($query_1)){
				$totalInvAmt = $totalInvAmt+($stock_qty* $stock_price);
				$overAllAmt = $overAllAmt+$stock_qty* $query_1->priceinfo_lastprice;
			}
		}

        $overAllAmt = round($overAllAmt,2);
        $totalInvAmt = round($totalInvAmt,2);
        $gainlossAmt = round($overAllAmt-$totalInvAmt,2);
		$gainlosePer = round((($overAllAmt-$totalInvAmt)/$totalInvAmt)*100,2);
        $returnData['overAllAmt'] = $overAllAmt;
        $returnData['totalInvAmt'] = $totalInvAmt;
        $returnData['gainlossAmt'] = $gainlossAmt;
        $returnData['gainlosePer'] = $gainlosePer;
        return $returnData;
    }

}