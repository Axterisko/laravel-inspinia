<div class="tabs-container{{isset($class) ? ' '.$class : ''}}">
    <ul class="nav nav-tabs" role="tablist">
        {{ $nav_tabs }}
    </ul>
    <div class="tab-content">
        {{ !empty($tab_panes) ? $tab_panes : $slot }}
    </div>
</div>
