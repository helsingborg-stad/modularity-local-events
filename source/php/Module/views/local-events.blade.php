@card([
    'heading' => $postTitle,
    'classList' => [$classes],
    'context' => 'module.localevent.list'
])
    @if (!$hideTitle && !empty($postTitle))
        <div class="c-card__header">
            @typography([
                'element' => "h4"
            ])
                {!! $postTitle !!}
            @endtypography
        </div>
    @endif

    @if (!empty($events))
        @include('partials.list')
        @includeWhen($mod_event_archive, 'partials.footer')
    @else
        <div class="c-card__body">
            {{ $lang->noEvents }}
        </div>
    @endif

    @includeWhen(!empty($events), 'partials.footer')
@endcard
