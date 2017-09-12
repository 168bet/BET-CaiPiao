//http://webapi.amap.com/maps?v=1.3&key=bda6a03bbd0597b10bb7d1bfa9dda7b1&plugin=AMap.Geocoder
FastClick.attach(document.body);
var BttnSo = (function(){
	var render = {
			regeocoder: function (center){  //逆地理编码
				var geocoder = new AMap.Geocoder({
					radius: 1000,
					extensions: "all"
				}); 
				geocoder.getAddress(center, function(status, result) {
					if (status === 'complete' && result.info === 'OK') {
						privincecode = result.regeocode.addressComponent.adcode;//定位
						privincecode = privincecode.replace(/\d{2}$/, '00');
						$("#currentPosion").html(result.regeocode.formattedAddress);
					}
				});
			},
			initMap: function(center){
				AMap.service(["AMap.PlaceSearch"], function() {
					var placeSearch = new AMap.PlaceSearch({ //构造地点查询类
						pageSize: 20,
						type: '彩票',
						pageIndex: 1,
						city: "上海" //城市
					});
					placeSearch.searchNearBy('', center, 10000, function(status, result) {
						var t = result["poiList"]["pois"]
						if(t.length){
							var html = "";
							for(var i=0;i<(t.length>20?20:t.length);i++){
								html+='<dl lat="'+t[i]["location"]["lat"]+'" lng="'+t[i]["location"]["lng"]+'">\
										<dt>\
											<span>'+(i+1)+'.'+t[i]["name"]+'</span>\
											<cite>'+t[i]["address"]+'</cite>\
										</dt>\
										<dd>\
											<span>'+t[i]["distance"]+'米</span>\
											<a href="#">去这里</a>\
										</dd>\
									  </dl>'
							}
							$('.slice').remove()
							$("#searchRound").html(html);
							$("#mapCont dl").click(function(){
								map = new AMap.Map('container', {
									resizeEnable: true,
									zoom:13,
									center: center
								});
								var Arr = [$(this).attr("lng"), $(this).attr("lat")];
								AMap.service(["AMap.Walking"], function() {
									var walking;
									walking = new AMap.Walking({
										map: map,
										panel: ""//结果列表将在此容器中进行展示。
									});
									walking.search(center, Arr);
								});
								$("#container").show()
								$(".back").show()
//								$("#container").removeClass('container-hidden');
//								$(".back").removeClass('back-hidden');
							})
						}else{
							alert("附近没有找到投注站");
						}
					});
				});
				//逆向地理编码
				render.regeocoder(center);
			}
	}
	var o = {
			ipGPS: function(){
				var local_lng_lat = localStorage.getItem('lng_lat')
				if(true){// !local_lng_lat
					$.ajax({
						url : "http://webapi.amap.com/maps/ipLocation?v=1.3&key=bda6a03bbd0597b10bb7d1bfa9dda7b1",
						dataType : "jsonp",
						success : function(data){
							console.info(data);
							$("#ts").show();
							var lng_lat = [data.center[0], data.center[1]]
							render.initMap(lng_lat);
						}
					});
				}else{
					var lng_lat = local_lng_lat.split(',')
					render.initMap(lng_lat);
				}
			},
			GPS: function(){
			    var map, geolocation;
			    //加载地图，调用浏览器定位服务
			    map = new AMap.Map('container', {
			        resizeEnable: true
			    });
			    map.plugin('AMap.Geolocation', function() {
			        geolocation = new AMap.Geolocation({
			        	useNative:true, 
			            enableHighAccuracy: true,
			            timeout: 10000,
			            buttonOffset: new AMap.Pixel(10, 20),
			            zoomToAccuracy: true
			        });
			        map.addControl(geolocation);
			        geolocation.getCurrentPosition();
			        if(!geolocation.isSupported()){
			        	 alert('定位失败')
			        	 return;
			        }
			        AMap.event.addListener(geolocation, 'complete', onComplete);//返回定位信息
			        AMap.event.addListener(geolocation, 'error', onError);      //返回定位出错信息
			    });
			    function onComplete(r) {
			    	if(!r.accuracy){
			    		$('#ts').show()
			    	}else{
			    		$('#ts').hide()
			    	}
					render.initMap([r.position.getLng(), r.position.getLat()]);
			    }
			    function onError(data) {
			        alert('定位失败')
			    }
			},
			bind: function(){
				$(".back").click(function(){
					$("#container").hide()
					$(".back").hide()
//					$("#container").addClass('container-hidden');
//					$(".back").addClass('back-hidden');
				})
			},
			init:  function(){
				o.ipGPS();//ip定位
				o.GPS();//浏览器定位
				o.bind()
			}
	}
	return o
})()
BttnSo.init();

