<nav class="navbar square navbar-info navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <button class="btn btn-info btn-sidebar-collapse">
                <span class="fa fa-arrows-h"></span>
            </button>
            <a data-scroll class="navbar-brand">KeywordPlanner</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        @if(Auth::check())
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->username; }} <b class="caret"></b></a>
                    <ul class="dropdown-menu square info no-border margin-list-rounded with-triangle">
                        <li>{{ HTML::link('user/profile', 'Profile') }}</li>
                        <li>{{ HTML::link('user/logout', 'Logout') }}</li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
        @endif
    </div><!-- /.container-fluid -->
</nav>