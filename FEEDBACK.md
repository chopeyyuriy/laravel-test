Hi you.

I was asked if I could give some feedback, so here it is.

First off let me say nice example, I like this attempt, you clearly read and digested what was asked of you.

I have a couple of small pointers, but I think you did a good job.


 - Strict Typing missing (`declare(strict_types=1);`) as first line after php opening tags to enforce strict typing.
 - Pagination meta in a json response is automatic in laravel when using resource collections.
 - In a Production environment, to force Laravel into 'API' mode i.e. treats all as json, we use an accept header (this is the accepted industry standard).
 - Routes don't belong in a controller, unless using a package like spatie/laravel-route-attributes.
 - Whilst products have stock and prices, both stock and prices are their own entities, and as such manipulated within their own controllers.


Example middleware used to force Laravel into 'API' mode
```php
<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
```
This would be added to the main `$middleware` array in the `app/Http/Kernel.php` file.

This automatically then ensure all responses we send are automatically passed back as JSON.


The vital takeaway from this is that strict types must be used at all times, as this prevents a lot of silly bugs cropping up.

Overall a great submission.

I have added you to my example repo, so you can see how I would have done it.
No one way is perfect, and I am not saying mine is better, but it is a good example of how I would have done it and will show a couple things
about how Laravel works that you may not have spotted.



