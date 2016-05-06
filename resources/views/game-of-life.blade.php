@extends('layouts.master')

@section('title', 'Game Of Life')

@section('content')
    <div class="page-header text-center">
        <h1>
            <span class="text-muted">Conway's</span> Game of Life
        </h1>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div id='root'>
                <table class="grid">
                    <tbody>
                    <tr> <td class="tile"></td> <td class="tile"></td> <td class="tile"></td> </tr>
                    <tr> <td class="tile" style="background-color:#fff;"></td> <td class="tile"></td> <td class="tile"></td> </tr>
                    <tr> <td class="tile"></td> <td class="tile"></td> <td class="tile"></td> </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-footer">http://alanrsoares.github.io/redux-game-of-life/</div>
    </div>
    <script src="static/main.js"></script>
@endsection

