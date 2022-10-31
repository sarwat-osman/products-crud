<!DOCTYPE html>
<html>
	<head>
	    <title>ProductsCRUD</title>
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
		<script type="text/javascript" src="{{ asset('js/index.js') }}"></script>
	</head>

	<body class="background">
	    
		<div class="container">
		    @yield('content')
		</div>
	    
	</body>
</html>