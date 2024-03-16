<?php

namespace A11yBuddy\Frontend;

use A11yBuddy\Application;
use A11yBuddy\Frontend\BasePage\NotFoundView;
use A11yBuddy\Router;

/**
 * Displays the content of a custom page supplied by the user, e.g. an Imprint or Privacy Policy page.
 */
class CustomPageController implements Controller
{

    public function run(array $data = [])
    {
        $customPages = Application::getInstance()->getConfig()["custom_pages"] ?? [];
        $route = Router::getRequestUri();
        if (isset($customPages[$route])) {
            $type = $customPages[$route]["type"];
            $lang = Localize::getInstance()->getLocale();

            // Check if a file for this language exists - otherwise use the default locale
            $file = $customPages[$route]["files"][$lang] ?? $customPages[$route]["files"]["en"];

            if (!file_exists($file)) {
                NotFoundView::render();
                return;
            }

            $fileContent = file_get_contents($file);

            if ($type === "markdown") {
                $markdownParser = new \Parsedown();
                $markdownParser->setSafeMode(true);

                echo $markdownParser->text($fileContent);
            } elseif ($type === "html") {
                echo $fileContent;
            } else {
                throw new \Exception("Unknown custom page type: " . $type);
            }

        } else {
            NotFoundView::render();
        }
    }

}