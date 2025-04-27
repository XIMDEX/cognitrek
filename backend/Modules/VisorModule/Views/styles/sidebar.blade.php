
<style>
    .conditions-header {
        position: relative;
        padding: 10px 0;
        margin: 0;
        transition: background-color 0.2s;
    }

    .conditions-header:hover {
        background-color: #f5f5f5;
    }

    .accordion-icon {
        transition: transform 0.3s ease;
    }

    .conditions-header.collapsed .accordion-icon {
        transform: rotate(-90deg);
    }

    .variant-conditions {
        font-size: 0.75rem;
        padding-inline: 20px;
        max-height: 300px;
        transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
        overflow: hidden;
        opacity: .7;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        row-gap: 10px;
        column-gap: 30px;

    }

    .variant-conditions.collapsed {
        max-height: 0;
        opacity: 0;
    }
    
    .tox-toolbar__group {
        align-items: center;
    }

    #new-message {
        padding: 10px;
        margin-bottom: 20px;

    }

    .error-message {
        background-color: #ffb1bc38;
        color: red;
    }

    .success-message {
        background-color: #68fa4a1c;
        color: green;

    }

    .history-header {
        position: relative;
        padding: 10px 0;
        margin: 0;
        transition: background-color 0.2s;
    }

    .history-header:hover {
        background-color: #f5f5f5;
    }

    .accordion-icon {
        transition: transform 0.3s ease;
    }

    .history-header.collapsed .accordion-icon {
        transform: rotate(-90deg);
    }

    .history-list {
        max-height: 300px;
        transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
        overflow: hidden;
        opacity: 1;
    }

    .history-list.collapsed {
        max-height: 0;
        opacity: 0;
    }

    .sidebar {
        min-width: 400px;
        max-width: 500px;
        background: hsl(215.29, 54.84%, 93.92%);
        color: #333;
        padding: 30px;
        border-right: 1px solid #eaeaea;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        gap: 30px;
        flex-shrink: 0;
        height: 100dvh;
        overflow-y: auto;
        box-sizing: border-box;
    }

    .sidebar-section {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 0;
        border-bottom: none;
        padding-bottom: 0;
    }

    .sidebar-section h3 {
        color: #333;
        font-size: 0.85rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .sidebar .title {
        font-size: 1.2rem;
        /* Smaller title */
        color: #333;
        margin-bottom: 5px;
    }

    .sidebar .last-edit {
        font-size: 0.8rem;
        color: #666;
    }

    .variant-picker {
        width: 100%;
        padding: 12px;
        border: 1px solid #eaeaea;
        border-radius: 8px;
        background: #f8f8f8;
        font-size: 0.9rem;
        color: #333;
        transition: border-color 0.2s;
    }

    .variant-picker:hover {
        border-color: #ddd;
    }

    .edit-mode-switch {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px;
        background: #f8f8f8;
        border: 1px solid #eaeaea;
        border-radius: 8px;
        font-size: 0.9rem;
    }
</style>