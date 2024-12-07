@props(['id'])
<div class="modal fade" id="{{{$id}}}" tabindex="-1" aria-labelledby="{{$id}}Label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="{{$id}}Label">{{$title}}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{$content}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          {{$action ?? null}}
        </div>
      </div>
    </div>
  </div>
