# DIY

## Description
- This project is a diy PHP web framework designed with the primary purpose of understanding about the inner workings of web frameworks. It serves as exercise to understand the fundamental components and processes involved in building a web application framework.

## Structure
- app
    - Controllers
        - AboutMeController.php
- public
    - .htaccess
    - index.php
- routes
    - api.php
    - web.php
- src      
    - Http
        - Kernel.php
        - Request.php
        - Response.php
    - Routing
        - Routes.php
        - RouteHandler.php
        - RouteCallback.php
    - View
        View.php
        Viewable.php
        
- views
    aboutme.view.php