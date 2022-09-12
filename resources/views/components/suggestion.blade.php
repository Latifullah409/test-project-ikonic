<div class="my-2 shadow  text-white bg-dark p-1" >
  <div class="d-flex justify-content-between" id="">
    <table class="ms-1">
        <tr>
      <td class="align-middle">{{ @$sug->name }} </td>
      <td class="align-middle"> - </td>
      <td class="align-middle">{{ @$sug->email }}</td>
      <td class="align-middle">
    </tr>
    </table>
    <div>
      <button id="create_request_btn" data-id="{{@$sug->id}}" class="btn btn-primary me-1 create_request_btn row_{{$sug->id}}">Connect</button>
    </div>
  </div>
</div>



