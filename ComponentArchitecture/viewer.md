# Viewer Module (VISOR component)

**This component is located in the `backend/Modules/ViewerModule` folder.**

This documentation describes the Viewer Module, which facilitates the rendering and management of resource views in a Laravel project. The module includes services and controllers for handling resources and their variants, ensuring seamless integration with your application.

## Module Overview

The Viewer Module is designed to provide a flexible way to manage and display resources retrieved from external systems. It supports the rendering of content with options for handling modified data and different resource variants.

## File Descriptions

1. ViewerService.php

The ViewerService class handles the core logic for rendering resource views.
* Namespace: Modules\ViewerModule\Services
* Key Methods:
    * performAction($params):
        * Reserved for future actions related to the Viewer Module.
    * view($resource, $modified):
        * Renders the resource view using the provided data.
        * Parameters:
            * $resource: The resource data to display.
            * $modified: Modified data, if any, to incorporate into the view.
        * Returns an HTML view or a JSON error response if rendering fails.

2. api.php

Defines the API routes for the Viewer Module.
* Namespace: Not applicable (route file).
* Key Routes:
    * GET /viewer/health:
        * Health check endpoint for the module.
        * Returns a JSON response: { "status": "ok" }.
    * GET /viewer/{resource_id}:
        * Endpoint to view a resource by its ID.
        * Calls the view method in the ViewerController.

3. ViewerController.php

The ViewerController class manages incoming requests and interacts with the ViewerService to display resources.
* Namespace: Modules\ViewerModule\Controllers
* Dependencies:
    * ResourceService: Retrieves resources from external systems.
    * VariantService: Fetches variants of resources, if available.
* Key Methods:
    * view(Request $request, $resourceId):
        * Retrieves the specified resource and its variants, then delegates rendering to ViewerService.
        * Parameters:
            * $request: The HTTP request object.
            * $resourceId: The unique identifier of the resource.
        * Returns an HTML view or a JSON error response.

4. config.php

Defines the configuration for the Viewer Module.
* Configuration Keys:
* name: Module name (ViewerModule).
* version: Module version (1.0.0).
* services: Registers the ViewerService.

Usage Instructions

Using the Service in Controllers

In any controller that extends from Controller, you can leverage the following methods to interact with the ViewerModule services:

1.	$this->useService('service_name_in_config', $params):
* Executes the performAction($params) method of the corresponding service.

Example:

```PHP
$result = $this->useService('viewer_service', [
    'action' => 'view',
    'id' => $resourceId,
]);
```

2.	$this->getService('service_name_in_config'):
* Retrieves an instance of the service for custom interactions.
Example:

```PHP
$viewerService = $this->getService('viewer_service');
$result = $viewerService->view($resourceData, $modifiedData);
```

## Environment Configuration

No specific environment variables are required for the Viewer Module by default. Ensure your system properly configures the ResourceService and VariantService to interact with external systems or databases.

Security Notes
* Data Validation: Ensure that incoming requests for resources are validated to prevent unauthorized access.
* Error Handling: Implement robust error logging for the view method to diagnose issues efficiently.
* Secure Rendering: Avoid exposing sensitive data in the rendered views.

## Conclusion

The Viewer Module provides a streamlined way to display resources and their variants in your Laravel application. Its modular design and clear structure make it easy to maintain and extend, ensuring reliable integration into your project. ￼
