@extends('template')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <p class="h3 text-center mb-3 mt-3">Teams:</p>
        </div><!-- col-lg-12 -->
    </div><!-- row -->
    <div class="row">
        <div class="col-md-3">
            <ul class="list-group list-group">
                @foreach( $tournament['teams']['qualify'] as $i => $team )
                    <li class="list-group-item">
                        <span class="badge badge-pill badge-light">{{ $i + 1 }}</span> {{ $team }}
                    </li>

                    @if ( $i > 0 && ( $i + 1 ) % 20 == 0 )
                        </ul>
                        </div>

                        <div class="col-md-3">
                        <ul class="list-group list-group">
                    @endif
                @endforeach
            </ul><!-- list-group -->
        </div><!-- col-md-3 -->
    </div><!-- row -->

    <div class="row">
        <div class="col-lg-12">
            <p class="h3 text-center mb-3 mt-3">Groups:</p>
        </div><!-- col-lg-12 -->
    </div><!-- row -->
    <div class="row">
        @php $i = 0 @endphp

        @foreach ($tournament['groups'] as $groupName => $teams)
            <div class="col-md-3">
                <ul class="list-group mb-3">
                    <li class="list-group-item active">{{ $groupName }}</li>
                    @foreach( $teams as $team )
                    <li class="list-group-item">{{ $team }}</li>
                    @endforeach
                </ul>
            </div>

            @if( ( $i + 1 ) % 4 == 0 && $i != 15 )
                </div>
                <div class="row">
            @endif

            @php $i++ @endphp
        @endforeach
    </div>
        
    <div class="row">
        <div class="col-lg-12">
            <p class="h3 text-center mb-3 mt-3">Qualify Matches:</p>
        </div><!-- col-lg-12 -->
    </div><!-- row -->
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-sm table-hover">
            @foreach ($tournament['matches']['qualify'] as $id => $match)
                @php
                    $e = explode(' ', $match );

                    $match = array(
                        'team_1' => implode(' ', array( $e['0'], $e[1] ) ),
                        'score_1' => $e[2],
                        'score_2' => $e[4],
                        'team_2' => implode(' ', array( $e[5], $e[6] ) )
                    );
                @endphp
                <tr>
                    <td class="text-right">{{ $match['team_1'] }}</td>
                    <td class="text-center">
                        @php $class = ( $match['score_1'] >= 16 ) ? 'badge-success' : 'badge-danger'; @endphp
                        <span class="badge badge-pill {{ $class }}">{{ $match['score_1'] }}</span>
                    </td>
                    <td class="text-center">
                        @php $class = ( $match['score_2'] >= 16 ) ? 'badge-success' : 'badge-danger'; @endphp
                        <span class="badge badge-pill {{ $class }}">{{ $match['score_2'] }}</span>
                    </td>
                    <td class="text-left">{{ $match['team_2'] }}</td>
                </tr>                
            @endforeach
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <p class="h3 text-center mb-3 mt-3">Playoff Teams:</p>
        </div><!-- col-lg-12 -->
    </div><!-- row -->
        <div class="row">
        <div class="col-lg-4 offset-md-4">
            <ul class="list-group">
                @foreach ( $tournament['teams']['playoff'] as $i => $team )
                    <li class="list-group-item">
                        <span class="badge badge-pill badge-light">{{ $i + 1 }}</span> {{ $team }}
                    </li>
                @endforeach
            </ul>
        </div><!-- col-lg-12 -->
    </div><!-- row -->

    <div class="row">
        <div class="col-lg-12">
            <p class="h3 text-center mb-3 mt-3">Playoff Matches:</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            @php
                $counterTotal = count($tournament['teams']['playoff']) / 2;
                $counter = 0;    
            @endphp

            <table class="table table-sm table-hover">
            @foreach ($tournament['matches']['playoff'] as $match)
                @php
                    $e = explode(' ', $match );

                    $match = array(
                        'team_1' => implode(' ', array( $e['0'], $e[1] ) ),
                        'score_1' => $e[2],
                        'score_2' => $e[4],
                        'team_2' => implode(' ', array( $e[5], $e[6] ) )
                    );
                @endphp

                <tr>
                    <td class="text-right">{{ $match['team_1'] }}</td>
                    <td class="text-center">
                        @php $class = ( $match['score_1'] >= 16 ) ? 'badge-success' : 'badge-danger'; @endphp
                        <span class="badge badge-pill {{ $class }}">{{ $match['score_1'] }}</span>
                    </td>
                    <td class="text-center">
                        @php $class = ( $match['score_2'] >= 16 ) ? 'badge-success' : 'badge-danger'; @endphp
                        <span class="badge badge-pill {{ $class }}">{{ $match['score_2'] }}</span>
                    </td>
                    <td class="text-left">{{ $match['team_2'] }}</td>
                </tr>

                @php
                    $counter = $counter + 1;
                @endphp

                @if ($counter == $counterTotal)
                    <tr class="bg-white text-center">
                        <td colspan="4">-</td>
                    </tr>
                    @php
                        $counterTotal = $counter / 2;
                        $counter = 0;
                    @endphp
                @endif
            @endforeach
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 offset-md-4 text-center">
            <div class="alert alert-success" role="alert">
                <h2>Champion: <strong>{{ $tournament['champion'] }}</strong></h2>
            </div>
        </div>
    </div>
@endsection