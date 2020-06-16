<div>
    <div class="axt-sheet-wrapper">

        <div class="axt-sheet-header">
            <i class="axt-sheet-header__close" role="button">&times</i>
            <div class="axt-sheet-header__title">
                @yield('content-title','')
            </div>
            <div class="axt-sheet-header__actions">
                @yield('actions')
            </div>
            <div class="axt-sheet-header__description">
            @yield('content-description', '')
            </div>
        </div>
        <div class="sheet-scrollpane">
            <div class="sheet-content  sheet-padding">
                @yield('content')
            </div>
        </div>

    </div>
</div>
