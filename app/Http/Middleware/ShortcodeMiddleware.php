<?php

namespace App\Http\Middleware;

use Closure;
use App\GroupM;
use App\PostM;
use App\SmartDataItemM;

use App\Group;
use App\Post;
use App\Data;



class ShortcodeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        $responce = $next($request);
        if (!method_exists($responce, "content")) {
          return $responce;
        } else {


          $routeParameters = $request->route()->parameters();
          $routeParameters = array_values($routeParameters);

          function menu($responce,$routeParameters){
            // code...
            $responceContent = $responce->content();



            $preg_match_all = "/\[page_list\]((.|\n)*?)\[twig\]((.|\n)*?)\[inner_twig\]((.|\n)*?)\[\/twig\]((.|\n)*?)\[leaf\]((.|\n)*?)\[\/leaf\]((.|\n)*?)\[\/page_list\]/";

            preg_match_all( $preg_match_all, $responceContent, $matches);
            if (!empty($matches[0])) {
              function page_list($VPgsLocs, $value, $preg_match_all){
                // dd($VPgsLocs);
                foreach($VPgsLocs as $key => $value2){
                  preg_match_all( $preg_match_all, $value, $matches);
                  // echo "<pre>";
                  // var_dump($matches);
                  // echo "</pre>";


                  if (is_array($value2)) {

                    // $preg_match_all = "/\[link\]/";
                    // dd($value2['url']);
                    $matches[3][0] = str_replace("[link]", $value2['url'], $matches[3][0]);
                    $matches[3][0] = str_replace("[name]", $key, $matches[3][0]);

                    echo  $matches[3][0];
                    // echo  $value2['url'];
                    // echo $key ;
                    page_list($value2["content"], $value, $preg_match_all);
                    echo  $matches[5][0];

                  } else {
                    if ($key !== "url") {

                      // echo  $value2;
                      // echo $key;
                      $matches[9][0] = str_replace("[name]", $key, $matches[9][0]);
                      $matches[9][0] = str_replace("[link]", $value2, $matches[9][0]);
                      echo  $matches[9][0];
                    }
                  }
                }
              }

              // dd($routeParameters);
              // dd($PostShowSig);
                // code...
                // dd($routeParameters);


                foreach ($matches[0] as $key => $value) {
                  if (!empty($routeParameters)) {
                    $routeParameters = array_values($routeParameters);
                    $arguments2[0] = $routeParameters[0];
                    // dd($routeParameters);


                    $GroupShowID = Group::ShowID($routeParameters);
                    $VPgsLocs = Post::ShowSubPost($GroupShowID,$routeParameters);
                    // dd($arguments2);
                    // dd($VPgsLocs);
                    ob_start();
                    // dd($VPgsLocs);
                    if (is_array($VPgsLocs)) {
                      page_list($VPgsLocs,  $value,$preg_match_all);
                    }

                    $result = ob_get_contents();
                    ob_end_clean();

                    $responceContent = str_replace($value, $result, $responceContent);
                  } else {

                    $responceContent = str_replace($value, null, $responceContent);
                  }

                }
                // code  example ..
                // <div class="g-multi-level-dropdown">
                //   <ul>
                //     [page_list]
                //     [twig]
                //     <li>
                //       <a href="[link]">
                //         [name]
                //       </a>
                //       <span class="toggle">
                //       <a href="#">+</a>
                //       <ul>
                //         [inner_twig]
                //       </ul>
                //       </span>
                //     </li>
                //     [/twig]
                //     [leaf]
                //     <li>
                //       <a href="[link]">
                //         [name]
                //       </a>
                //     </li>
                //     [/leaf]
                //     [/page_list]
                //   </ul>
                // </div>

            }
            return $responceContent;
          }

          function reference($responceContent,$routeParameters){
            // code...
            preg_match_all( '/\[r\](.*)\[\/r\]/', $responceContent, $matches2);

            if (!empty($matches2[0]) AND !empty($routeParameters)) {

              // dd($matches2);

              foreach ($matches2[0] as $key => $value) {
                // echo $value;
                $shortcode = $value;
                $parameter = str_replace("[r]", "", $shortcode);
                $parameter = str_replace("[/r]", "", $parameter);

                $Attr = Data::ShowAttributeTypes();

                $DataShowRelSig = $parameter;
                // dd($DataShowRelSig);
                $DataShowID = Data::ShowID($routeParameters,$DataShowRelSig);
                $DataValues = Data::Show($DataShowID);
                // dd($DataValues);

                $result = $DataValues[$Attr[2]];

                // dd($DataValues);

                $responceContent = str_replace($shortcode, $result, $responceContent);

              }

            }

            return $responceContent;
          }

          $responceContent = menu($responce,$routeParameters);

          $responceContent = reference($responceContent,$routeParameters);
          $responceContent = reference($responceContent,$routeParameters);

          $responce->setContent($responceContent);
          return $responce;
        }


    }

}
