{{-- @if ($message = Session::get('success')) --}}
<div class="alert alert-success alert-dismissible alert-has-icon show fade">
    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
    <div class="alert-body">
        <div class="alert-title">Success</div>
        <button class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
        {{ $message }}
    </div>
</div>
{{-- @endif --}}
