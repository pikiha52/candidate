<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
* @OA\Info(
*      version="1.0.0",
*      title="Testing ",
*      description="Testing",
*      @OA\Contact(
*          email="pikiha52@gmail.com"
*      ),
*      @OA\License(
*          name="Apache 2.0",
*          url="http://www.apache.org/licenses/LICENSE-2.0.html"
*      ),
* )
*
* @OA\Server(
*      url=L5_SWAGGER_CONST_HOST,
*      description="Testing"
* )

* @OAS\SecurityScheme(
*      securityScheme="bearer_token",
*      type="http",
*      scheme="bearer",
* )
*
*
*/
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
