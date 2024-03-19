<?php

namespace A11yBuddy\Frontend\Projects;

use A11yBuddy\Frontend\BasePage\NotFoundController;
use A11yBuddy\Frontend\Controller;
use A11yBuddy\Project\Project;

class ShowProjectDetailsController extends Controller
{
    public function run(array $data = []): void
    {

        $project = Project::getByTextIdentifier($data["id"]);
        if ($project === null) {
            $notFoundController = new NotFoundController();
            $notFoundController->run();
            return;
        }

        $view = new ShowProjectDetailsView();
        $view->render(["project" => $project]);

    }
}