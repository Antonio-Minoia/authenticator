"use strict";function ownKeys(object,enumerableOnly){var keys=Object.keys(object);if(Object.getOwnPropertySymbols){var symbols=Object.getOwnPropertySymbols(object);if(enumerableOnly)symbols=symbols.filter(function(sym){return Object.getOwnPropertyDescriptor(object,sym).enumerable});keys.push.apply(keys,symbols)}return keys}function _objectSpread(target){for(var i=1;i<arguments.length;i++){var source=arguments[i]!=null?arguments[i]:{};if(i%2){ownKeys(Object(source),true).forEach(function(key){_defineProperty(target,key,source[key])})}else if(Object.getOwnPropertyDescriptors){Object.defineProperties(target,Object.getOwnPropertyDescriptors(source))}else{ownKeys(Object(source)).forEach(function(key){Object.defineProperty(target,key,Object.getOwnPropertyDescriptor(source,key))})}}return target}function _defineProperty(obj,key,value){if(key in obj){Object.defineProperty(obj,key,{value:value,enumerable:true,configurable:true,writable:true})}else{obj[key]=value}return obj}$(function(){$("#widget-carousel").slick({rtl:$("html").attr("dir")==="rtl",asNavFor:"#widget-carousel-nav",slidesToShow:1,slidesToScroll:1,arrows:false});$("#widget-carousel-nav").slick({rtl:$("html").attr("dir")==="rtl",asNavFor:"#widget-carousel",slidesToShow:1,slidesToScroll:1,arrows:false,centerMode:true});var currency=new Intl.NumberFormat("en-US",{style:"currency",currency:"USD",minimumFractionDigits:0});var colors={blue:"#2196f3",green:"#4caf50",red:"#f44336",white:"#fff",black:"#424242"};var themeOptions={light:{theme:{mode:"light",palette:"palette1"}},dark:{theme:{mode:"dark",palette:"palette1"}}};var widgetChart3=$(".widget-chart-3").map(function(){var color=$(this).data("chart-color");var label=$(this).data("chart-label");var series=$(this).data("chart-series").split(",").map(function(data){return Number(data)});return new ApexCharts(this,_objectSpread(_objectSpread({},themeOptions.light),{},{series:[{name:label,data:series}],chart:{type:"area",height:50,sparkline:{enabled:true}},fill:{opacity:0},stroke:{show:true,colors:[color],lineCap:"round"},markers:{colors:colors.white,strokeWidth:4,strokeColors:color},tooltip:{followCursor:true,marker:{show:false},x:{show:false},y:{formatter:function formatter(val){return"".concat(val," Tests")}},fixed:{enabled:true,position:"topLeft",offsetY:-30}},xaxis:{categories:["Jan","Feb","Mar","Apr","May","Jun"],crosshairs:{show:false}}}))});var widgetChart5=new ApexCharts(document.querySelector("#widget-chart-5"),_objectSpread(_objectSpread({},themeOptions.light),{},{series:[{name:"Sales",data:[640,400,760,620,980,640]}],chart:{type:"area",height:300,toolbar:{show:false}},dataLabels:{enabled:false},fill:{opacity:0},stroke:{show:true,colors:[colors.blue],lineCap:"round"},markers:{colors:colors.white,strokeWidth:4,strokeColors:colors.blue},tooltip:{marker:{show:false},y:{formatter:function formatter(val){return"".concat(val," Products")}}},xaxis:{categories:["Jan","Feb","Mar","Apr","May","Jun"]}}));widgetChart3.each(function(){this.render()});widgetChart5.render();$("#theme-toggle").on("click",function(){var isDark=$("body").hasClass("theme-dark");if(isDark){widgetChart3.each(function(){this.updateOptions({markers:{colors:colors.black}})});widgetChart5.updateOptions(_objectSpread(_objectSpread({},themeOptions.dark),{},{markers:{colors:colors.black}}))}else{widgetChart3.each(function(){this.updateOptions(_objectSpread(_objectSpread({},themeOptions.light),{},{markers:{colors:colors.white}}))});widgetChart5.updateOptions(_objectSpread(_objectSpread({},themeOptions.light),{},{markers:{colors:colors.white}}))}})});