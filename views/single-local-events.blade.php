@extends('templates.single')

@section('sidebar-left')
@stop

@section('above')
@if(!empty($post->images['featuredImage']['src']))
    @segment([
        'layout'            => 'full-width',
        'image'             => $post->images['featuredImage']['src'],
        'background'        => 'primary',
        'textColor'         => 'light',
        'overlay'           => 'dark',
        'classList'         => ['modularity-event-hero', 'u-margin__bottom--5'],
        'textAlignment'     => 'center',
        'title'             => $post->postTitle,
        'content'           => $event['dateFormatted'] ?? false,
    ])
    @endsegment
@endif
@stop

@section('content')
    <div class="u-display--inline-flex {{empty($post->images['featuredImage']['src']) ? 'u-margin__top--4' : ''}}">
        @if(isset($event['date']))
            @datebadge([
                'date' => $event['date']
            ])
            @enddatebadge
        @endif
        
        @typography([
            'variant' => 'h1',
            'element' => 'span',
            'classList' => ['u-margin__left--2', 'u-margin__top--0']
        ])
            {{$post->postTitle}}
        @endtypography
    </div>
    <article>
        {!! $post->postContentFiltered !!}
    </article>
@endsection

@section('sidebar-right')
@card([
    'content' => $event['dateFormatted'],
    'classList' => [empty($post->images['featuredImage']['src']) ? 'u-margin__top--4' : '']
])
    <div class="c-card__body">
        @typography([
            'element' => 'h2',
            'variant' => 'h3',
            'classList' => ['c-card__heading']
        ])
            {{$post->postTitle}}
        @endtypography
        <ul>
            <li>
                {{$event['dateFormatted']}}
            </li>
        </ul>
    </div>
@endcard
@stop