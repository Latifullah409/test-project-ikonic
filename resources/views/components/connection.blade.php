<div class="my-2 shadow text-white bg-dark p-1" id="row_{{@$connection->id}}">
  <div class="d-flex justify-content-between">
    <table class="ms-1">
      <td class="align-middle">{{ $connection->name }}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle">{{ $connection->email }}</td>
      <td class="align-middle">
    </table>
    <div>
      <button style="width: 220px" id="get_connections_in_common" data-id="{{@$connection->id}}" class="btn btn-primary" type="button"
        data-bs-toggle="collapse" data-bs-target="#collapse_{{@$connection->id}}" aria-expanded="false" aria-controls="collapseExample">
        Connections in common ( {{$connection->commonCount($connection->id)}} )
      </button>
      <button id="remove_connection_btn" data-id="{{@$connection->id}}" class="btn btn-danger me-1 remove_connection_btn">Remove Connection</button>
    </div>

  </div>
  <div class="collapse" id="collapse_{{@$connection->id}}">

    <div id="content_{{@$connection->id}}" class="p-2">
      {{-- Display data here --}}
      {{-- <x-connection_in_common /> --}}
    </div>
    <div id="connections_in_common_skeletons_">
      {{-- Paste the loading skeletons here via Jquery before the ajax to get the connections in common --}}
    </div>
    <div class="d-flex justify-content-center w-100 py-2">
      <button class="btn btn-sm btn-primary" id="load_more_connections_in_common_">Load
        more</button>
    </div>
  </div>
</div>
