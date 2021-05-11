@extends('templates.single')

@section('layout')
<div class="o-container">
    <div class="o-grid u-margin__top--4">
        @if(!empty($event['image_src']))
            <div class="o-grid-12 o-grid-8@lg">
                @image([
                    'src'=> $event['image_src'],
                ])
                @endimage
            </div>
        @endif
        
        <div class="o-grid-12 o-grid-8@lg modularity-local-event-heading">
            <div class="modularity-local-event-date-box">
                @typography(['variant' => 'h1', 'element' => 'span'])
                    {{ $event['day'] }}
                @endtypography

                @typography(['variant' => 'h4', 'element' => 'span'])
                    {{ $event['monthShort'] }}
                @endtypography
            </div>

            @typography([
                'variant' => 'h1',
                'element' => 'h1',
                'classList' => ['modularity-local-event-title']
            ])
                {{ the_title() }}
            @endtypography

        </div>
                
        <div class="o-grid-12 o-grid-8@lg">
            @if (!empty($event['dateFormatted']))
                @typography(['variant' => 'h4', 'element' => 'h4'])
                    {{ $event['dateFormatted'] }}
                @endtypography
            @endif

            @icon(['icon' => 'map']) @endicon
            @typography(['element' => 'span'])
                {{$event['place']}}
            @endtypography

        </div>

        <div class="o-grid-12 o-grid-8@lg">
            <article class="c-article">
                @if (!empty(get_extended($post->postContentFiltered)['main']) && !empty(get_extended($post->postContentFiltered)['extended']))
                    {!! get_extended($post->postContentFiltered)['main'] !!}
                    {!! get_extended($post->postContentFiltered)['extended'] !!}
                @else
                    {!! $post->postContentFiltered !!}
                @endif
            </article>
        </div>
    </div>
</div>
@stop

