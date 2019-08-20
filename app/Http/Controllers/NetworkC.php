<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupM;
use App\PostM;
use App\MetadataM;
use App\RichDataM;
use App\SmartDataItemM;

use App\Group;
use App\Post;
use App\Data;
use App\Metadata;
use App\RichData;
use App\SmartDataItem;






class NetworkC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $routeParameters = func_get_args();
      array_shift($routeParameters);
      // dd($routeParameters);

      if (!empty($routeParameters)) {
        Post::Store($routeParameters, $request);
        $allURLs = Post::ShowActions($routeParameters);
        return redirect($allURLs['sub_post_edit']);
      } else {
        Group::Add($request);
        $allURLs = Post::ShowActions($routeParameters);
        return redirect($allURLs['sub_post_edit']);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(){

      $routeParameters = func_get_args();
      if (empty($routeParameters)) {
        // dd($routeParameters);
        $allURLs = Post::ShowActions($routeParameters);
        $PostList = Group::ShowAll();
        return view('network-read', compact('PostList', 'allURLs'));
      } else {


        $allURLs = Post::ShowActions($routeParameters);

        $DataShowRelSig = Data::ShowRelativeSignature("Details/Rich.txt");
        $DataShowID = Data::ShowID($routeParameters,$DataShowRelSig);
        // dd($DataShowID);
        if (!empty($DataShowID)) {
          // code...
          $DataValues = Data::Show($DataShowID);
        } else {
          // dd(1);
          $DataValues = null;
        }

        $Attr = Data::ShowAttributeTypes();
        $RichDataShow = $DataValues[$Attr[2]];
        // dd($RichDataShow);
        // $ShowBaseIDPlusBaseLocation = Post::ShowBaseIDPlusBaseLocation($routeParameters);
        // $headerDataShow = Data::$ShowBaseIDPlusBaseLocation  ."/header.txt";
        // $headerDataShow = 'abcdefghijklmo';
        return view('group-read', compact('allURLs', 'RichDataShow'));
      }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(){
      $routeParameters = func_get_args();
      $arguments = func_get_args();
      if (!empty($arguments)) {
        array_shift($arguments);
        array_shift($arguments);
        $ShowID = PostM::ShowID($routeParameters);

        $Attr = Data::ShowAttributeTypes();
        $DataShowAll[$Attr[2]] = Data::ShowAll($routeParameters);
        // dd($DataShowAll);
        // $ShowAllShallowSmartData = PostM::ShowAllShallowSmartData($routeParameters);
        $SmartDataItemM_ShowActions = Data::ShowActions();

        $allURLs = Post::ShowActions($routeParameters);


        $DataShowRelSig = Data::ShowRelativeSignature("Details/Rich.txt");
        $DataShowID = Data::ShowID($routeParameters,$DataShowRelSig);
        // dd($DataShowID);
        if (!empty($DataShowID)) {
          // code...
          $DataValues = Data::Show($DataShowID);
        } else{
          // dd(1);
          $DataValues = null;
        }
        $RichDataShow = $DataValues[$Attr[2]];

        $PostShowImSubPosts = Post::ShowImmediateSubPost($routeParameters);


        return view('group-edit', compact('DataShowAll','allURLs','RichDataShow','Attr','PostShowImSubPosts'));
      } else {
        $allURLs = Post::ShowActions(func_get_args());
        $PostList = Group::ShowAll();
        $SmartDataItemM_ShowActions = Data::ShowActions();
        return view('network-edit', compact('PostList', 'allURLs', 'SmartDataItemM_ShowActions'));
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
