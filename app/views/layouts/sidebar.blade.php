<div class="sidebar">
    <ul class="stacked-menu">
        <li{{ Request::segment(1)=='home' ? ' class="active"' : '' }}>{{ HTML::link('home', 'Home') }}</li>
        <li><a href="#">Keywords <i class="fa fa-angle-down right-icon"></i></a>
            <ul{{ Request::segment(1)=='keyword' || Request::segment(1)=='campaign' ? ' style="display: block;"' : '' }}>
                <li{{ Request::segment(1)=='keyword' && Request::segment(2)=='import' ? ' class="active"' : '' }}>{{ HTML::link('keyword/import', 'Add Keywords') }}</li>
                @if(Auth::check())
                <li{{ Request::segment(1)=='campaign' && Request::segment(2)=='' ? ' class="active"' : '' }}>{{ HTML::link('campaign', 'View Campaigns') }}</li>
                @else
                <li{{ Request::segment(1)=='keyword' && Request::segment(2)=='' ? ' class="active"' : '' }}>{{ HTML::link('keyword/result', 'View Keywords') }}</li>
                @endif
            </ul>
        </li>
        @if(Auth::check())
        <li><a href="#">Criteria <i class="fa fa-angle-down right-icon"></i></a>
            <ul{{ Request::segment(1)=='criteria' || Request::segment(1)=='subcriteria' ? ' style="display: block;"' : '' }}>
                <li{{ Request::segment(1)=='criteria' && Request::segment(2)=='create' ? ' class="active"' : '' }}>{{ HTML::link('criteria/create', 'Add Criterion') }}</li>
                <li{{ Request::segment(1)=='criteria' && Request::segment(2)=='' ? ' class="active"' : '' }}>{{ HTML::link('criteria', 'View Criteria') }}</li>
            </ul>
        </li>
        <li><a href="#">Pairwise Comparisons <i class="fa fa-angle-down right-icon"></i></a>
            <ul{{ Request::segment(1)=='pairwisecomparison' || Request::segment(1)=='judgment' ? ' style="display: block;"' : '' }}>
            <?php
            $status = Ahp::criteriaConsistency() ? 'color:green;' : 'color:red;';
            ?>
                <li{{ Request::segment(1)=='pairwisecomparison' && Request::segment(2)=='criteria' ? ' class="active"' : '' }}>{{ HTML::link('pairwisecomparison/criteria', 'Criteria', array('style'=>$status)) }}</li>
                <?php
                $criteria = Criterion::all();
                ?>
                @foreach ($criteria as $criterion)
                <?php
                $consistency = Ahp::subcriteriaConsistency($criterion->criterion_id);
                if ($consistency) {
                    $status = 'color:green;';
                } else {
                    $status = 'color:red;';
                }
                ?>
                <li>{{ HTML::link('pairwisecomparison/subcriteria/'.$criterion->criterion_id, $criterion->criterion.'\'s subcriteria', array('style'=>$status)) }}</li>
                @endforeach
                <!-- <li{{ Request::segment(1)=='pairwisecomparison' && Request::segment(2)=='subcriteria' ? ' class="active"' : '' }}>{{ HTML::link('pairwisecomparison/subcriteria', 'Subcriteria') }}</li> -->
            </ul>
        </li>
        <!-- <li><a href="#">Judgments <i class="fa fa-angle-down right-icon"></i></a>
            <ul{{ Request::segment(1)=='judgment' ? ' style="display: block;"' : '' }}>
                <li{{ Request::segment(1)=='judgment' && Request::segment(2)=='criteria' ? ' class="active"' : '' }}>{{ HTML::link('judgment/criteria', 'Criteria') }}</li>
                <li{{ Request::segment(1)=='judgment' && Request::segment(2)=='subcriteria' ? ' class="active"' : '' }}>{{ HTML::link('judgment/subcriteria', 'Subcriteria') }}</li>
            </ul>
        </li> -->
        <li><a href="#">Users <i class="fa fa-angle-down right-icon"></i></a>
            <ul{{ Request::segment(1)=='user' ? ' style="display: block;"' : '' }}>
                <li{{ Request::segment(1)=='user' && Request::segment(3)=='edit' ? ' class="active"' : '' }}>{{ HTML::link('user/profile', 'Profile') }}</li>
                <li{{ Request::segment(1)=='user' && Request::segment(2)=='' ? ' class="active"' : '' }}>{{ HTML::link('user', 'Users') }}</li> 
            </ul>
        </li>
        @endif
    </ul>
</div>