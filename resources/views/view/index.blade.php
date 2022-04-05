@include('layouts.bbsheader')
@include('layouts.bbsfooter')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>消防団.com</title>
    <meta name="description" itemprop="description" content="@yield('description')">
    <meta name="keywords" itemprop="keywords" content="@yield('keywords')">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="styleSheet">
    @yield('pageCss')
    
    <script src="{{ asset('js/all.js') }}"></script>
    @yield('pageScript')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

</head>

<script>
    jQuery.noConflict();
(function($) {
    $(function(){
        
        var $mapContainer = $(document).find("#japan-map-container");
        var $mapCanvas = $(document).find("canvas");
        // var canvasWidth = _getUrlParams()['canvasWidth'] && $.isNumeric(_getUrlParams()['canvasWidth']) ? _getUrlParams()['canvasWidth'] : 800;
        var canvasWidth = document.documentElement.offsetWidth;

        var mapWidth = document.documentElement.offsetWidth;
        var mapHeight = null;

        // 都道府県選択画面の選択不可な都道府県の色
        var backgroundPrefColor = "#ababab";


        /*
            * 2段階選択式の日本地図を表示する
            */
        initJapanMap();
        function initJapanMap() {
            $("#japan-map-back-btn").hide();
            console.log(mapHeight);
            $mapContainer.empty().japanMap({
                areas: [
                    {code : 1, name: "北海道", color: "#7f7eda", hoverColor: "#b3b2ee", prefectures: [1]},
                    {code : 2, name: "東北地方",   color: "#759ef4", hoverColor: "#98b9ff", prefectures: [2,3,4,5,6,7]},
                    {code : 3, name: "関東地方",   color: "#7ecfea", hoverColor: "#b7e5f4", prefectures: [8,9,10,11,12,13,14]},
                    {code : 4, name: "中部地方",   color: "#7cdc92", hoverColor: "#aceebb", prefectures: [15,16,17,18,19,20,21,22,23]},
                    {code : 5, name: "近畿地方",   color: "#ffe966", hoverColor: "#fff19c", prefectures: [24,25,26,27,28,29,30]},
                    {code : 6, name: "中国地方",   color: "#ffcc66", hoverColor: "#ffe0a3", prefectures: [31,32,33,34,35]},
                    {code : 7, name: "四国地方",   color: "#fb9466", hoverColor: "#ffbb9c", prefectures: [36,37,38,39]},
                    {code : 8, name: "九州地方",   color: "#ff9999", hoverColor: "#ffbdbd", prefectures: [40,41,42,43,44,45,46]},
                    {code : 9, name: "沖縄",   color: "#eb98ff", hoverColor: "#f5c9ff", prefectures: [47]},
                ],
                selection : "area",
                movesIslands : true,
                drawsBoxLine : false,
                backgroundColor : "#ccffcc",
                width: canvasWidth,
                showsAreaName: true,
                font : "MS UI Gothic",
                fontSize : 12,
                fontColor : "white",
                fontShadowColor : "black",
                areaNameType: "short",
                onSelect:function(data){
                    switch (data.code){
                    
                        // 北海道
                        case 1:
                            $mapContainer.empty().japanMap({
                                areas: [
                                    {code : 1, name: "北海道", color: "#7f7eda", hoverColor: "#b3b2ee", prefectures: [1]},
                                    {name: "",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [2,3,4,5,6,7]},
                                    {code : 3, name: "関東地方",   color: "#7ecfea", hoverColor: "#b7e5f4", prefectures: [8,9,10,11,12,13,14]},
                                    {code : 4, name: "中部地方",   color: "#7cdc92", hoverColor: "#aceebb", prefectures: [15,16,17,18,19,20,21,22,23]},
                                    {code : 5, name: "近畿地方",   color: "#ffe966", hoverColor: "#fff19c", prefectures: [24,25,26,27,28,29,30]},
                                    {code : 6, name: "中国地方",   color: "#ffcc66", hoverColor: "#ffe0a3", prefectures: [31,32,33,34,35]},
                                    {code : 7, name: "四国地方",   color: "#fb9466", hoverColor: "#ffbb9c", prefectures: [36,37,38,39]},
                                    {code : 8, name: "九州地方",   color: "#ff9999", hoverColor: "#ffbdbd", prefectures: [40,41,42,43,44,45,46]},
                                    {code : 9, name: "沖縄",   color: "#eb98ff", hoverColor: "#f5c9ff", prefectures: [47]},
                                ],
                                
                                backgroundColor : "#ccffcc",
                                showsPrefectureName: true,
                                font : "gothic",
                                fontSize : 12,
                                fontColor : "white",
                                fontShadowColor : "black",
                                width: canvasWidth * 3.5,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
          
                            // 北海道の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": mapHeight * 0, "left": 0 - (mapWidth * 2.45)});
                            $("#japan-map-back-btn").show();
                            break;
                            
                        // 東北
                        case 2:
                            $mapContainer.empty().japanMap({
                                areas: [
                                    // {code : 1, name: "北海道", color: "#7f7eda", hoverColor: "#b3b2ee", prefectures: [1]},
                                    {code : 2, name: "東北地方",   color: "#759ef4", hoverColor: "#98b9ff", prefectures: [2,3,4,5,6,7]},
                                    {code : 3, name: "関東地方",   color: "#7ecfea", hoverColor: "#b7e5f4", prefectures: [12,13,14]},
                                    {code : 4, name: "中部地方",   color: "#7cdc92", hoverColor: "#aceebb", prefectures: [19,22,23]},
                                    {code : 5, name: "近畿地方",   color: "#ffe966", hoverColor: "#fff19c", prefectures: [24,25,26,27,28,29,30]},
                                    {code : 6, name: "中国地方",   color: "#ffcc66", hoverColor: "#ffe0a3", prefectures: [31,32,33,34,35]},
                                    {code : 7, name: "四国地方",   color: "#fb9466", hoverColor: "#ffbb9c", prefectures: [36,37,38,39]},
                                    {code : 8, name: "九州地方",   color: "#ff9999", hoverColor: "#ffbdbd", prefectures: [40,41,42,43,44,45,46]},
                                    {code : 9, name: "沖縄",   color: "#eb98ff", hoverColor: "#f5c9ff", prefectures: [47]},
                                    // 近隣の都道府県を表示
                                    {name: "", color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [1,8,9,10,11,15,16,17,18,20,21]},

                                ],
                                backgroundColor : "#ccffcc",
                                showsPrefectureName: true,
                                
                                font : "gothic",
                                fontSize : 12,
                                fontColor : "white",
                                fontShadowColor : "black",
                                width: canvasWidth * 3.6,
                                prefectureNameType: "short",
                                borderLineWidth : 1,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
                            
                            // 東北の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": 0 - mapHeight * 0.9, "left": 0 - (mapWidth * 2.2)});
                            $("#japan-map-back-btn").show();
                            break;
                            
                        // 関東
                        case 3:
                            $mapContainer.empty().japanMap({
                                areas: [
                                    {code : 1, name: "北海道", color: "#7f7eda", hoverColor: "#b3b2ee", prefectures: [1]},
                                    {code : 2, name: "東北地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [2,3,4,5,6,7]},
                                    {code : 3, name: "関東地方",   color: "#7ecfea", hoverColor: "#b7e5f4", prefectures: [8,9,10,11,12,13,14]},
                                    {code : 4, name: "中部地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [15,16,17,18,19,20,21,22,23]},
                                    {code : 5, name: "近畿地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [24,25,26,27,28,29,30]},
                                    {code : 6, name: "中国地方",   color: "#ffcc66", hoverColor: "#ffe0a3", prefectures: [31,32,33,34,35]},
                                    {code : 7, name: "四国地方",   color: "#fb9466", hoverColor: "#ffbb9c", prefectures: [36,37,38,39]},
                                    {code : 8, name: "九州地方",   color: "#ff9999", hoverColor: "#ffbdbd", prefectures: [40,41,42,43,44,45,46]},
                                    {code : 9, name: "沖縄",   color: "#eb98ff", hoverColor: "#f5c9ff", prefectures: [47]},
                                ],
                                backgroundColor : "#ccffcc",
                                showsPrefectureName: true,
                                
                                font : "gothic",
                                fontSize : 12,
                                fontColor : "white",
                                fontShadowColor : "black",
                                width: canvasWidth * 8,
                                prefectureNameType: "short",
                                borderLineWidth : 1,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
                            
                            // 関東の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": 0 - mapHeight * 4, "left": 0 - (mapWidth * 5.4)});
                            $("#japan-map-back-btn").show();
                            break;
                            
                        // 中部
                        case 4:
                            $mapContainer.empty().japanMap({
                                areas: [
                                    {code : 1, name: "北海道", color: "#7f7eda", hoverColor: "#b3b2ee", prefectures: [1]},
                                    {code : 2, name: "東北地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [2,3,4,5,6,7]},
                                    {code : 3, name: "関東地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [8,9,10,11,12,13,14]},
                                    {code : 4, name: "中部地方",   color: "#7cdc92", hoverColor: "#aceebb", prefectures: [15,16,17,18,19,20,21,22,23]},
                                    {code : 5, name: "近畿地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [24,25,26,27,28,29,30]},
                                    {code : 6, name: "中国地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [31,32,33,34,35]},
                                    {code : 7, name: "四国地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [36,37,38,39]},
                                    {code : 8, name: "九州地方",   color: "#ff9999", hoverColor: "#ffbdbd", prefectures: [40,41,42,43,44,45,46]},
                                    {code : 9, name: "沖縄",   color: "#eb98ff", hoverColor: "#f5c9ff", prefectures: [47]},
                                ],
                                backgroundColor : "#ccffcc",
                                showsPrefectureName: true,
                                font : "gothic",
                                fontSize : 12,
                                fontColor : "white",
                                fontShadowColor : "black",
                                width: canvasWidth * 5.4,
                                prefectureNameType: "short",
                                borderLineWidth : 1,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
                            
                            // 中部の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": 0 - mapHeight * 2.5, "left": 0 - (mapWidth * 3.1)});
                            $("#japan-map-back-btn").show();
                            break;
                            
                        // 関西
                        case 5:
                            $mapContainer.empty().japanMap({
                                areas: [
                                    {code : 1, name: "北海道", color: "#7f7eda", hoverColor: "#b3b2ee", prefectures: [1]},
                                    {code : 2, name: "東北地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [2,3,4,5,6,7]},
                                    {code : 3, name: "関東地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [8,9,10,11,12,13,14]},
                                    {code : 4, name: "中部地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [15,16,17,18,19,20,21,22,23]},
                                    {code : 5, name: "近畿地方",   color: "#ffe966", hoverColor: "#fff19c", prefectures: [24,25,26,27,28,29,30]},
                                    {code : 6, name: "中国地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [31,32,33,34,35]},
                                    {code : 7, name: "四国地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [36,37,38,39]},
                                    {code : 8, name: "九州地方",   color: "#ff9999", hoverColor: "#ffbdbd", prefectures: [40,41,42,43,44,45,46]},
                                    {code : 9, name: "沖縄",   color: "#eb98ff", hoverColor: "#f5c9ff", prefectures: [47]},
                                ],
                                backgroundColor : "#ccffcc",
                                showsPrefectureName: true,
                                
                                font : "gothic",
                                fontSize : 12,
                                fontColor : "white",
                                fontShadowColor : "black",
                                width: canvasWidth * 7.4,
                                prefectureNameType: "short",
                                borderLineWidth : 1,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
                            
                            // 関西の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": 0 - mapHeight * 4.26, "left": 0 - (mapWidth * 3.8)});
                            $("#japan-map-back-btn").show();
                            break;
                            
                        // 中国
                        case 6:
                            $mapContainer.empty().japanMap({
                                areas: [
                                    {code : 1, name: "北海道", color: "#7f7eda", hoverColor: "#b3b2ee", prefectures: [1]},
                                    {code : 2, name: "東北地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [2,3,4,5,6,7]},
                                    {code : 3, name: "関東地方",   color: "#7ecfea", hoverColor: "#b7e5f4", prefectures: [8,9,10,11,12,13,14]},
                                    {code : 4, name: "中部地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [15,16,17,18,19,20,21,22,23]},
                                    {code : 5, name: "近畿地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [24,25,26,27,28,29,30]},
                                    {code : 6, name: "中国地方",   color: "#ffcc66", hoverColor: "#ffe0a3", prefectures: [31,32,33,34,35]},
                                    {code : 7, name: "四国地方",  color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [36,37,38,39]},
                                    {code : 8, name: "九州地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [40,41,42,43,44,45,46]},
                                    {code : 9, name: "沖縄",   color: "#eb98ff", hoverColor: "#f5c9ff", prefectures: [47]},
                                ],
                                backgroundColor : "#ccffcc",
                                showsPrefectureName: true,
                                font : "gothic",
                                fontSize : 12,
                                fontColor : "white",
                                fontShadowColor : "black",
                                width: canvasWidth * 6.3,
                                prefectureNameType: "short",
                                borderLineWidth : 1,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
                            
                            // 中部の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": 0 - mapHeight * 3.3, "left": 0 - (mapWidth * 2.5)});
                            $("#japan-map-back-btn").show();
                            break;
                            
                        // 四国
                        case 7:
                            $mapContainer.empty().japanMap({
                                areas: [
                                    {code : 1, name: "北海道", color: "#7f7eda", hoverColor: "#b3b2ee", prefectures: [1]},
                                    {code : 2, name: "東北地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [2,3,4,5,6,7]},
                                    {code : 3, name: "関東地方",   color: "#7ecfea", hoverColor: "#b7e5f4", prefectures: [8,9,10,11,12,13,14]},
                                    {code : 4, name: "中部地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [15,16,17,18,19,20,21,22,23]},
                                    {code : 5, name: "近畿地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [24,25,26,27,28,29,30]},
                                    {code : 6, name: "中国地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [31,32,33,34,35]},
                                    {code : 7, name: "四国地方",   color: "#fb9466", hoverColor: "#ffbb9c", prefectures: [36,37,38,39]},
                                    {code : 8, name: "九州地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [40,41,42,43,44,45,46]},
                                    {code : 9, name: "沖縄",   color: "#eb98ff", hoverColor: "#f5c9ff", prefectures: [47]},
                                ],
                                backgroundColor : "#ccffcc",
                                showsPrefectureName: true,
                                font : "gothic",
                                fontSize : 12,
                                fontColor : "white",
                                fontShadowColor : "black",
                                width: canvasWidth * 9,
                                prefectureNameType: "short",
                                borderLineWidth : 1,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
                            
                            // 四国の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": 0 - mapHeight * 5.7, "left": 0 - (mapWidth * 4)});
                            $("#japan-map-back-btn").show();
                            break;
                            
                        // 九州
                        case 8:
                            $mapContainer.empty().japanMap({
                                areas: [
                                    {code : 1, name: "北海道", color: "#7f7eda", hoverColor: "#b3b2ee", prefectures: [1]},
                                    {code : 2, name: "東北地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [2,3,4,5,6,7]},
                                    {code : 3, name: "関東地方",   color: "#7ecfea", hoverColor: "#b7e5f4", prefectures: [8,9,10,11,12,13,14]},
                                    {code : 4, name: "中部地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [15,16,17,18,19,20,21,22,23]},
                                    {code : 5, name: "近畿地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [24,25,26,27,28,29,30]},
                                    {code : 6, name: "中国地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [31,32,33,34,35]},
                                    {code : 7, name: "四国地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [36,37,38,39]},
                                    {code : 8, name: "九州地方",   color: "#ff9999", hoverColor: "#ffbdbd", prefectures: [40,41,42,43,44,45,46]},
                                    {code : 9, name: "沖縄",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [47]},
                                ],
                                backgroundColor : "#ccffcc",
                                showsPrefectureName: true,
                                font : "gothic",
                                fontSize : 12,
                                fontColor : "white",
                                fontShadowColor : "black",
                                width: canvasWidth * 6.2,
                                prefectureNameType: "short",
                                borderLineWidth : 1,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
                            
                            // 九州の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": 0 - mapHeight * 4.08, "left": 0 - (mapWidth * 1.9)});
                            $("#japan-map-back-btn").show();
                            break;
                            
                        // 沖縄
                        case 9:
                            $mapContainer.empty().japanMap({
                                areas: [
                                    {code : 1, name: "北海道", color: "#7f7eda", hoverColor: "#b3b2ee", prefectures: [1]},
                                    {code : 2, name: "東北地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [2,3,4,5,6,7]},
                                    {code : 3, name: "関東地方",   color: "#7ecfea", hoverColor: "#b7e5f4", prefectures: [8,9,10,11,12,13,14]},
                                    {code : 4, name: "中部地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [15,16,17,18,19,20,21,22,23]},
                                    {code : 5, name: "近畿地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [24,25,26,27,28,29,30]},
                                    {code : 6, name: "中国地方",   color: "#ffcc66", hoverColor: "#ffe0a3", prefectures: [31,32,33,34,35]},
                                    {code : 7, name: "四国地方",   color: "#fb9466", hoverColor: "#ffbb9c", prefectures: [36,37,38,39]},
                                    {code : 8, name: "九州地方",   color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [40,41,42,43,44,45,46]},
                                    {code : 9, name: "沖縄",   color: "#eb98ff", hoverColor: "#f5c9ff", prefectures: [47]},
                                ],
                                backgroundColor : "#ccffcc",
                                showsPrefectureName: true,
                                font : "gothic",
                                fontSize : 12,
                                fontColor : "white",
                                fontShadowColor : "black",
                                width: canvasWidth * 10.5,
                                prefectureNameType: "short",
                                borderLineWidth : 1,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
                            
                            // 沖縄の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": 0 - mapHeight * 10.9, "left": 0 - (mapWidth * 1.9)});
                            $("#japan-map-back-btn").show();
                            break;
                    }
                },
            });
            
            // 初回のみ実施
            if (mapHeight == null) {              
                // 全国Mapの描画サイズを取得
                mapHeight = $mapContainer.find("canvas").attr("height");
                mapMaxHeight = $mapContainer.find("canvas").attr("height");
                // Mapの親要素のサイズを設定
                $mapContainer.css({"height": mapHeight, "max-height": mapHeight});
            }
        }
        
        /*
            * 都道府県選択時のデータ送信処理
            */
        function _sendData(data) {

            if (data.code) {
                window.parent.location.href = "pref_id?pref_id=%20" + data.code + "/";
            }
}

/*
* getパラメータを取得
*/
function _getUrlParams() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) { hash=hashes[i].split('=');
                    vars.push(hash[0]);
                    vars[hash[0]] = hash[1];
                }
                return vars;
        }
        
        /*
            * 戻るボタンクリック時の全国マップ表示処理
            */
        $("#japan-map-back-btn").on("click", function(){
            initJapanMap();
        });
    });
})(jQuery)
</script>
</head>

<body>
    @yield('header') 
    <div class="fv position-relative">
        <img src="{{asset('storage/img/1876390_m.jpg')}}">

        <p class="fv-text">消防団.comは消防団のクチコミが集まる、<br>移住者のためのサイトです</p>
        <div class="Individual-wrapper-text text-nowrap">
            <p>人気のエリアからクチコミを探す</p>
        </div>
        <div class="Individual-wrapper">
            <div class="IndividualArea">
                <div class="IndividualBox">
                    <ul class="IndivisualList">
                        <li class="IndivisualItem">
                            <a href="{{route('pref_id.index',['pref_id'=>"20"])}}"><span>長野</span>NAGANO</a>
                        </li>
                        <li class="IndivisualItem">
                            <a href="{{route('pref_id.index',['pref_id'=>"22"])}}"><span>静岡</span>SHIZUOKA</a>
                        </li>
                        <li class="IndivisualItem">
                            <a href="{{route('pref_id.index',['pref_id'=>"19"])}}"><span>山梨</span>YAMANASHI</a>
                        </li>
                        <li class="IndivisualItem">
                            <a href="{{route('pref_id.index',['pref_id'=>"1"])}}"><span>北海道</span>HOKKAIDO</a>
                        </li>
                        <li class="IndivisualItem">
                            <a href="{{route('pref_id.index',['pref_id'=>"12"])}}"><span>千葉</span>CHIBA</a>
                        </li>
                        <li class="IndivisualItem">
                            <a href="{{route('pref_id.index',['pref_id'=>"47"])}}"><span>沖縄</span>OKINAWA</a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <div class="map-select-section-wrapper">
        <div class="map-select-section">
            <div class="map-select-section-text text-nowrap">
                <p>マップからクチコミを探す</p>
            </div>
            <div class="map-section-container container-fluid">
                <div id="japan-map-back-btn-wrapper"><input type="button" value="&lt;&lt;戻る" id="japan-map-back-btn"
                        class="btn btn-primary" /></div>
                <div id="japan-map-container"></div>
            </div>
        </div>
    </div>
    @yield('footer')
</body>

</html>