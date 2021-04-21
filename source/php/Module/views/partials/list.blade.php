@collection([
    'classList' => [
        'c-collection--event', 'c-collection--bordered'
    ]
])
    @foreach($events as $event)
        <a href="{{get_permalink($event->ID)}}" class="c-collection__item c-collection__item--action">
            <span class="c-collection__icon c-collection__icon--date">
                <span class="c-collection__date">
                    <strong class="c-collection__day"><span>{{ $event->day }}</span></strong>
                    <span class="c-collection__month">{{ $event->monthShort }}</span>
                </span>
            </span>
            <span class="c-collection__content">
                @typography(['element' => 'h4'])
                     {!! apply_filters('the_title', $event->post_title) !!}
                    @typography(['variant' => 'meta', 'element' => 'p'])
                        {{ $event->dateFormatted }}
                    @endtypography
                @endtypography
            </span>
        </a>
    @endforeach
@endcollection