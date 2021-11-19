<?php

namespace App\Http\Requests\Handlers\Admin;

use App\Http\Requests\Handlers\RequestHandler;
use App\Parameters\Admin\SAASParameters;

/**
 *
 */
class SAASHandler extends RequestHandler
{

    /**
     * @return SAASParameters
     */
    public function getParameters(): SAASParameters
    {
        $parameters = new SAASParameters();
        $showroom = $this->request->get('saas');
        $parameters->name = $showroom['name'];
        $parameters->organization_name = $showroom['organization_name'];
        $parameters->organization_logo = $showroom['organization_logo'] ?? '';
        $parameters->email_regexp = $showroom['email'] ?? '';
        $parameters->max_users = $showroom['max_users'] ?? 10;
        $parameters->paid = $showroom['paid'] ?? 0;

        return $parameters;
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
