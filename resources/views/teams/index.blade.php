@extends('layouts.layout')
@section('title', 'Add Teams & Players')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right margin-tb">
                <a class="btn btn-success" data-toggle="modal" data-target="#teamModal" onclick ="openTeamForm();"> Add Team</a>
            </div>
            <br>
            <div class="pull-right margin-tb">
                <a class="btn btn-warning" data-toggle="modal" data-target="#teamModal" onclick ="openPlayerForm();"> Add Player</a>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="teamModal" tabindex="-1" role="dialog" aria-labelledby="teamModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="teamModalLabel">Team</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

         <form id="createTeamForm" action="{{ route('teams.store') }}" method="POST">
                @csrf
            
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            <input type="text" name="name" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                         <div class="form-group">
                            <strong>Country:</strong>
                            <input type="text" name="country" class="form-control" placeholder="Enter 3 Character Country Code">
                         </div>
                     </div>
                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Balance £:</strong>
                            <input type="number" class="form-control" min="0" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)" name="balance" step="0.25" />
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            
         </form>

            <form id="addPlayer" action="{{ route('team-player.store') }}" method="POST">
                @csrf
                <h5 class="modal-title" id="teamModalLabel">Add Player</h5>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Player Name:</strong>
                            <input type="text" id="playerName" name="name" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Team:</strong>
                            
                            <select id="teamId" name="team_id" class="form-control" required>
                                <option value="">Select a Team</option>
                                @foreach ($teams as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
@endsection