<!doctype html>
<html lang="RU">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Главная страница</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>

<div class="container">
    {% include 'includes/search.tpl' %}

    {% if videos|length > 0 %}

    <div class="panel-heading"><h2>Результаты поиска по запросу: "{{ query }}"</h2></div>
    <div class="panel-group col-md-7">

        {% for video in videos %}

        <div class="panel panel-default">
            <div class="panel-heading">
                {{ video.title }}
            </div>
            <article class="panel-body" id="{{ video.id }}">
                <div class="row">
                    <p class="col-sm-8"><b>Дата публикации:</b> {{ video.published }}</p>
                    <p class="col-sm-4 text-right"><b>Просмотров:</b> {{ video.views }}</p>
                </div>
                <p><b>Автор:</b> {{ video.author }}</p>
                <p><?= $item['description'] ?: 'Описание отсутствует'; ?></p>
            </article>
        </div>

        {% endfor %}

    </div>
    <div class="clearfix"></div>
    <hr/>
    {% endif %}
</div>

<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script>
    //Аккордеон, во время раскрыти создает iframe.
    //Реализовано т.о., чтобы страница с результатами поиска грузилась моментально без тормозов
    $(document).ready(function () {
        $('.panel-group article').hide();

        $('.panel-heading').click(function () {
            var findArticle = $(this).next('article');
            var findPanel = $(this).closest('.panel');
            var videoIdFromTag = findArticle.attr('id');

            if (findArticle.is(':visible')) {
                $('#player-' + videoIdFromTag).detach();
                findArticle.slideUp();
            } else {
                findPanel.find('>article').slideUp();
                findArticle.slideDown();
                findArticle.append('<iframe id="player-' + videoIdFromTag + '" type="text/html" width="100%" height="360" src="http://www.youtube.com/embed/'+ videoIdFromTag +'"frameborder="0"></iframe>');
            }
        })
    });
</script>

</body>
</html>