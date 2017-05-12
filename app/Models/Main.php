<?php

namespace App\Models;


use App\Base\Model;

class Main extends Model {

    protected $youtube;

    public function __construct()
    {
        $client = new \Google_Client();
       // $googleApiKey = $container->get('settings')['googleApiKey'];
        $client->setDeveloperKey('AIzaSyC0fPJYenLydx_K6YQ8EZLd_Cog0f8r9bE');
        $this->youtube = new \Google_Service_YouTube($client);
        //echo 'Ура, автозагрузчик заработал!!!';
    }

    /**
     * Возвращает список последних 20 видео с ютуба
     * @return \Google_Service_YouTube_SearchListResponse || false
     */
    public function getSearchList($query)
    {
        if(empty($query)){
            header("Location: /");
        }
        $searchResponse = $this->youtube->search->listSearch('id,snippet', array(
            'q' => $query,
            'maxResults' => 20,
            'relevanceLanguage' => 'ru', //последние 20 видео на русском
            'type' => 'video',
            'order' => 'date'
        ));

        return count($searchResponse['items']) ? $searchResponse : false;
    }
    /* Получает полную статистику к выбранным видео*/
    public function getVideoStatistics($videoIds){
        return $this->youtube->videos->listVideos('statistics', ['id' => $videoIds]);
    }
    /**
     * Возвращает упорядоченный массив статистики
     * @param $data
     * @return array
     */
    public function getVideoStatisticByCondition($data, $condition)
    {
        $arr = [];
        foreach ($data['items'] as $item) {
            $arr[] = $item['statistics'][$condition];
        }
        return $arr;
    }

    /**
     * @param $data
     * @return string строка ключей videoId
     */
    public function getVideoIds($data)
    {
        $arr = []; //массив для хранения videoId
        foreach ($data['items'] as $video) {
            array_push($arr, $video['id']['videoId']);
        }
        $videoIds = implode(',', $arr); //Объединяем в строку
        return $videoIds;
    }

    /**
     * Вовзращает отсортированный список видео
     * @param $data object
     * @param $arr array  массив просмотров
     * @return array отсортированный список
     */
    public function getVideosForView($data, $arr){
        $videos = [];
        $i = 0;
        foreach ($data['items'] as $item) {
            $videos[$i]['id'] = $item['id']['videoId'];
            $videos[$i]['title'] = $item['snippet']['title'];
            $videos[$i]['description'] = $item['snippet']['description'];
            $videos[$i]['author'] = $item['snippet']['channelTitle'];
            $videos[$i]['published'] = (new \DateTime($item['snippet']['publishedAt']))->format('d.m.Y в H:m:s');
            $videos[$i]['views'] = $arr[$i];
            $i++;
        }

        // Получаем поле, по которму хотим произвести соритровку
        foreach ($videos as $key => $row) {
            $view[$key]  = $row['views'];
        }
        array_multisort($view, SORT_DESC, $videos);

        return $videos;
    }
}