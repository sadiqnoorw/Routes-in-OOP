feat: Implement basic routing and route resolution for Home and Invoice pages

- Set up the index.php as the entry point for the web application.
- Added autoloading via Composer for dependency management.
- Created a basic routing system using the Router class.
- Registered GET and POST routes for the application:
  - '/' mapped to the 'index' method of the Home controller.
  - '/invoice' mapped to the 'index' method of the Invoice controller.
  - '/invoice/create' mapped to the 'create' (GET) and 'store' (POST) methods of the Invoice controller.
- Implemented route resolution to handle dynamic URL requests based on HTTP methods.
