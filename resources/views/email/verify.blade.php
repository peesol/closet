<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Closet</title>
<style>
	html {
    	font-family: Avenir, Helvetica, sans-serif;
    	height: 100%;
    	box-sizing: border-box;
	}
	body{
		background-color: #f2f2f2;
		margin:0;
	}
	.container{
    	display: flex;
    	justify-content: center;
		position: relative;
	}
	.header{
		position: absolute;
		top: 0;
		width: 100%;
		height: 100px;
		background: linear-gradient(to bottom, #ffab2d 1%,#ff8300 64%,#ff8000 100%);
	}
	.btn {
	  border: transparent;
	  color: #333333;
	  font-size: 15px;
	  background: rgba(0, 0, 0, 0.07);
	  padding: 10px 20px 10px 20px;
	  text-decoration: none;
	  box-shadow:0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
	}
	.btn:hover {
	  color: #ffffff;
	  background: #b5b5b5;
	}
	.panel {
		position: absolute;
		top: 100px;
    	width: 100%;
    	height: calc(100% - 100px);
    	background-color: #fff;
    	margin: 0 auto;
	}
	.login-panel {width: 650px;}
	.panel-heading{
		padding: 10px 15px;
    	background-color: #fff;
    	border-bottom: 1px solid #efefef;
    	overflow: hidden;
    	text-overflow: ellipsis;
    	white-space: nowrap;
	}
	.panel-heading h3{margin: 0;}
	.panel-body {
		padding: 15px;
		text-align: center;
    	height: 150px;
    }
    img{
   		position: absolute;
    	top: 20px;
    	left: 20px;
    }
    footer{
    	position: absolute;
    	bottom: 0;
    	height: 100px;
    	background: linear-gradient(to top, #ffab2d 1%,#ff8300 64%,#ff8000 100%);
    }
</style>

</head>
<body>
<div class="container">
	<div class="header">
		<img src="{{asset("images/logo2.png")}}">
	</div>
	    <div class="panel">
	            <div class="login-panel">
	                <div class="panel-heading"><h3>Verify</h3></div>
	                <div class="panel-body">
	                <h4>Thank you,{{$name}}.</h4>
	                <h4>Click this link to verify your email</h4>
	                <a class="btn" href="{{url('/register/verify/'.$email_token)}}">Click here</a>
	                </div>
	            </div>
	    </div>
	<footer>
		<h5>© {{ date('Y') }} {{config('app.name')}} All rights reserved.</h5>
	</footer>
</div>
</body>
</html>
