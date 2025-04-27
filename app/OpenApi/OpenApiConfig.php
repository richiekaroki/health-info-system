<?php

namespace App\OpenApi;

use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Health Info System API",
 *         description="API Documentation for Client and Program Management",
 *         termsOfService="https://example.com/terms",
 *         @OA\Contact(email="api@example.com"),
 *         @OA\License(name="MIT", url="https://opensource.org/licenses/MIT")
 *     ),
 *     @OA\Server(url="http://localhost:8000", description="Local Development"),
 *     @OA\Server(url="https://api.yourdomain.com", description="Production"),
 *     @OA\ExternalDocumentation(
 *         description="Find more info here",
 *         url="https://swagger.io"
 *     ),
 *     @OA\Tag(name="Clients", description="Client operations"),
 *     @OA\Tag(name="Programs", description="Program operations")
 * )
 */
class OpenApiConfig {}
