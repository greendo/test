@extends('layouts.app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Active link:</div>

                    <div class="panel-body">
                            @if ($active_link)
                                <input type="text" id="link_area" value="{{$active_link}}">
                            @else
                                <input type="text" id="link_area" value="no active link at the moment">
                            @endif
                        <form method="get" action="{{ url('/create_link') }}">
                            <button type="submit">Generate Link</button>
                        </form>
                    </div>

                    <div class="panel-body">
                        @if ($inviter)
                            You were invited by: <i style="color: blue">{{$inviter->name}} : {{$inviter->email}}</i>
                        @else
                            You registered by yourself!
                        @endif
                    </div>

                    <div class="panel-heading">Invited users:</div>

                    <div class="panel-body">
                        @if ($invited_users)
                            @foreach($invited_users as $i)
                                name: <i style="color: cornflowerblue">{{$i->name}}</i> email: <i style="color: cornflowerblue">{{$i->email}}</i><br>
                            @endforeach
                        @else
                            <i style="color: cornflowerblue">No users were invited</i>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
