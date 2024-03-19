<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait watchListTraits {

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function getWatchlist() {

        $query_string = DB::table('watchlist_stock')->where('watchlist_status', 1)->get();
    
        $array_list = array();
        foreach($query_string as $result)
        {
            $array_list[] = $result->watchlist_stock_id;
        }
        return $array_list;
    }

}