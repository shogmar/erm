<?php
/**
 * Файлы sitemap не создаются, они лежат в репозитории в готовом виде.
 * Можно попробовать запустить скрипт в ручную и увидеть(text/html) не выдаёт ли ошибок.
 * Если идут ошибки Permission denied, нужно админу поправить права файлам, для того чтоб скрипт получил доступ к записи.
 * Большинство ошибок вызываются E_WARNING. Перехватыавается и записывается в логи или просто просмотреть в html.
 * 
 * По магазинам. Просто указывается url. Туда больше ничего не записывается.
 */
header('Content-Type: text/html; charset=utf-8');
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    if (0 === error_reporting(-1)) {
        return false;
    }
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

//Название файлов
$name_sitemap_production = "sitemap1";
$name_sitemap_cat_production = "sitemap2";
$name_recipes = "sitemap3";
$name_cat_recipes = "sitemap4";
$name_video = "sitemap5";
$name_interesting = "sitemap6";
$name_shops = "sitemap7";
$name_static = "sitemap8";

////Продукция
try {
    $content = file_get_contents('https://www.ermolino-produkty.ru/?ac=list&name=products&JSON=1&JSON_DATA_ONLY=1&NUMONPAGE=1000');
    $content_decode = json_decode($content, TRUE);

    if($content_decode === NULL) {
        throw new \ErrorException("ERROR URL sitemap1");
    }
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new \ErrorException("json eror sitemap1");
    }

    $dom = new DOMDocument('1.0', 'UTF-8');
    $el_url = $dom->createElement('urlset');
    $urlset = $dom->appendChild($el_url);
    $urlset->setAttribute("xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9");

    foreach($content_decode["CONTENT"] as $v) {
        $el_url = $dom->createElement('url');
        $el_loc = $dom->createElement('loc');
        $url = $urlset->appendChild($el_url);
        $loc = $url->appendChild($el_loc);
        $text = $dom->createTextNode("https://www.ermolino-produkty.ru/".$v["SEO_TITLE"].".htm");
        $loc->appendChild($text);
    }
    //echo $dom->saveXML();
    echo "<br />".$dom->save($name_sitemap_production.".xml")." bytes ".$name_sitemap_production.".xml save successful";
} catch(\ErrorException $e){
    echo "<br />".$e->getMessage();
    error_log($e->getMessage());
}

////Категории продуктов
try {
    $content = file_get_contents('https://www.ermolino-produkty.ru/?ac=list&name=categories_menu&JSON=1&JSON_DATA_ONLY=1&MODULE=products&NUMONPAGE=1000');
    $content_decode = json_decode($content, TRUE);

    if($content_decode === NULL) {
        throw new \ErrorException("ERROR URL sitemap2");
    }
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new \ErrorException("json eror sitemap2");
    }

    $dom = new DOMDocument('1.0', 'UTF-8');
    $el_url = $dom->createElement('urlset');
    $urlset = $dom->appendChild($el_url);
    $urlset->setAttribute("xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9");

    foreach($content_decode["CONTENT"] as $v) {
        $el_url = $dom->createElement('url');
        $el_loc = $dom->createElement('loc');
        $url = $urlset->appendChild($el_url);
        $loc = $url->appendChild($el_loc);
        $text = $dom->createTextNode("https://www.ermolino-produkty.ru/".$v["SEO_TITLE"]);
        $loc->appendChild($text);
    }
    //echo $dom->saveXML();
    echo "<br />".$dom->save($name_sitemap_cat_production.".xml")." bytes ".$name_sitemap_cat_production.".xml save successful";
} catch(\ErrorException $e){
    echo "<br />".$e->getMessage();
    error_log($e->getMessage());
}

//Для списка рецептов
try {
    $content = file_get_contents('https://www.ermolino-produkty.ru/?ac=list&name=recipes&JSON=1&JSON_DATA_ONLY=1&NUMONPAGE=1000');
    $content_decode = json_decode($content, TRUE);

    if($content_decode === NULL) {
        throw new \ErrorException("ERROR URL sitemap3");
    }
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new \ErrorException("json eror sitemap3");
    }

    $dom = new DOMDocument('1.0', 'UTF-8');
    $el_url = $dom->createElement('urlset');
    $urlset = $dom->appendChild($el_url);
    $urlset->setAttribute("xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9");

    foreach($content_decode["CONTENT"] as $v) {
        $el_url = $dom->createElement('url');
        $el_loc = $dom->createElement('loc');
        $url = $urlset->appendChild($el_url);
        $loc = $url->appendChild($el_loc);
        $text = $dom->createTextNode("https://www.ermolino-produkty.ru/recipes/".$v["TAG"].".htm");
        $loc->appendChild($text);
    }
    //echo $dom->saveXML();
    echo "<br />".$dom->save($name_recipes.".xml")." bytes ".$name_recipes.".xml save successful";
} catch(\ErrorException $e){
    echo "<br />".$e->getMessage();
    error_log($e->getMessage());
}

//Для категории рецептов
try {
    $content = file_get_contents('https://www.ermolino-produkty.ru/?ac=list&name=categories_menu&JSON=1&JSON_DATA_ONLY=1&MODULE=recipes&NUMONPAGE=1000');
    $content_decode = json_decode($content, TRUE);

    if($content_decode === NULL) {
        throw new \ErrorException("ERROR URL sitemap4");
    }
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new \ErrorException("json eror sitemap4");
    }

    $dom = new DOMDocument('1.0', 'UTF-8');
    $el_url = $dom->createElement('urlset');
    $urlset = $dom->appendChild($el_url);
    $urlset->setAttribute("xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9");

    foreach($content_decode["CONTENT"] as $v) {
        $el_url = $dom->createElement('url');
        $el_loc = $dom->createElement('loc');
        $url = $urlset->appendChild($el_url);
        $loc = $url->appendChild($el_loc);
        $text = $dom->createTextNode("https://www.ermolino-produkty.ru/recipes/".$v["TAG"]);
        $loc->appendChild($text);
    }
    //echo $dom->saveXML();
    echo "<br />".$dom->save($name_cat_recipes.".xml")." bytes ".$name_cat_recipes.".xml save successful";
} catch(\ErrorException $e){
    echo "<br />".$e->getMessage();
    error_log($e->getMessage());
}

