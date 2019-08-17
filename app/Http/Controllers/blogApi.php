<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class blogApi extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($a = null,$b = null,$c = null,$d = null){

        // model part? start



          if (1==1) {
            $dir = "../public/images";
            function dirToArray($dir) {
              $result = array();
              $cdir = scandir($dir);
              foreach ($cdir as $key => $value) {
                if (!in_array($value,array(".","..")))  {
                  $sub_dir = $dir . DIRECTORY_SEPARATOR . $value;


                  if (is_dir($sub_dir)){

                    $result[$value] = dirToArray($sub_dir);

                  } else {
                    // $result[$value] = str_replace("../public/images", "", $sub_dir);
                    $result[$value] = file_get_contents($sub_dir);

                  }
                }
              }
              return $result;
            }
            $ivan1 = dirToArray($dir);

          }


        // responceDecision 1 starts
          // if (1==1) {
          //   // $a = '{"a":0}';
          //   // $a = '{"ab":{"a":0}}';
          //   // $a = '{"ab":{"a":{"email":0}}}';
          //
          //   $a = json_decode($a, true);
          //
          //   if (is_array($a)) {
          //     function recursive_array_intersect_key(array $array1, array $array2) {
          //         $array1 = array_intersect_key($array1, $array2);
          //         foreach ($array1 as $key => &$value) {
          //             if (is_array($value) && is_array($array2[$key])) {
          //                 $value = recursive_array_intersect_key($value, $array2[$key]);
          //             }
          //         }
          //         return $array1;
          //     }
          //     $ivan2 = recursive_array_intersect_key($ivan1,$a);
          //   }
          //
          //   if (empty($ivan2)) {
          //     $ivan = $ivan1;
          //   } else {
          //     $ivan = $ivan2;
          //   }
          //
          // }
        // responceDecision 1 end


        // responceDecision 2 starts

          if (1==1) {
            $error = json_decode('[]', true);


            if (isset($d)) {
              if (
                array_key_exists($a, $ivan1) and
                array_key_exists($b, $ivan1[$a]) and
                array_key_exists($c, $ivan1[$a][$b]) and
                array_key_exists($d, $ivan1[$a][$b][$c])
              ) {
                if (is_array($ivan1[$a][$b][$c][$d])) {

                  return response()->json($ivan1[$a][$b][$c][$d]);
                } else {

                  return $ivan1[$a][$b][$c][$d];
                }
              } else {
                return response()->json($error);
              }
            } elseif (isset($c)) {
              if (
                array_key_exists($a, $ivan1) and
                array_key_exists($b, $ivan1[$a]) and
                array_key_exists($c, $ivan1[$a][$b])
              ) {
                if (is_array($ivan1[$a][$b][$c])) {

                  return response()->json($ivan1[$a][$b][$c]);
                } else {

                  return $ivan1[$a][$b][$c];
                }
              } else {
                return response()->json($error);
              }
            } elseif (isset($b)) {
              if (
                array_key_exists($a, $ivan1) and
                array_key_exists($b, $ivan1[$a])
              ) {
                if (is_array($ivan1[$a][$b])) {

                  return response()->json($ivan1[$a][$b]);
                } else {

                  return $ivan1[$a][$b];
                }

              } else {
                return response()->json($error);
              }
            } elseif (isset($a)) {
              if (
                array_key_exists($a, $ivan1)
              ) {
                return response()->json($ivan1[$a]);
              } else {
                return response()->json($error);
              }
            } else {
              return response()->json($ivan1);
            }
          }
        // responceDecision 2 starts

        // model part? end

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
