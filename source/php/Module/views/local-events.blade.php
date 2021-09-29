@card([
    'heading' => $postTitle,
    'classList' => [$classes],
    'context' => 'localEvent'
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
            {{ $no_events }}
        </div>
    @endif

    @includeWhen(!empty($events), 'partials.footer')
@endcard
