<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Pet Project</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    </head>
    <body>
        <ul>
             <li>
                 <a href="http://kreaper.com/logout"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        Logout
                 </a>

                 <form id="logout-form" action="http://kreaper.com/logout" method="POST" style="display: none;">
					 {{ csrf_field() }}
                 </form>
              </li>
         </ul>
        
    	<div class="container">
    		@yield('content')
    	</div>
    </body>
</html>
