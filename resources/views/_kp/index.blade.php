<!DOCTYPE html>
<html lang="ru">
<head>
	<title>OneTech</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="OneTech shop project">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="{{asset('kp/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css')}}" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{{asset('css/app.css')}}">
<!--link rel="stylesheet" type="text/css" href="{{asset('kp/styles/responsive.css')}}"-->

</head>

<body>

<div class="super_container">

	<!-- Header Section Starts -->
	@include('_kp.positions.header.default')
	<!-- Header Section Ends -->

	<!-- Main Container Starts -->
	@include('_kp.positions.content.default')
	<!-- Main Container Ends -->

	<!-- Footer Section Starts -->
	@include('_kp.positions.footer.default')
	<!-- Footer Section Ends -->

</div>

<script src="{{asset('js/app.js')}}" charset="utf-8"></script>

</body>

</html>