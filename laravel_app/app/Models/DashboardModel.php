<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardModel extends Model
{
    use HasFactory;

    protected $table = 'stock_market';

    public function getHad(){
        return 'd';
    }
}
