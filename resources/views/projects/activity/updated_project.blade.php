@if(count($activity->changes['after']) == 1) {{-- To prevent cases when the user updates more than one thing--}}
    {{ $activity->username() }} updated the {{ key($activity->changes['after']) }} of the project.
@else
    {{ $activity->username() }} updated the project.
@endif