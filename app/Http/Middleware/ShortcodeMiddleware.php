<?php

namespace App\Http\Middleware;

use Closure;
use App\Group;
use App\Post;
use App\Data;

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
            foreach ($VPgsLocs as $key => $value2) {
              preg_match_all($preg_match_all, $value, $matches);

              if (is_array($value2)) {
                $matches[3][0] = str_replace('[link]', $value2['url'], $matches[3][0]);
                $matches[3][0] = str_replace('[name]', $key, $matches[3][0]);

                echo  $matches[3][0];

                page_list($value2['content'], $value, $preg_match_all);
                echo  $matches[5][0];
              } else {
                if ('url' !== $key) {
                  $matches[9][0] = str_replace('[name]', $key, $matches[9][0]);
                  $matches[9][0] = str_replace('[link]', $value2, $matches[9][0]);
                  echo  $matches[9][0];
                }
              }
            }
          }

          foreach ($matches[0] as $key => $value) {
            if (!empty($routeParameters)) {
              $routeParameters = array_values($routeParameters);
              $arguments2[0] = $routeParameters[0];

              $GroupShowID = Group::ShowID($routeParameters);
              $VPgsLocs = Post::ShowSubPost($GroupShowID, $routeParameters);

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
        preg_match_all('/\[r\](.*)\[\/r\]/', $responceContent, $matches2);

        if (!empty($matches2[0]) and !empty($routeParameters)) {
          foreach ($matches2[0] as $key => $value) {
            $shortcode = $value;
            $parameter = str_replace('[r]', '', $shortcode);
            $parameter = str_replace('[/r]', '', $parameter);

            $Attr = Data::ShowAttributeTypes();

            $DataShowRelSig = $parameter;

            $DataShowID = Data::ShowID($routeParameters, $DataShowRelSig);
            $DataValues = Data::Show($DataShowID);

            $result = $DataValues[$Attr[2]];

            $responceContent = str_replace($shortcode, $result, $responceContent);
          }
        }

        return $responceContent;
      }

      $responceContent = menu($responce, $routeParameters);

      $responceContent = reference($responceContent, $routeParameters);
      $responceContent = reference($responceContent, $routeParameters);

      $responce->setContent($responceContent);

      return $responce;
    }
  }
}
