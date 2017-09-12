<%@ page language="java" import="java.util.*,com.mh.commons.constants.*"
  contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@ page import="com.mh.commons.utils.ServletUtils"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="mh" uri="http://www.mh.com/framework/tags" %>
 
 <link rel="stylesheet" href="${resourceRoot }/app/css/reset.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/vendor.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/main.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/userCenter.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/game.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/response.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/default.css" />
  
  <link rel="stylesheet" href="${resourceRoot }/vendor/skins/default/laydate.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/helps.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/draw.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/drawDetail.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/register.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/login.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/charts.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/siderbar.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/lotteryCenter.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/jnd28.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/betDialog.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/bjpk10.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/fc3d.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/klsf.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/lhc.css" />
  <link rel="stylesheet" href="${resourceRoot }/app/css/ssc.css" />

  <!--[if IE]>
  <link rel="stylesheet" href="${resourceRoot }/app/css/ie.css" />
  <![endif]-->
  <script type="text/javascript" src="${resourceRoot }/vendor/angular.js"></script>
  <script type="text/javascript" src="${resourceRoot }/vendor/angular-ui-router.js"></script>
  <script type="text/javascript" src="${resourceRoot }/vendor/swiper.js"></script>
  <script type="text/javascript" src="${resourceRoot }/vendor/chart.js"></script>

   
  <script type="text/javascript" src="${resourceRoot }/vendor/store.min.js"></script>
  <script type="text/javascript" src="${resourceRoot }/vendor/rzslider.js"></script>

  <script type="text/javascript" src="${resourceRoot }/vendor/angular-animate.js"></script>
  <script type="text/javascript" src="${resourceRoot }/vendor/angular-dialog.js"></script>
  <script type="text/javascript" src="${resourceRoot }/vendor/angular-loading-bar.js"></script>
  <script type="text/javascript" src="${resourceRoot }/vendor/laydate.js"></script>
  <script type="text/javascript" src="${resourceRoot }/vendor/angular-chart.js"></script>

  <script type="text/javascript" src="${resourceRoot }/app/app.module.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/services/UI.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/services/UserCenter.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/services/CPMisc.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/services/drawService.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/services/gameService.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/services/AnnoucementService.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/services/Global.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/services/LocalStorage.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/filters/Misc.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/directives/Misc.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/directives/FormValidator.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/directives/CountDown.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/HomeCtrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/UserCtrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/helpsCtrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/helpsDetailCtrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/loginCtrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/forgetCtrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/drawCtrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/drawDetailCtrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/ChartsCtrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/footCtrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/lotteryCenter.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/bjpk10Ctrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/bjpk10BetCtrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/GameCtrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/sscCtrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/klsfCtrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/fclhcCtrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/fclhcHk6Ctrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/fclhcF3dCtrl.js"></script>
  <script type="text/javascript" src="${resourceRoot }/app/controllers/fclhcPl3Ctrl.js"></script>

