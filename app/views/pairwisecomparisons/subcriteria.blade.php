@extends('layouts.master')
@section('content')
<ol class="breadcrumb">
    <li>{{ HTML::link('home', 'Home') }}</li>
    <li>{{ HTML::link('pairwisecomparison', 'Pairwise Comparisons') }}</li>
    <li class="active">Subcriteria</li>
</ol>
@if (Session::has('success'))
<div class="alert alert-success fade in alert-dismissable text-left">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('success') }}</strong>
</div>
@endif
@if ($CR<=0.1)
<div class="alert alert-success fade in alert-dismissable text-left">
    <strong>Pairwise Comparison CONSISTENT</strong>
</div>
<!-- <div class="btn-group pull-right">
    {{ HTML::link('judgment/subcriteria/'.$criterion->criterion_id, 'Change Judgments', array('class' => 'btn btn-success btn-rounded-lg')) }}
</div> -->
@else
<div class="alert alert-danger fade in alert-dismissable text-left">
    <strong>Pairwise Comparison NOT CONSISTENT.</strong> Judgments are not saved in the database.
</div>
<div class="btn-group pull-right">
    {{ HTML::link('judgment/subcriteria/'.$criterion->criterion_id, 'Change Judgments', array('class' => 'btn btn-success btn-rounded-lg')) }}
</div>
@endif
<h1 class="page-header" style="margin-top:0;">{{$criterion->criterion}}'s Pairwise Comparison</h1>
<!-- <h1 class="page-header" style="margin-top:0;">{{$criterion->criterion}}</h1> -->
<div class="the-box full">
    <div class="table-responsive">
        <table class="table table-th-block text-center">
            <thead>
                <tr class="info">
                    <td>{{strtoupper($criterion->criterion)}}</td>
                    @foreach($subcriteria as $key => $value)
                    <td>{{ $value->subcriterion }}</td>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <?php $max = count($subcriteria); ?>
                @for($i=0;$i<$max;$i++)
                <tr>
                    <td class="info">{{ $subcriteria[$i]->subcriterion }} </td>
                    @for($j=0;$j<$max;$j++)
                    <td>{{ round($judgments[$i][$j], 2) }}</td>
                    @endfor
                </tr>
                @if($i==($max-1))
                <tr>
                    <td class="info">TOTAL</td>
                    @for($j=0;$j<$max;$j++)
                    <td>{{ round($judgmentTotal[$j],2) }}</td>
                    @endfor
                </tr>
                @endif
                @endfor
            </tbody>
        </table>
    </div><!-- /.table-responsive -->
</div><!-- /.the-box full -->

<h1 class="page-header" style="margin-top:0;">Normalization</h1>
<div class="the-box full">
    <div class="table-responsive">
        <table class="table table-th-block text-center">
            <thead>
                <tr class="info">
                    <td>{{strtoupper($criterion->criterion)}}</td>
                    @foreach($subcriteria as $key => $value)
                    <td>{{ $value->subcriterion }}</td>
                    @endforeach
                    <td>TPV</td>
                    <td>Rating</td>
                    <td>Weight</td>
                </tr>
            </thead>
            <tbody>
                <?php $max = count($subcriteria); ?>
                @for($i=0;$i<$max;$i++)
                <tr>
                    <td class="info">{{ $subcriteria[$i]->subcriterion }} </td>
                    @for($j=0;$j<$max;$j++)
                    <td>{{ round($normalization[$i][$j], 2) }}</td>
                    @endfor
                    <td class="warning">{{ round($tpv[$i], 2) }}</td>
                    <td class="warning">{{ round($rating[$i], 2) }}</td>
                    <td class="warning">{{ round($weight[$i], 2) }}</td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div><!-- /.table-responsive -->
</div><!-- /.the-box full -->

<h1 class="page-header" style="margin-top:0;">Consistency Ratio</h1>
<div class="the-box full">
    <div class="table-responsive">
        <table class="table table-th-block text-center">
            <thead>
                <tr class="info">
                    <td>{{strtoupper($criterion->criterion)}}</td>
                    @foreach($subcriteria as $key => $value)
                    <td>{{ $value->subcriterion }}</td>
                    @endforeach
                    <td>TOTAL</td>
                    <td>&lambda;</td>

                </tr>
            </thead>
            <tbody>
                @for($i=0;$i<$max;$i++)
                <?php $total = 0; ?>
                <tr>
                    <td class="info">{{ $subcriteria[$i]->subcriterion }} </td>
                    @for($j=0;$j<$max;$j++)
                    <td>{{ round($judgments[$i][$j]*$tpv[$j], 2) }}</td>
                    <?php $total =  $total + ($judgments[$i][$j]*$tpv[$j]); ?>
                    @endfor
                    <td class="warning">{{round($total, 2)}}</td>
                    <td class="warning">{{round($total/$tpv[$i], 2)}}</td>

                </tr>
                @endfor
            </tbody>
        </table>
    </div><!-- /.table-responsive -->
</div><!-- /.the-box full -->
<hr />
<div class="row">
    <div class="col-sm-3">
        &lambda; max = &Sigma; &lambda; / n
        <br />
        &lambda; max = {{round(array_sum($lamda),2)}} / {{$max}}
        <br />
        &lambda; max = {{round($lamdaMax,2)}}
    </div>
    <div class="col-sm-3">
        CI = (&lambda; max / n) / (n - 1)
        <br />
        CI = ({{round($lamdaMax,2)}}/{{$max}}) / ({{$max}} - 1)
        <br />
        CI = {{round($CI,2)}}
    </div>
    <div class="col-sm-3">
        CR = CI / RIn
        <br />
        CR = {{round($CI,2)}} / {{$RI}}
        <br />
        CR = {{round($CR,2)}}
    </div>
    <div class="col-sm-3">
        CR <= 0.1
        <br />
        <!-- {{round($CR,2)}} <= 0.1 -->
        {{round($CR,2)}} <= 0.1
        <br />
        @if($CR<=0.1)
        <span class="label square label-success">CONSISTENT</span>
        @else
        <span class="label square label-danger">NOT CONSISTENT</span>
        @endif
    </div>
</div>
@stop