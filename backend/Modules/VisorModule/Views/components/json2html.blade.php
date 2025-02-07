@foreach($resource['sections'] as $section)
<section class="book-container {{ $dyslexic_level ? 'level-' . $dyslexic_level  : '' }}">
    @foreach($section['blocks'] as $block)
        @if($block['type'] == 'p' || $block['type'] == 'text')
            @if(isset($block['original'])) 
                <div class="nonedit" style="display: flex; flex-direction: row; align-items: start;;margin-bottom: 10px; width: 100%; ">
                    <div>
                        <button class="show-config"  style="aspect-ratio: 1">@include('visor::icons.gear', ['width' => 18, 'height' => 18])</button>
                    </div>
                    <div style=" border: 1px solid gray; flex-grow: 1; border-radius: 5px;">
                        <div>
                            <div style="display: none; justify-content: end; border-bottom: 1px solid lightgray; align-items: center;"> <!-- display flex -->
                                <span style="padding-left: 10px;">Name condition change:</span>
                                <span id="current-change-condition" style="flex-grow: 1; font-weight: bold">Dyslexia LOW</span>
                                <button id="" style="height: fit-content; aspect-ratio: 1">⬅️</button>
                                <button id="" style="height: fit-content; aspect-ratio: 1">➡️</button>
                                <button id="" style="height: fit-content; aspect-ratio: 1">✅</button>

                            </div>
                            <p class="noeditcontent" style="padding-inline: 15px; {{ $block['styles'] }}" id="{{ $block['id'] }}"> <!-- class editcontent -->
                                @foreach($block['blocks'] as $item)
                                @if(isset($item['modified']) && is_array($item['modified']) && count($item['modified']) > 0)
                                    @php $modification = $item['modified'][count($item['modified'])-1]; @endphp
                                    @php $lastIndex = 0; @endphp
                                    {!! substr($item['content'], $lastIndex, $modification['start'] - $lastIndex) !!}
                                    @if($modification['type'] == 'modified')
                                    <span class="xmodified view modified" title="{{ $modification['original'] }}">{{ $modification['content'] }}</span>
                                    @elseif($modification['type'] == 'deleted')
                                    <span class="xmodified view deleted" title="Deleted">{{ substr($item['content'], $modification['start'], $modification['end'] - $modification['start']) }}</span>
                                    @elseif($modification['type'] == 'added')
                                    <span class="xmodified view added" title="Added">{{ $modification['content'] }}</span>
                                    @endif  
                                    @php $lastIndex = $modification['end']; @endphp
                                    {!! substr($item['content'], $lastIndex) !!}
                                @else
                                    {{ $item['content'] }}
                                @endif
                                    @endforeach
                            </p>
                        </div>
                        <div style=" background-color: #efefef; display: none; flex-direction: column; border-top: 1px solid gray;"> <!-- display flex -->
                            <span style="font-size: 0.7rem; background-color: #cdcdcd; padding: 5px 10px;">
                                Original Text
                            </span>
                            <p  style="padding-inline: 15px;{{ $block['styles'] }}" id="{{ $block['id'] }}">
                                @foreach($block['blocks'] as $item)
                                    @if($item['type'] == 'text')
                                        {{ $item['content'] }}
                                    @else
                                        <{{ $item['type'] }} id="{{ $item['id'] }}" style="{{ $item['styles'] }}"> {{ $item['content'] }}</{{ $item['type'] }}>
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <p  style="margin-left: 38px;{{ $block['styles'] }}" id="{{ $block['id'] }}">
                    @foreach($block['blocks'] as $item)
                        @if($item['type'] == 'text')
                            {{ $item['content'] }}
                        @else
                            <{{ $item['type'] }} id="{{ $item['id'] }}" style="{{ $item['styles'] }}"> {{ $item['content'] }}</{{ $item['type'] }}>
                        @endif
                    @endforeach
                </p>
            @endif
        @elseif($block['type'] == 'image')
        <img  src="{{ asset('storage/'.$block['path']) }}" alt="{{ $block['alt'] }}" style="max-width: calc(100% - 36px); margin-left: 38px;{{ $block['styles'] }}" />
        @endif
    @endforeach

</section>
@endforeach