<?php

class Twitter{
  function getTweets(){
      ini_set('display_errors',1);
      require_once('TwitterAPIExchange.php');

      $settings = array('oauth_access_token' => "348069833-ZuXLAANB78ygs1VFoZpOZ08oGOZsQh9GvmV2e53b",
                        'oauth_access_token_secret' => "mW6nE0U2gRN6XnZ8I2bU6mFaxmaHF0eOXa9wRZRe3pviG",
                        'consumer_key' => "zkyaUhh6fmAgtDFakFLy6ZrK7",
                        'consumer_secret' => "IeeGjaLauKK1X9rSgd2uPlfF9kdNf9Tcidr2HQHWFtvAmQL73k");

      $url = 'https://api.twitter.com/1.1/search/tweets.json';
      $getfield = '?geocode=10.9838039,-74.8880581,10km&count=100';
      $requestMethod = 'GET';
      $twitter = new TwitterAPIExchange($settings);
      $json = $twitter->setGetfield($getfield)
                 ->buildOauth($url, $requestMethod)
                ->performRequest();
      return $json;
  }
  function getInfoTwitter($contenedorJson){
    $count = 0;
      $rawdata = "";
      $json = "";
      for($i=0;$i<count($contenedorJson);$i++){
        
        //$json = $contenedorJson[$i];
        $json = json_decode($contenedorJson);
        $num_items = count($json->statuses);

        for ($j=0; $j<$num_items; $j++){
          $user = $json->statuses[$j];
          $id_tweet = $user->id_str;
          $fecha = $user->created_at;
          $url_imagen = $user->user->profile_image_url;
          $screen_name = $user->user->screen_name;
          $imagen = "<a href='https://twitter.com/".$screen_name."' target=_blank><img src=".$url_imagen."></img></a>";
          $tweet = $user->text;

          if(!empty($user->geo->coordinates[0])){
            $latitud = $user->geo->coordinates[0];
            $longitud = $user->geo->coordinates[1];
          }
          else{
            $latitud = 0;
            $longitud = 0;
          }
          $rawdata[$count][0] = $fecha;
          $rawdata[$count]["Fecha"] = $fecha;
          $rawdata[$count][1] = $imagen;
          $rawdata[$count]["Imagen"] = $imagen;
          $rawdata[$count][3] = $url_imagen;
          $rawdata[$count]["Imagen_url"] = $url_imagen; 
          $rawdata[$count][4]="@".$screen_name;
          $rawdata[$count]["Nombre"]="@".$screen_name;
          $rawdata[$count][5]=$tweet;
          $rawdata[$count]["Tweet"]=$tweet;
          $rawdata[$count][6]=$latitud;
          $rawdata[$count]["Latitud"]=$latitud;
          $rawdata[$count][7]=$longitud;
          $rawdata[$count]["Longitud"]=$longitud;
          $count++;
        }
      }
      return $rawdata;  
  }
    function displayTable($rawdata){
      //DIBUJAR TABLA
      echo '<table border=1';
      $columnas = count($rawdata[0])/2;
      echo $columnas;
      $filas = count($rawdata);
      echo "<br>".$filas."<br>";
      // //Añadimos los titulos
      for($i=1;$i<count($rawdata[0]);$i=$i+2){
           next($rawdata[0]);
           echo "<th><b>".key($rawdata[0])."</b></th>";
           next($rawdata[0]);
      }
      //for($i=0;$i<$filas;$i++){
      //     echo "<tr>";
      //     for($j=0;$j<$columnas;$j++){
      //         echo "<td>".$rawdata[$i][$j]."</td>";
      //     }
      //     echo "</tr>";
      }
      echo '</table>';
      print_r($rawdata[0][1]);
  }
}
  $twitterObject = new Twitter();
  $jsonraw = $twitterObject->getTweets();
  $rawdata = $twitterObject->getInfoTwitter($jsonraw);
  $twitterObject->displayTable($rawdata);
?>