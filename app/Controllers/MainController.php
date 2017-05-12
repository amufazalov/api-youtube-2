<?php
namespace App\Controllers;

use App\Base\Controller;
use App\Models\Main;

class MainController extends Controller {

    public function index($request, $response){

        //debug($this);
        $query = trim($request->getParam('query'));
        if(isset($query) && !empty($query)){
            $model = new Main();
            //получаем свежую 20-ку
            $searchResponse = $model->getSearchList($query);
            //получаем строку состояющую из videoId полученного запроса
            if($searchResponse !== false){
                $videoIds = $model->getVideoIds($searchResponse);
                //Получаем полную статистику
                $statistics = $model->getVideoStatistics($videoIds);
                //Получаем конкретную статистику по заданному условию
                $views = $model->getVideoStatisticByCondition($statistics, 'viewCount');
                //Получаем удобный массив для вывода в Вид
                $videos = $model->getVideosForView($searchResponse, $views);
            }else{
                $videos = 'Поиск не дал реузльтатов';
            }
        }

        return $this->container->view->render($response, 'main.tpl', compact('videos', 'query'));
    }
}