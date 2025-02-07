
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
</style>