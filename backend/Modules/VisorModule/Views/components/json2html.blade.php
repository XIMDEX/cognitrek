@foreach($resource['sections'] as $section)
<section data-sectionid="{{ $section['page'] }}" class="book-container {{ $dyslexic_level ? 'level-' . $dyslexic_level  : '' }}">
    @foreach($section['blocks'] as $block)
        @if($block['type'] == 'p' || $block['type'] == 'text')
            @if(isset($block['original'])) 
                @if($mode !== 'edit')
                    <p class="xcontent" style="{{ $block['styles'] }}" id="{{ $block['id'] }}">
                        @foreach($block['blocks'] as $item)
                            @if(isset($item['modified']) && is_array($item['modified']) && count($item['modified']) > 0)
                                @php $modification = $item['modified'][count($item['modified'])-1]; @endphp
                                @php $lastIndex = 0; @endphp
                                {!! substr($item['content'], $lastIndex, $modification['start'] - $lastIndex) !!}
                                @if($modification['action'] == 'modified')
                                    <span class="xmodified view modified" title="{{ $modification['original'] }}">{{ $modification['content'] }}</span>
                                    @elseif($modification['action'] == 'deleted')
                                    <span class="xmodified view deleted" title="Deleted">{{ substr($item['content'], $modification['start'], $modification['end'] - $modification['start']) }}</span>
                                    @elseif($modification['action'] == 'added')
                                    <span class="xmodified view added" title="Added">{{ $modification['content'] }}</span>
                                @endif  
                                @php $lastIndex = $modification['end']; @endphp
                                {!! substr($item['content'], $lastIndex) !!}
                            @else
                                {{ $item['content'] }}
                            @endif
                        @endforeach
                    </p>
                @else
                    <div class="nonedit" style="display: flex; flex-direction: row; align-items: start;;margin-bottom: 10px; width: 100%; ">
                        <div>
                            <button class="show-config button-gear"  style="aspect-ratio: 1">@include('visor::icons.gear', ['width' => 18, 'height' => 18])</button>
                        </div>
                        <div style=" border: 1px solid gray; flex-grow: 1; border-radius: 5px;">
                            <div>
                                <div class="actions" style="display: none; justify-content: end; border-bottom: 1px solid lightgray; align-items: center;"> 
                                    <span style="padding-inline: 10px; font-size: 0.75rem;"><em>Name condition change:</em></span>
                                    <span id="current-change-condition" style="flex-grow: 1; font-weight: bold; font-size: 0.75rem;">{{ $block['condition_label'] }}</span>
                                    <button class="button-condition button-undo" data-blockid="{{ $block['id'] }}" data-conditionid="{{ $block['condition_id'] }}" style="aspect-ratio: 1">@include('visor::icons.undo',  ['width' => 18, 'height' => 18])</button>
                                    <button class="button-condition button-redo" data-blockid="{{ $block['id'] }}" data-conditionid="{{ $block['condition_id'] }}" style="aspect-ratio: 1">@include('visor::icons.redo',  ['width' => 18, 'height' => 18])</button>
                                    <button class="button-condition button-accept" data-blockid="{{ $block['id'] }}" data-conditionid="{{ $block['condition_id'] }}" style="aspect-ratio: 1">@include('visor::icons.check',  ['width' => 18, 'height' => 18])</button>
                                    
                                </div>
                                <p class="xcontent @if($mode == 'edit') 'editcontent' @else 'noedit' @endif" style="padding-inline: 15px; {{ $block['styles'] }}" id="{{ $block['id'] }}">
                                    @foreach($block['blocks'] as $item)
                                    @if(isset($item['modified']) && is_array($item['modified']) && count($item['modified']) > 0)
                                        @php $modification = $item['modified'][count($item['modified'])-1]; @endphp
                                        @php $lastIndex = 0; @endphp
                                            {!! substr($item['content'], $lastIndex, $modification['start'] - $lastIndex) !!}
                                            @if($modification['action'] == 'modified')
                                                <span class="xmodified view modified" title="{{ $modification['original'] }}">{{ $modification['content'] }}</span>
                                                @elseif($modification['action'] == 'deleted')
                                                <span class="xmodified view deleted" title="Deleted">{{ substr($item['content'], $modification['start'], $modification['end'] - $modification['start']) }}</span>
                                                @elseif($modification['action'] == 'added')
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
                            <div class="original" style=" background-color: #efefef; display: none; flex-direction: column; border-top: 1px solid gray;"> 
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
                @endif
            @else
                <p  style="@if($mode=='edit') margin-left: 38px; @endif{{ $block['styles'] }}" id="{{ $block['id'] }}">
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