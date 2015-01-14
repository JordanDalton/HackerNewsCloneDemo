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
            <a class="navbar-brand" href="{{ route('posts.index') }}">Hacker News Clone</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="{{ isActiveRouteName('posts.newest') }}"><a href="{{ route('posts.newest') }}">new</a></li>
                <li class="{{ isActiveRouteName('comments.newest') }}"><a href="{{ route('comments.newest') }}">comments</a></li>
                <li class="{{ isActiveRouteName('posts.show_off') }}"><a href="{{ route('posts.show_off') }}">show</a></li>
                <li class="{{ isActiveRouteName('posts.ask') }}"><a href="{{ route('posts.ask') }}">ask</a></li>
                <li class="{{ isActiveRouteName('posts.create') }}"><a href="{{ route('posts.create') }}">submit</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>
