<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-section">
        <div class="doc-info">
            <h3 class="title">{{ $resource['title'] }}</h3>
        </div>
    </div>

    <div class="sidebar-section pb-4 border-b hidden flex" style="flex-direction: row;">
        <div id="back-list" class="">
            <div class="flex items-center justify-between">
                <button class="border border-1 border-blue px-2 py-1 bg-gray-300">Back to list</button>
            </div>
        </div>
        <div class="flex items-center justify-between">
            <button id="create-new" class="border border-1 border-blue px-2 py-1 bg-gray-300">Create new Adaptation</button>
        </div>
    </div>

    <div id="new-adaptation" class="sidebar-section p-4" style="border: 1px solid gray; display: block;">
        <h3 class="mb-4">New Adaptation</h3>
        <div>
            <label for="label" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 0.8rem;">
                label
                <input type="text" id="label-new" name="label" placeholder="Name for new variant..." style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
            </label>
        </div>
        <div id="selected-tags"></div>
        <div class="flex items-center justify-end" style=" gap: 10px; margin-block: 15px; justify-content:end">
            <button id="save-new" class="border border-1 border-blue px-2 py-1 bg-gray-300">Save</button>
            <button id="cancel-new" class="border border-1 border-blue px-2 py-1 bg-gray-300">Cancel</button>
        </div>
        <div id="new-message" class="success-message">Esto es una prueba</div>
    </div>
    <div class="sidebar-section">
    </div>

    <div id="adaptations" class="sidebar-section">
        <h3>Adaptations</h3>
        <select class="variant-picker" onchange="changeVariant(this.value)" title="Cambiar tema">
            @foreach ($adaptations as $adaptation)
                <option value="{{$adaptation['label']}}" @if(isset($adaptation["selected"]) && $adaptation["selected"]) selected @endif>{{$adaptation['label']}}</option>
            @endforeach
        </select>
        <h4 class="conditions-header" onclick="toggleConditionsAccordion()" style="cursor: pointer; user-select: none;">
            Conditions on Adaptation
            <span class="accordion-icon" style="float: right; transition: transform 0.3s;">▼</span>
        </h4>
        <div class="variant-conditions">
            @foreach ($conditions as $condition)
                <label for="{{$condition['name']}}" style="display: flex; flex-direction: row; align-items:center; gap: 5px;">
                    <input type="checkbox" name="{{$condition['name']}}" id="{{ $condition['id'] }}" disabled @if($condition["selected"]) checked @endif >
                    {{$condition['name']}}
                </label>
            @endforeach
        </div>
        <div class="edit-mode-switch" style="display: flex;justify-content: space-between;align-items: center;gap: 32px;width: 100%;background: #f8f8f8;padding: 10px;border-radius: 8px;box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <h3 style="font-size: 0.9rem; color: #666;">Edit Mode</h3>

            <label class="switch" style="margin: 0 5px;">
                <input type="checkbox" id="editModeToggle" onchange="toggleEditMode()">
                <span class="slider"></span>
            </label>
        </div>
    </div>

    <div class="sidebar-section">
        <h3 class="history-header" onclick="toggleHistoryAccordion()" style="cursor: pointer; user-select: none;">
            History
            <span class="accordion-icon" style="float: right; transition: transform 0.3s;">▼</span>

        </h3>
        <div class="history-list">
            <div class="history-item">
                <div class="change">No Changes</div>
            </div>
        </div>
    </div>

</div>

@include('visor::js.sidebar')
