@card([
    'heading' => apply_filters('the_title', $post_title),
    'classList' => [$classes],
    'context' => 'localEvent'
])
    @if (!$hideTitle && !empty($post_title))
        <div class="c-card__header">
            @typography([
                'element' => "h4"
            ])
                {!! apply_filters('the_title', $post_title) !!}
            @endtypography
        </div>
    @endif

    @if (!empty($events))
        @include('partials.list')
        @includeWhen($mod_event_archive, 'partials.footer')
    @else
        <div class="c-card__body">
            {{$no_events}}
        </div>
    @endif
@endcard
