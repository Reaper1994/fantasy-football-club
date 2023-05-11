function openPlayerForm() {
    $('#addPlayer').show();
    $('#createTeamForm').hide();
    $('.form-control').val('');
}

function openTeamForm() {
    $('#createTeamForm').show();
    $('#addPlayer').hide();
    $('.form-control').val('');
}

$(document).ready(function() {
  $('#addPlayer').hide();

  $('#createTeamForm').on('submit', function(event) {
      event.preventDefault();

      $.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(data) {
              // Handle the successful response
              alert("Team Added succesfully");
              alert("Add a Player");
              $('#addPlayer').show();
              $('#createTeamForm').hide();
              $('#teamId').append($('<option>', {
                  value: JSON.parse(data.id),
                  text: JSON.parse(data.name)
              }));
              $('#teamId').val(JSON.parse(data.id));
          },
          error: function(xhr, status, error) {
              // Handle the error response
              var response = JSON.parse(xhr.responseText);
              alert(response.message);
          }
      });
  });

  $('#addPlayer').on('submit', function(event) {
      event.preventDefault();

      $.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          data: $(this).serializeArray(),
          dataType: 'json',
          success: function(data) {
              // Handle the successful response
              alert("Player Added succesfully");
              alert("Add anoter Player or exit");
              $('#playerName').val('');
              $('#playerSurname').val('');
              $('#addPlayer').show();
              $('#createTeamForm').hide();

          },
          error: function(xhr, status, error) {
              // Handle the error response
              var response = JSON.parse(xhr.responseText);
              alert(response.message);
          }
      });
  });

  $('.editPlayer').on('click', function(event) {

      $('#updatePlayer').show();
      $('#updateTeam').hide();
      $('#playerName').val($(this).data('name'));
      $('#playerSurname').val($(this).data('surname'));
      $('#playerId').val($(this).data('id'));

  });

  $('.editTeam').on('click', function(event) {

      $('#updatePlayer').hide();
      $('#updateTeam').show();
      $('#teamId').val($(this).data('id'));
      $('#teamName').val($(this).data('name'));
      $('#country').val($(this).data('country'));
      $('#balance').val($(this).data('balance'));

  });

  $('.deleteTeam').on('click', function() {

      if (confirm('Are you sure you want proceed, Warnign! doing so will delet all its associated players?')) {
          // make the AJAX call to delete the player
          $.ajax({
              url: 'teams/' + $(this).data('id'),
              type: 'DELETE',
              data: {
                  _token: $('meta[name="csrf-token"]').attr('content'),
                  id: $(this).data('id'),
              },
              dataType: 'json',
              success: function(response) {
                  // Handle the successful response
                  alert(response.message);

                  $('#teamModal').modal('hide'); // hide the modal
                  location.reload(); // reload the page

              },
              error: function(xhr, status, error) {
                  // Handle the error response
                  var response = JSON.parse(xhr.responseText);
                  alert(response.message);
              }
          });
      }
  });

  $('.deletePlayer').on('click', function() {

      if (confirm('Are you sure you want to delete player ?')) {
          // make the AJAX call to delete the player

          $.ajax({
              url: 'team-player/' + $(this).data('id'),
              type: 'DELETE',
              data: {
                  _token: $('meta[name="csrf-token"]').attr('content'),
                  id: $(this).data('id'),
              },
              dataType: 'json',
              success: function(response) {
                  // Handle the successful response
                  alert(response.message);

                  $('#teamModal').modal('hide'); // hide the modal
                  location.reload(); // reload the page

              },
              error: function(xhr, status, error) {
                  // Handle the error response
                  var response = JSON.parse(xhr.responseText);
                  alert('Something went wrong!')
                  console.log(response.message);
              }
          });
      }
  });

  $('#updatePlayer').on('submit', function(event) {
      event.preventDefault();

      var data = $(this).serializeArray();
      $.ajax({
          url: 'team-player/' + $('#playerId').val(),
          type: 'PUT',
          data: data,
          dataType: 'json',
          success: function(data) {
              // Handle the successful response
              alert("Player data Updated succesfully");
              $('#playerName').val('');
              $('#playerSurname').val('');
              $('#playerId').val('');

              $('#teamModal').modal('hide'); // hide the modal
              location.reload(); // reload the page

          },
          error: function(xhr, status, error) {
              // Handle the error response
              var response = JSON.parse(xhr.responseText);
              alert(response.message);
          }
      });
  });

  $('#updateTeam').on('submit', function(event) {
      event.preventDefault();

      var data = $(this).serializeArray();
      $.ajax({
          url: 'teams/' + $('#teamId').val(),
          type: 'PUT',
          data: data,
          dataType: 'json',
          success: function(data) {
              // Handle the successful response
              alert("Team data Updated succesfully");
              $('#teamName').val('');
              $('#country').val('');
              $('#balance').val('');

              $('#teamModal').modal('hide'); // hide the modal
              location.reload(); // reload the page

          },
          error: function(xhr, status, error) {
              // Handle the error response
              var response = JSON.parse(xhr.responseText);
              alert(response.message);
          }
      });
  });

  // Add event listener for modal close
  $('#teamModal').on('hidden.bs.modal', function() {
      onModalClose();
  });

  // Define function to be triggered on modal close
  function onModalClose() {
      //console.log('Modal closed!');
      $('#addPlayer').hide();
      $('#createTeamForm').show();
      $('#teamId').val('');
      $('input').val('');
  }

  // sell buy player js

  $('#sellPlayer').on('submit', function(event) {
      event.preventDefault();

      var data = $(this).serializeArray();
      $.ajax({
          url: 'sell-buy-player/' + $('#playerId').val() + '/sell',
          type: 'POST',
          data: data,
          dataType: 'json',
          success: function(response) {
              // Handle the successful response         
              alert(response.message);
              $('#playerId').val('');
              $('#teamModal').modal('hide'); // hide the modal
              location.reload(); // reload the page

          },
          error: function(xhr, status, error) {
              // Handle the error response
              var response = JSON.parse(xhr.responseText);
              console.log(response.message)
              alert(status + ": something went wrong");
          }
      });
  });

  $('.sellPlayer').on('click', function(event) {
      $('#playerId').val($(this).data('id'));
      $('#sellPlayer').show();

      $('#buyPlayer').hide();

  });

  $('.buyPlayer').on('click', function(event) {
      $('#teamId').val($(this).data('id'));
      $('#sellPlayer').hide();
      $('#buyPlayer').show();

  });

  $('#buyPlayer').on('submit', function(event) {
      event.preventDefault();

      var data = $(this).serializeArray();
      $.ajax({
          url: 'sell-buy-player/buy',
          type: 'POST',
          data: data,
          dataType: 'json',
          success: function(response) {
              // Handle the successful response
              alert(response.message);

              $('#teamId').val('');
              $('#teamModal').modal('hide'); // hide the modal

              location.reload(); // reload the page

          },
          error: function(xhr, status, error) {
              // Handle the error response
              var response = JSON.parse(xhr.responseText);
              console.log(response.message)

              alert(status + ": something went wrong");
          }
      });
  });

});