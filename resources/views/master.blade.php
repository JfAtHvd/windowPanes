<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
             @yield('title', 'WindowPanes')
        </title>
        
        <link rel="stylesheet" type="text/css" href="css/windowPanes.css">

        
    </head>
    <body>
        <header>
            <h1>WindowPanes Prototype v4.0</h1>
		</header>
		
		<section>
			@yield('content')
		</section>
		
		@stack('body')
		
    </body>
</html>
