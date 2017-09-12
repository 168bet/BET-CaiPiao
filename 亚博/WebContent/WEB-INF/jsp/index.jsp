<%@ page language="java" import="java.util.*,com.mh.commons.constants.*"
  contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@ page import="com.mh.commons.utils.ServletUtils"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ taglib prefix="mh" uri="http://www.mh.com/framework/tags" %>
<!doctype html>
<html lang="en" ng-app="cpApp">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="x-UA-Compatible" content="IE=edge">
  <link rel="Shortcut Icon" href="${resourceRoot }/favicon.ico">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
  
  <%@include file="common.dev.inc" %>

  <script>
    var templateBaseURI = "${resourceRoot}/app/templates";
    var staticURI = "${resourceRoot}/app";
    var baseURI = "${ctx}";
  </script>

  <title>彩票</title>
</head>
<body>
  <ui-view></ui-view>
</body>
</html>