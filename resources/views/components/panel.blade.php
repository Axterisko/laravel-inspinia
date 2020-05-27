<div class="ibox{{isset($class) ? ' '.$class : ''}}">
    @if(isset($header) || isset($title))
        <div class="ibox-title">
            @if(isset($header))
                {{ $header }}
            @else
                <h5>{{ $title }}</h5>
                @isset($tools)
                    <div class="ibox-tools">
                        {{ $tools }}
                    </div>
                @endisset
            @endif
        </div>
    @endif
    <div class="ibox-content {{isset($loading) && $loading ? ' sk-loading' : ''}}">
        @if(isset($spinner))
            {{ $spinner }}
        @else
            <div class="sk-spinner sk-spinner-wandering-cubes">
                <div class="sk-cube1"></div>
                <div class="sk-cube2"></div>
            </div>
        @endif
        {{ !empty($body) ? $body : $slot }}
    </div>
    @isset($footer)
        <div class="ibox-footer">
            {{ $footer }}
        </div>
    @endisset
</div>
