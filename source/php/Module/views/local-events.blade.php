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

    @if ($events)
        @include('partials.list')
    @else
        <div class="c-card__body">
            {{ $lang->noEvents }}
        </div>
    @endif

    @includeWhen($totalEvents > count($events), 'partials.footer')

@endcard
