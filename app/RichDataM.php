<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use App\GroupM;
use App\PostM;
use App\SmartDataItemM;




class RichDataM extends Model
{

  public static function Show(){
    $ShowID = PostM::ShowID(func_get_args()[0]);
    $stuff = PostM::ShowLocation($ShowID)."/"."rich.html";
    if (file_exists($stuff)) {
      return  file_get_contents($stuff);;
    }
  }


}
