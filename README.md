This repository is using Laravel and Scribe

What I do in this example:

-   generate multiple docs
-   with & without using Resource
-   use almost all the Attributes provided from Scribe
-   use static type
-   provide multiple responses status example

To check the example results:

-   /docs
-   /docs/admin

Issue I found (need your help if you find the solution)
if the route is not 'docs' in static type, the assets (js, css) generate wrong path,
that is why I set the admin inside docs, not set it separately
