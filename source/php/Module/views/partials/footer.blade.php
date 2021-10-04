@if($enable_more_events_button)
    <div class="c-card__footer">
        <div class="o-grid o-grid--no-gutter o-grid--no-margin">
            <div class="o-grid-12 o-grid-auto@sm u-text-align--right">
                @button([
                    'text' =>  $more_events,
                    'color' => 'primary',
                    'style' => 'basic',
                    'href' => $archive_link,
                    'icon' => 'add',
                    'reversePositions' => true,
                    'size' => 'md',
                    'classList' => ['u-display--block@xs']
                    ])
                @endbutton 
            </div>
        </div>
    </div>
@endif