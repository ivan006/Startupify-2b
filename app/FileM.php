<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use App\GroupM;
use App\PostM;
use App\SmartDataItemM;




class FileM extends Model
{

  public static function CreateFromZip($arguments, $request,$SubLocation) {
    $ShowID = PostM::ShowID($arguments);

    $request->zip_file->storeAs("public/".$ShowID."/".$SubLocation, $request->zip_file->getClientOriginalName());
    // $path = "Econet/".GroupM::ShowBaseLocation().$ShowID."/".$request->zip_file->getClientOriginalName();
    // $path = GroupM::ShowBaseLocation().$ShowID."/".$request->zip_file->getClientOriginalName();
    $path = GroupM::ShowBaseLocation().$ShowID."/".$SubLocation.$request->zip_file->getClientOriginalName();
    // dd($path);
    // $Path = public_path($ShowID);

    $zipper = new \Chumper\Zipper\Zipper;
    $zipper->make($path)->extractTo(GroupM::ShowBaseLocation().$ShowID."/".$SubLocation);
    $zipper->close();
    unlink(GroupM::ShowBaseLocation().$ShowID."/".$SubLocation.$request->zip_file->getClientOriginalName());

  }
}
