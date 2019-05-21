@if (session()->has('flash_notification.message'))
{{-- <div class="alert alert-{{ session()->get('flash_notification.level') }} alertdismissible fade show" role="alert">
    {{ session()->get('flash_notification.message') }}
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">
            ×
        </span>
    </button>
</div> --}}
<div class="alert alert-{{ session()->get('flash_notification.level') }} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        {{ session()->get('flash_notification.message') }}
</div>
@endif