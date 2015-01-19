<!-- Static navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('posts.index') }}">{{ $site_name }}</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="{{ isActiveRouteName('posts.newest') }}"><a href="{{ route('posts.newest') }}">new</a></li>
                <li class="{{ isActiveRouteName('comments.newest') }}"><a href="{{ route('comments.newest') }}">comments</a></li>
                <li class="{{ isActiveRouteName('posts.show_off') }}"><a href="{{ route('posts.show_off') }}">show</a></li>
                <li class="{{ isActiveRouteName('posts.ask') }}"><a href="{{ route('posts.ask') }}">ask</a></li>
                <li class="{{ isActiveRouteName('posts.create') }}"><a href="{{ route('posts.create') }}">submit</a></li>
                @if( Auth::check() )
                <li class="{{ isActiveRouteName('posts.submitted') }}"><a href="{{ route('posts.submitted') }}">your submissions</a></li>
                <li class="{{ isActiveRouteName('comments.threads') }}"><a href="{{ route('comments.threads') }}">your threads</a></li>
                @endif
            </ul>
            @if( ! Auth::check() )
            <ul class="nav navbar-nav pull-right">
                <li class="{{ isActiveRouteName('auth.login') }}"><a href="{{ route('auth.login') }}"><i class="fa fa-sign-in"></i> login</a></li>
                <li class="{{ isActiveRouteName('auth.register') }}"><a href="{{ route('auth.register') }}"><i class="fa fa-arrow-right"></i> Join</a></li>
            </ul>
            @else
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-user"></i> {{ Auth::user()->username }} <span class="caret"></span></a>
                    <ul role="menu" class="dropdown-menu">
                        @if( $_is_admin_or_moderator )
                            <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Go to Admin Dashboard</a></li>
                            <li class="divider"></li>
                        @endif
                        <li><a href="{{ Auth::user()->present()->getEditProfileLink() }}"><i class="fa fa-cogs"></i> Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ Auth::user()->present()->getProfileLink() }} "><i class="fa fa-user"></i> My Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Log out</a></li>
                    </ul>
                </li>
            </ul>
            @endif
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>
