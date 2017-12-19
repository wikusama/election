    <nav class="navbar navbar-transparent navbar-absolute" id="top">
    	<div class="container">
        	<!-- Brand and toggle get grouped for better mobile display -->
        	<div class="navbar-header">
        		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example">
            		<span class="sr-only">Toggle navigation</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
        		</button>
        		<a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
        	</div>

        	<div class="collapse navbar-collapse" id="navigation-example">
        		<ul class="nav navbar-nav navbar-right">
					@if(Auth::check())
						<li>
							<a href="{{ route('home') }}">Home</a>
						</li>
						@if(Auth::user()->admins)	
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">administration<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="{{ route('candidates') }}">Manage Candidates</a></li>
								<li><a href="{{ route('configHeader') }}">Config Header</a></li>
								<li><a href="{{ route('admins') }}">Group Admin</a></li>
								<li><a href="{{ route('members') }}">Group Members</a></li>
								<li><a href="{{ route('result') }}">Result</a></li>
							</ul>
						</li>
						@endif
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Welcome, {{ Auth::user()->name }}<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="{{ route('logout') }}">Logout</a></li>
							</ul>
						</li>
					@else
		            <li>
		                <a href="{{ $login_url }}" class="btn btn-info btn-just-icon btn-facebook">
							<i class="fa fa-facebook-square"></i> Login with Facebook
						</a>
					</li>
					@endif
        		</ul>
        	</div>
    	</div>
    </nav>