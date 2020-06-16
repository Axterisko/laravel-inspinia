<div>
    <div class="axt-sheet-wrapper">

        <div class="axt-sheet-header">
            <i class="axt-sheet-header__close" role="button">&times</i>
            @isset($title)
                <div class="axt-sheet-header__title">
                    {!! $title !!}
                </div>
            @endisset
            @isset($actions)
                <div class="axt-sheet-header__actions">
                    {{ $actions }}
                </div>
            @endisset

        </div>
        <div class="sheet-scrollpane">
            <div class="sheet-content  sheet-padding">
                {{ !empty($content) ? $content : $slot }}
            </div>
        </div>

    </div>
</div>
