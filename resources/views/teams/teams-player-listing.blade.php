@extends('layouts.layout')
@section('title', 'Team Players')
 
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
    
    <!-- Modal -->
    <div class="modal fade" id="teamModal" tabindex="-1" role="dialog" aria-labelledby="teamModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="teamModalLabel">Edit Team</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

         <form id="updateTeam"  action="" method="POST">
                @csrf
            
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            <input type="hidden" id="teamId" name="id">
                            <input type="text" id="teamName" name="name" class="form-control" placeholder="Name" >
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                         <div class="form-group">
                            <strong>Country:</strong>
                            <input type="text" id="country"  name="country" class="form-control" placeholder="Enter 3 Character Country Code">
                         </div>
                     </div>
                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Balance £:</strong>
                            <input type="number" id="balance" class="form-control" min="0" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)" name="balance" step="0.25" />
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            
         </form>

            <form id="updatePlayer" action="" method="POST">
                @csrf
                <h5 class="modal-title" id="teamModalLabel">Edit Player</h5>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="hidden" id="playerId" name="id" class="form-control">
                            <strong>Player Name:</strong>
                            <input type="text" id="playerName" name="name" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" id="editPlayerSave" class="btn btn-primary">Submit</button>
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
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Country</th>
            <th>Balance</th>
            <th width="30%">Players</th>
        </tr>
        @php
        $count = ($teams->currentPage() - 1) * $teams->perPage();
        @endphp

        @foreach ($teams as $team)
        <tr>
            <td>{{ ++$count}}</td>
            <td>{{ $team->name }}</td>
            <td>{{ $team->country }}</td>
            <td>{{ $team->balance }}</td>
            <td>
              @foreach ($team->players as $key => $player)
                    @if ($key > 0)
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{  $team->name . $key }}" aria-expanded="true" aria-controls="collapse{{ $team->name . $key }}">
                                    <p>{{ '#' . $key .' ' . $player->name }}</p>
                                </button>
                                </h2>
                                <div id="collapse{{  $team->name . $key }}" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <form action="{{ route('team-player.destroy',$player->id) }}" method="POST">

                                    <a class="btn btn-primary editPlayer" data-toggle="modal" data-id="{{$player->id}}" data-name="{{$player->name}}" data-target="#teamModal">Edit</a>
                                    <a class="btn btn-warning deletePlayer" data-toggle="modal"  data-id="{{$player->id}}" >Delete</a>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
             </td>
            <td>
                <a class="btn btn-success editTeam" data-toggle="modal" data-target="#teamModal" data-id="{{ $team->id }}" data-name="{{ $team->name }}" data-country="{{ $team->country }}" data-balance="{{ $team->balance }}" >Edit Team</a>
                <a class="btn btn-danger deleteTeam"  data-id="{{$team->id}}">Delete</a>        
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $teams->links() !!}

       
      
@endsection