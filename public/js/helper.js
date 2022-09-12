function ajaxForm(formItems) {
  var form = new FormData();
  formItems.forEach(formItem => {
    form.append(formItem[0], formItem[1]);
  });
  return form;
}



/**
 *
 * @param {*} url route
 * @param {*} method POST or GET
 * @param {*} functionsOnSuccess Array of functions that should be called after ajax
 * @param {*} form for POST request
 */
function ajax(url, method, functionsOnSuccess, form) {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  })

  if (typeof form === 'undefined') {
    form = new FormData;
  }

  if (typeof functionsOnSuccess === 'undefined') {
    functionsOnSuccess = [];
  }

  $.ajax({
    url: url,
    type: method,
    async: true,
    data: form,
    processData: false,
    contentType: false,
    dataType: 'json',
    beforeSend: function(){
        $('#skeleton').removeClass('d-none');
        $('#content').addClass('d-none');
    },

    success: function(response) {
        $('#'+response.btn_name).html(response.text+' ('+response.count+')');
        $('#skeleton').addClass('d-none');
        $('#content').html(response.users);
        $('#content').removeClass('d-none');
    },
    error: function(xhr, textStatus, error) {
        console.log(xhr.responseText);
        console.log(xhr.statusText);
        console.log(textStatus);
        console.log(error);
      },
  });
}


function exampleUseOfAjaxFunction(exampleVariable) {
  // show skeletons
  // hide content

  var form = ajaxForm([
    ['exampleVariable', exampleVariable],
  ]);

  var functionsOnSuccess = [
    [exampleOnSuccessFunction, [exampleVariable, 'response']]
  ];

  // POST
  ajax('/example_route', 'POST', functionsOnSuccess, form);

  // GET
  ajax('/example_route/' + exampleVariable, 'POST', functionsOnSuccess);
}

function exampleOnSuccessFunction(exampleVariable, response) {
  // hide skeletons
  // show content

  console.log(exampleVariable);
  console.table(response);
  $('#content').html(response['content']);
}


function ajaxRequest(url, method, userId){
      $.ajax({
        url: url,
        type: method,
        async: true,
        data: userId,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function(){

        },
        success: function(response) {
         hideRow(userId);
        },
      });
}
function hideRow(userId){
     $('.row_'+userId).parent('.shadow').addClass('d-none');
}
function ajaxGetConnectionsInCommon(url, method, userId){
      $.ajax({
        url: url,
        type: method,
        async: true,
        data: userId,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function(){

        },
        success: function(response) {
            $('#'+response.btn_name).html(response.text+' ('+response.count+')');
            $('#content').html(response.users);
        },
      });
}

// $(document).ready(function(e) {
//     var limit = 2;
//     $(".table1 li").slice(0, limit).show();
//     $(document).on('click','#load_more_btn',function(e){
//     limit += 5;
//     e.preventDefault();
//     $(".table1 li").slice(0, limit).show();
//     });
// });