//Для видео
try {
    $content = file_get_contents('https://www.ermolino-produkty.ru/?ac=list&name=video&JSON=1&JSON_DATA_ONLY=1&NUMONPAGE=1000');
    $content_decode = json_decode($content, TRUE);

    if($content_decode === NULL) {
        throw new \ErrorException("ERROR URL sitemap5");
    }
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new \ErrorException("json eror sitemap5");
    }

    $dom = new DOMDocument('1.0', 'UTF-8');
    $el_url = $dom->createElement('urlset');
    $urlset = $dom->appendChild($el_url);
    $urlset->setAttribute("xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9");

    foreach($content_decode["CONTENT"] as $v) {
        $el_url = $dom->createElement('url');
        $el_loc = $dom->createElement('loc');
        $url = $urlset->appendChild($el_url);
        $loc = $url->appendChild($el_loc);
        $text = $dom->createTextNode("https://www.ermolino-produkty.ru/video/".$v["TAG"].".htm");
        $loc->appendChild($text);
    }
    //echo $dom->saveXML();
    echo "<br />".$dom->save($name_video.".xml")." bytes ".$name_video.".xml save successful";
} catch(\ErrorException $e){
    echo "<br />".$e->getMessage();
    error_log($e->getMessage());
}


//Для «это интересно»
try{
    $content = file_get_contents('https://www.ermolino-produkty.ru/?ac=list&name=articles&JSON=1&JSON_DATA_ONLY=1&NUMONPAGE=1000&CAT_TAG=eto-interesno&params[cat_id]=eto-interesno');
    $content_decode = json_decode($content, TRUE);

    if($content_decode === NULL) {
        throw new \ErrorException("ERROR URL sitemap6");
    }
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new \ErrorException("json eror sitemap6");
    }

    $dom = new DOMDocument('1.0', 'UTF-8');
    $el_url = $dom->createElement('urlset');
    $urlset = $dom->appendChild($el_url);
    $urlset->setAttribute("xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9");

    foreach($content_decode["CONTENT"] as $v) {
        $el_url = $dom->createElement('url');
        $el_loc = $dom->createElement('loc');
        $url = $urlset->appendChild($el_url);
        $loc = $url->appendChild($el_loc);
        $text = $dom->createTextNode("https://www.ermolino-produkty.ru/".$v["TAG"].".htm");
        $loc->appendChild($text);
    }
    //echo $dom->saveXML();
    echo "<br />".$dom->save($name_interesting.".xml")." bytes ".$name_interesting.".xml save successful";
} catch(\ErrorException $e){
    echo "<br />".$e->getMessage();
    error_log($e->getMessage());
}

//Для магазинам
/*
$content = file_get_contents('https://www.ermolino-produkty.ru/magaziny?ac=coords&cat=2');
$content_decode = json_decode($content, TRUE);

if($content_decode === NULL) {
    throw new \ErrorException("ERROR URL sitemap7");
}
if (json_last_error() !== JSON_ERROR_NONE) {
    throw new \ErrorException("json eror sitemap7");
}

$dom = new DOMDocument('1.0', 'UTF-8');
$el_url = $dom->createElement('urlset');
$urlset = $dom->appendChild($el_url);
$urlset->setAttribute("xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9");
*/
///foreach($content_decode["CONTENT"] as $key => $v) {
    //echo "<br />".var_dump($key, $v);
    /*$el_url = $dom->createElement('url');
    $el_loc = $dom->createElement('loc');
    $url = $urlset->appendChild($el_url);
    $loc = $url->appendChild($el_loc);
    $text = $dom->createTextNode("https://www.ermolino-produkty.ru/".$v["TAG"].".htm");
    $loc->appendChild($text);*/
//}

//echo "<br />".$dom->save($name_shops.".xml")." bytes ".$name_shops.".xml save successful";
//echo $dom->saveXML();

// по статическим страницам
try {
    $content = file_get_contents('https://www.ermolino-produkty.ru/?ac=list&name=all_spages&JSON=1&JSON_DATA_ONLY=1&NUMONPAGE=1000');
    $content_decode = json_decode($content, TRUE);

    if($content_decode === NULL) {
        throw new \ErrorException("ERROR URL sitemap8");
    }
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new \ErrorException("json eror sitemap8");
    }

    $dom = new DOMDocument('1.0', 'UTF-8');
    $el_url = $dom->createElement('urlset');
    $urlset = $dom->appendChild($el_url);
    $urlset->setAttribute("xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9");

    foreach($content_decode["CONTENT"] as $v) {
        $el_url = $dom->createElement('url');
        $el_loc = $dom->createElement('loc');
        $url = $urlset->appendChild($el_url);
        $loc = $url->appendChild($el_loc);
        $text = $dom->createTextNode("https://www.ermolino-produkty.ru/".$v["TAG"]);
        $loc->appendChild($text);
    }
    //echo $dom->saveXML();
    echo "<br />".$dom->save($name_static.".xml")." bytes ".$name_static.".xml save successful";
} catch(\ErrorException $e){
    echo "<br />".$e->getMessage();
    error_log($e->getMessage());
}