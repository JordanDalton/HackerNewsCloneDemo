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
                <li class="{{ isActiveRouteName('admin.dashboard.index') }}"><a href="{{ route('admin.dashboard.index') }}">dashboard</a></li>
                <li class="{{ isActiveRouteName('admin.users.index') }}"><a href="{{ route('admin.users.index') }}">users</a></li>
                <li class="{{ isActiveRouteName('admin.roles.index') }}"><a href="{{ route('admin.roles.index') }}">roles</a></li>
                <li class="{{ isActiveRouteName('admin.posts.index') }}"><a href="{{ route('admin.posts.index') }}">posts</a></li>
                <li class="{{ isActiveRouteName('admin.comments.index') }}"><a href="{{ route('admin.comments.index') }}">comments</a></li>
                <li class="{{ isActiveRouteName('admin.votes.index') }}"><a href="{{ route('admin.votes.index') }}">votes</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('posts.index') }}"><i class="fa fa-arrow-right"></i> Go to Frontend</a></li>
                <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>
