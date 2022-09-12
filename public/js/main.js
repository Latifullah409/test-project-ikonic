var skeletonId = 'skeleton';
var contentId = 'content';
var skipCounter = 0;
var takeAmount = 10;

//common route for all get data
function getRequests(mode) {
    $("#load_more_btn_parent").text("Load More");
    ajax('get-user-data/'+mode, 'GET', undefined);
}

function getMoreRequests(mode) {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getConnections() {
  // your code here...
}

function getMoreConnections() {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

//get common connections
function getConnectionsInCommon(url,method,userId) {
   ajaxGetConnectionsInCommon(url,method,userId);
}

function getMoreConnectionsInCommon(userId, connectionId) {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getSuggestions() {
    var val = 'suggestion';
    ajax('get-user-data/'+val, 'GET', undefined);
}

function getMoreSuggestions() {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function sendRequest(url,method,userId) {
    ajaxRequest(url, method, userId);
}

function deleteRequest(userId, requestId) {
  // your code here...
}

function acceptRequest(userId, requestId) {
  // your code here...
}

function removeConnection(userId, connectionId) {
  // your code here...
}

$(function () {
  //to get suggestions
  getSuggestions();
  $('#get_suggestions_btn').on('click',function(){
    getSuggestions();
  });

  //to get send requests
  $('#get_sent_requests_btn').on('click',function(){
    getRequests('sent');
  });

  //to get received requests
  $('#get_received_requests_btn').on('click',function(){
    getRequests('receive');
  });

  //to get connections
  $('#get_connections_btn').on('click',function(){
    getRequests('connection');
  });

  //to get common connections
  $(document).on('click', '#get_connections_in_common', function(){
    var method = "GET";
    var userId = $(this).data('id');
    var url = 'common-connection/'+userId;
    getConnectionsInCommon(url,method,userId);
  });

  //sent request
  $(document).on('click', '.create_request_btn', function(){
    var method = "GET";
    var suggestionId = $(this).data('id');
    var url = 'sent-request/'+suggestionId;
    sendRequest(url,method,suggestionId);
  });

  //cancel request
  $(document).on('click', '.cancel_request_btn', function(){
    var method = "GET";
    var userId = $(this).data('id');
    var url = 'cancel-request/'+userId;
    sendRequest(url,method,userId);
  });

  //cancel request
  $(document).on('click', '.accept_request_btn', function(){
    var method = "GET";
    var userId = $(this).data('id');
    var url = 'accept-request/'+userId;
    sendRequest(url,method,userId);
  });

  //remove connection
  $(document).on('click', '.remove_connection_btn', function(){
    var method = "GET";
    var userId = $(this).data('id');
    var url = 'remove-connection/'+userId;
    sendRequest(url,method,userId);
  });

  //load more
  $(document).on('click', '#load_more_btn_parent', function(e){
    e.preventDefault();
    $(".shadow_tr:hidden").slice(0,3).fadeIn("slow");

    if($(".shadow_tr:hidden").length == 0){
        $("#load_more_btn_parent").text("No more data !!!");
    }
  });

});
