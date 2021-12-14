@extends('templates.single')

@section('article.featuredimage.after')   
    <div class="localevent-meta c-paper">
        <div class="localevent-meta__date">
            @typography(['variant' => 'h1', 'element' => 'span'])
                {{ $event['day'] }}
            @endtypography

            @typography(['variant' => 'h4', 'element' => 'span'])
                {{ $event['monthShort'] }}
            @endtypography
        </div>

        <div class="localevent-meta__metadata">

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
    </div>
@stop