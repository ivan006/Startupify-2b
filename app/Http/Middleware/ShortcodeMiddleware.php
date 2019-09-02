<?php

namespace App\Http\Middleware;

use Closure;
use App\Group;
use App\Report;
use App\Data;
use App\Entity;

class ShortcodeMiddleware
{
  /**
  * Handle an incoming request.
  *
  * @param \Illuminate\Http\Request $request
  * @param \Closure                 $next
  *
  * @return mixed
  */
  public function handle($request, Closure $next)
  {
    $responce = $next($request);
    if (!method_exists($responce, 'content')) {
      return $responce;
    } else {
      $routeParameters = $request->route()->parameters();
      $routeParameters = array_values($routeParameters);

      function menu($responce, $routeParameters)
      {
        $responceContent = $responce->content();

        $preg_match_all = "/\[page_list\]((.|\n)*?)\[twig\]((.|\n)*?)\[inner_twig\]((.|\n)*?)\[\/twig\]((.|\n)*?)\[leaf\]((.|\n)*?)\[\/leaf\]((.|\n)*?)\[\/page_list\]/";

        preg_match_all($preg_match_all, $responceContent, $matches);
        if (!empty($matches[0])) {
          function page_list($VPgsLocs, $value, $preg_match_all)
          {

            if (!empty($VPgsLocs)) {
              foreach ($VPgsLocs as $key => $value2) {
                preg_match_all($preg_match_all, $value, $matches);

                if (is_array($value2)) {
                  $matches[3][0] = str_replace('[link]', $value2['url'], $matches[3][0]);
                  $matches[3][0] = str_replace('[name]', $value2['name'], $matches[3][0]);

                  echo  $matches[3][0];

                  page_list($value2['content'], $value, $preg_match_all);
                  echo  $matches[5][0];
                } else {
                  if ('url' !== $key) {
                    $matches[9][0] = str_replace('[name]', $value2['name'], $matches[9][0]);
                    $matches[9][0] = str_replace('[link]', $value2, $matches[9][0]);
                    echo  $matches[9][0];
                  }
                }
              }
            }
          }
          // dd($matches[0]);
          foreach ($matches[0] as $key => $value) {
            if (!empty($routeParameters)) {
              $routeParameters = array_values($routeParameters);
              $arguments2[0] = $routeParameters[0];

              $Slug = null;

              $BaseEntityType = 'Group';
              $BaseEntityID = Group::ShowID($routeParameters);
              $EntityType ='Report';

              $VPgsLocs = Entity::ShowMulti($BaseEntityType,$BaseEntityID, $EntityType,$Slug);

              ob_start();

              if (is_array($VPgsLocs)) {
                page_list($VPgsLocs, $value, $preg_match_all);
              }

              $result = ob_get_contents();
              ob_end_clean();

              $responceContent = str_replace($value, $result, $responceContent);
            } else {
              $responceContent = str_replace($value, null, $responceContent);
            }
          }
        }


        return $responceContent;
      }

      function reference($responceContent, $routeParameters)
      {
        preg_match_all('/\[g\](.*)\[\/g\]/', $responceContent, $matches2);

        if (!empty($matches2[0]) and !empty($routeParameters)) {
          foreach ($matches2[0] as $key => $value) {
            $shortcode = $value;
            $parameter = str_replace('[g]', '', $shortcode);
            $parameter = str_replace('[/g]', '', $parameter);

            $Attr = Entity::ShowAttributeTypes();

            $DataShowRelSig = $parameter;

            $DataShowID = Data::ShowID($routeParameters, $DataShowRelSig);
            $DataValues = Data::Show($DataShowID);

            // $result = $DataShowID;
            $result = $DataValues[$Attr[2]];

            $responceContent = str_replace($shortcode, $result, $responceContent);
          }
        }

        return $responceContent;
      }


      function structure_foreach($responceContent, $routeParameters)
      {

        // $preg_match_all = "/\[s type=`foreach` var=`\[g type=`foreach`\]Book\[\/g\]` level=`1`\]((.|\r\n)*?)\[\/s type=`foreach` var=`value` level=`1`\]/";
        // $preg_match_all = "/\[s type=`foreach` var=`\[g type=`foreach`\]Book\/Chapter 1\/Dialogue set 1\[\/g\]` level=`1`\]((.|\r\n)*?)\[\/s type=`foreach` var=`\[g type=`foreach`\]Book\/Chapter 1\/Dialogue set 1\[\/g\]` level=`1`\]/";
        $preg_match_all = "/\[s type=`foreach` var=`\[g type=`foreach`\](.*?)\[\/g\]` level=`1`\]((.|\r\n)*?)\[\/s type=`foreach` var=`\[g type=`foreach`\](.*?)\[\/g\]` level=`1`\]/";

        preg_match_all($preg_match_all, $responceContent, $matches, PREG_SET_ORDER);
        // dd($matches);
        if (!empty($matches)) {
          foreach ($matches as $key => $value) {

            // $DataShowRelSig = "Book/Chapter 1/Dialogue set 1";
            // $DataShowRelSig = "Book/Chapter 1";
            $DataShowRelSig = $value[1];
            // dd($DataShowRelSig);
            $DataShowID = Data::ShowID($routeParameters, $DataShowRelSig);


            $BaseEntityID = $DataShowID;
            $BaseEntityType = 'Data';
            $EntityType = 'Data';
            $Slug = null;

            $EntityShowMulti = Entity::ShowMulti($BaseEntityType,$BaseEntityID, $EntityType,$Slug);

            $DataShowName = explode('/',$DataShowRelSig);
            $DataShowName = end($DataShowName);
            $DataShowName = base64_encode($DataShowName);

            $result = null;

            foreach ($EntityShowMulti[$DataShowName]['content'] as $key => $value2) {
              $result2 = $value[2];
              // echo 1;

              $pattern = '/\[g type=`foreach`\](.*?)\[\/g\]/';
              preg_match_all($pattern, $value[2], $matches2, PREG_SET_ORDER);

              foreach ($matches2 as $key => $value3) {

                $DataShowName2 = base64_encode($value3[1]);

                // $result4 =  $value2['name'];
                $result4 =  $value2['content'][$DataShowName2]['content'].'<br>';

                $result2 = str_replace($value3[0], $result4, $result2);
              }
              // dd($result2);

              $result = $result.$result2;
            }
            // dd($result);
            $responceContent = str_replace($value[0], $result, $responceContent);
          }
        }


        return $responceContent;
      }


      $responceContent = menu($responce, $routeParameters);

      $responceContent = reference($responceContent, $routeParameters);
      $responceContent = structure_foreach($responceContent, $routeParameters);

      $responce->setContent($responceContent);

      return $responce;
    }
  }
}
