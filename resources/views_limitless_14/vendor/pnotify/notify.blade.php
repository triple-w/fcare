@if (Session::has('notifier.notice'))
    <input type="hidden" id="pnotify-content" value='{!! Session::get('notifier.notice') !!}' />
@endif