<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }}</title>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="{{ asset('js/jquery.japan-map.js') }}"></script>
<script src="{{ asset('js/app.js') }}" defer></script>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/japanmap.css') }}">

<script>
jQuery.noConflict();
(function($) {
		var $mapContainer = $(document).find("#japan-map-container");
        // var canvasWidth = _getUrlParams()['canvasWidth'] && $.isNumeric(_getUrlParams()['canvasWidth']) ? _getUrlParams()['canvasWidth'] : 800;
       
		// 全国Mapの描画サイズを取得
		mapWidth = $mapContainer.find("canvas").attr("width");
		mapHeight = $mapContainer.find("canvas").attr("height");
		// mapMaxWidth = $(document).find("#japan-map-container").attr("width");
		// mapMaxHeight = $mapContainer.find("#japan-map-container").attr("height");
		console.log(mapHeight,mapWidth);
		
		// Mapの親要素のサイズを設定
		$mapContainer.css({"width": mapWidth, "max-width": mapWidth, "height": mapHeight, "max-height": mapHeight});
		// $mapContainer.css({"width": mapMaxWidth, "max-width": maMaxpWidth, "height": mapHeight, "max-height": mapHeight});
		// $mapContainer.css({"max-width": mapWidth,"max-height": mapHeight});

		var canvasWidth = mapWidth;
        // var mapWidth = null;
        // var mapHeight = null;

        // 都道府県選択画面の選択不可な都道府県の色
        var backgroundPrefColor = "#ababab";


        /*
            * 2段階選択式の日本地図を表示する
            */
        initJapanMap();
        function initJapanMap() {
            // var areas= [
            //         {code : 1, name: "北海道", color: "#7f7eda", hoverColor: "#b3b2ee", prefectures: [1]},
            //         {code : 2, name: "東北地方",   color: "#759ef4", hoverColor: "#98b9ff", prefectures: [2,3,4,5,6,7]},
            //         {code : 3, name: "関東地方",   color: "#7ecfea", hoverColor: "#b7e5f4", prefectures: [8,9,10,11,12,13,14]},
            //         {code : 4, name: "中部地方",   color: "#7cdc92", hoverColor: "#aceebb", prefectures: [15,16,17,18,19,20,21,22,23]},
            //         {code : 5, name: "関西地方",   color: "#ffe966", hoverColor: "#fff19c", prefectures: [24,25,26,27,28,29,30]},
            //         {code : 6, name: "中国地方",   color: "#ffcc66", hoverColor: "#ffe0a3", prefectures: [31,32,33,34,35]},
            //         {code : 7, name: "四国地方",   color: "#fb9466", hoverColor: "#ffbb9c", prefectures: [36,37,38,39]},
            //         {code : 8, name: "九州地方",   color: "#ff9999", hoverColor: "#ffbdbd", prefectures: [40,41,42,43,44,45,46]},
            //         {code : 9, name: "沖縄",   color: "#eb98ff", hoverColor: "#f5c9ff", prefectures: [47]},
            //     ]
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
                borderLineWidth: 0,
                width: canvasWidth,
                showsAreaName: true,
                // showsPrefectureName: true,
                font : "gothic",
                fontSize : 12,
                fontColor : "#fff",
                fontShadowColor : "black",
                onSelect:function(data){
                    // alert(JSON.stringify(data.area["name"]));
                    switch (data.code){
                    
                        // 北海道
                        case 1:
                            $mapContainer.empty().japanMap({
                                // areas: [
                                //     {code : 1, name: "北海道", color: "#7f7eda", hoverColor: "#b3b2ee", prefectures: [1]},
                                //     // 近隣の都道府県を表示
                                //     {name: "", color: backgroundPrefColor, hoverColor: backgroundPrefColor, prefectures: [2,3,5]},
                                // ],

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
                                showsAreaName: true,
                                // showsPrefectureName: true,
                                font : "gothic",
                                fontSize : 12,
                                fontColor : "#fff",
                                fontShadowColor : "black",
                                width: canvasWidth * 2.5,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
          
                            // 北海道の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": mapHeight * 0.15, "left": 0 - (mapWidth * 1.55)});
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
                                showsPrefectureName: true,
                                // showsAreaName: true,
                                font : "gothic",
                                fontSize : 11,
                                fontColor : "#fff",
                                fontShadowColor : "black",
                                width: canvasWidth * 2.8,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
                            
                            // 東北の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": 0 - mapHeight * 0.50, "left": 0 - (mapWidth * 1.65)});
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
                                showsPrefectureName: true,
                                // showsAreaName: true,
                                font : "gothic",
                                fontSize : 11,
                                fontColor : "#fff",
                                fontShadowColor : "black",
                                width: canvasWidth * 4.5,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
                            
                            // 関東の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": 0 - mapHeight * 2, "left": 0 - (mapWidth * 2.82)});
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
                                    showsPrefectureName: true,
                                // showsAreaName: true,
                                font : "gothic",
                                fontSize : 11,
                                fontColor : "#fff",
                                fontShadowColor : "black",
                                width: canvasWidth * 3.5,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
                            
                            // 中部の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": 0 - mapHeight * 1.4, "left": 0 - (mapWidth * 1.85)});
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
                                showsPrefectureName: true,
                                // showsAreaName: true,
                                font : "gothic",
                                fontSize : 11,
                                fontColor : "#fff",
                                fontShadowColor : "black",
                                width: canvasWidth * 4.5,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
                            
                            // 関西の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": 0 - mapHeight * 2.4, "left": 0 - (mapWidth * 2.1)});
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
                                showsPrefectureName: true,
                                // showsAreaName: true,
                                font : "gothic",
                                fontSize : 11,
                                fontColor : "#fff",
                                fontShadowColor : "black",
                                width: canvasWidth * 4,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
                            
                            // 中部の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": 0 - mapHeight * 1.92, "left": 0 - (mapWidth * 1.4)});
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
                                showsPrefectureName: true,
                                // showsAreaName: true,
                                font : "gothic",
                                fontSize : 11,
                                fontColor : "#fff",
                                fontShadowColor : "black",
                                width: canvasWidth * 4.5,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
                            
                            // 四国の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": 0 - mapHeight * 2.58, "left": 0 - (mapWidth * 1.75)});
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
                                showsPrefectureName: true,
                                // showsAreaName: true,
                                font : "gothic",
                                fontSize : 11,
                                fontColor : "#fff",
                                fontShadowColor : "black",
                                width: canvasWidth * 4,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
                            
                            // 九州の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": 0 - mapHeight * 2.5, "left": 0 - (mapWidth * 1.1)});
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
                                showsPrefectureName: true,
                                // showsAreaName: true,
                                font : "gothic",
                                fontSize : 11,
                                fontColor : "#fff",
                                fontShadowColor : "black",
                                width: canvasWidth * 4,
                                onSelect:function(data){
                                    _sendData(data);
                                }
                            });
                            
                            // 沖縄の地図の表示位置を整える
                            $mapContainer.find("canvas").css({"top": 0 - mapHeight * 3.85, "left": 0 - (mapWidth * 0.4)});
                            $("#japan-map-back-btn").show();
                            break;
                    }
                },
            });
            
            // 初回のみ実施

        }
        
        /*
            * 都道府県選択時のデータ送信処理
            */
        function _sendData(data) {
            if (data.code) {
                window.parent.location.href = "/pref/" + data.code + "/";
            }
        }
        
        /*
            * getパラメータを取得
            */
        function _getUrlParams() {
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for (var i = 0; i < hashes.length; i++) {
                hash = hashes[i].split('=');
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

})(jQuery)
</script>
</head>
<!-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> -->
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/map') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
            <input type="button" value="&lt;&lt;戻る" id="japan-map-back-btn"/>
            <div id="japan-map-container"></div>
        </main>
    </div>
</body>
</html>

