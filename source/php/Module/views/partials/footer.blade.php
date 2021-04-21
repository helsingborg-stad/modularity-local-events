<div class="c-card__footer">
    <div class="o-grid o-grid--no-gutter o-grid--no-margin">
        <div class="o-grid-12 o-grid-auto@sm u-text-align--right">
            @button([
                'text' =>  __('More events', 'modularity-local-events'),
                'color' => 'primary',
                'style' => 'basic',
                'href' => get_post_type_archive_link('modularity-local-events'),
                'icon' => 'add',
                'reversePositions' => true,
                'size' => 'md',
                'classList' => ['u-display--block@xs']
                ])
            @endbutton 
        </div>
    </div>
</div>