@extends('templates.single')

@section('article.featuredimage.after')   
    <div class="localevent-meta c-paper">
        @datebadge([
            'date' => $event['date'],
        ])
        @enddatebadge

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