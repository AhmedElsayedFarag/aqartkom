<!-- BEGIN: Notification Content -->
<div id="success-notification-content" class="toastify-content hidden flex">
    @if (session('success'))
        <i class="text-success" data-feather="check-circle"></i>
        <div class="ml-4 mr-4">
            <div class="font-medium">نجاح!</div>
            <div class="text-slate-500 mt-1">{{ session('success') }}</div>
        </div>
    @endif
    @if (session('danger'))
        <i class="text-danger" data-feather="x-circle"></i>
        <div class="ml-4 mr-4">
            <div class="font-medium">فشل!</div>
            <div class="text-slate-500 mt-1">{{ session('danger') }}</div>
        </div>
    @endif
</div> <!-- END: Notification Content -->
<button id="success-notification-toggle" style="visibility: hidden;" class="btn btn-primary">Show Notification</button>


<!-- BEGIN: Notification Content -->
<div id="pusher-notification-content" class="toastify-content hidden flex">
    <i class="text-success" data-feather="check-circle"></i>
    <div class="ml-4 mr-4">
        <div class="font-medium">نجاح!</div>
        <div class="text-slate-500 mt-1" id="notification_message"></div>
    </div>
</div> <!-- END: Notification Content -->
<button id="pusher-notification-toggle" style="visibility: hidden;" class="btn btn-primary">Show Notification</button>




@pushIf(session('success')||session('danger'), 'scriptsStack')
<script>
    document.getElementById("success-notification-toggle").click();
</script>
@endPushIf
