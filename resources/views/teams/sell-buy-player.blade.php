@extends('layouts.layout')
@section('title', 'Sell/Buy Players')
 
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
    <!-- Modal -->
    <div class="modal fade" id="teamModal" tabindex="-1" role="dialog" aria-labelledby="teamModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="teamModalLabel">Sell/Buy Player</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
         <form id="sellPlayer"  action="" method="POST">
            <h6 class="modal-title" id="teamModalLabel">Sell Player</h6>
                @csrf
            
                <div class="row">
                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>for £:</strong>
                            <input type="hidden" id="playerId" name="player_id"  />
                            <input type="number" placeholder="Sell player for this amount" id="sell-amount" class="form-control" min="0" onchange="(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)" name="amount" step="0.25" />
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            
         </form>

            <form id="buyPlayer" action="" method="POST">
                @csrf
                <h6 class="modal-title" id="teamModalLabel">Buy Player</h6>
                <div class="row">
                   <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="hidden" id="teamId" name="team_id"  />
                            <select id="availablePlayers" name="player_id" class="form-control" required>
                                <option value="">Select a Player</option>
                               
                                @foreach ($sell_buy_players as $id => $sell_buy_player)
                                
                                    @if (!empty( $sell_buy_player->player->id) )
                                        <option value="{{ $sell_buy_player->player->id }}" data-amount={{$sell_buy_player->amount}} >{{ 'Prev Team : ' .$sell_buy_player->player->team->name .' | Player: ' . $sell_buy_player->player->name .' £ :' . $sell_buy_player->amount}}</option>
                                    @endif
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
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{  $team->name . $key }}" aria-expanded="true" aria-controls="collapse{{ $team->name . $key }}">
                                    <p>{{ '#' . $key + 1 .' ' . $player->name }}</p>
                                </button>
                                </h2>
                                <div id="collapse{{  $team->name . $key }}" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <form action="{{ route('team-player.destroy',$player->id) }}" method="POST">

                                    <a class="btn btn-primary sellPlayer" data-toggle="modal" data-id="{{$player->id}}" data-name="{{$player->name}}" data-target="#teamModal">Sell Player</a>
                                
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                @endforeach
             </td>
            <td>
                <a class="btn btn-success buyPlayer" data-toggle="modal" data-target="#teamModal" data-id="{{ $team->id }}" data-name="{{ $team->name }}" data-country="{{ $team->country }}" data-balance="{{ $team->balance }}" >Buy Player</a>      
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $teams->links() !!}

       
      
@endsection