<?php

namespace A11yBuddy\Frontend\BasePage;

use A11yBuddy\Application;
use A11yBuddy\Frontend\Localize;
use A11yBuddy\Frontend\View;

/**
 * Outputs the content of the <footer> tag
 */
class FooterView implements View
{

    public static function render(array $data = [])
    {
        ?>
        <hr class="mb-3" aria-hidden="true">
        <div class="container">
            <p class="text-center">
                <?php echo Application::NAME . " - " . Application::VERSION; ?>
            </p>
            <p class="text-center">
                <?php
                // Output custom footer links
                $links = Application::getInstance()->getConfig()["footer"]["links"];
                $locale = Localize::getInstance()->getLocale();

                if (isset($links[$locale])) {
                    foreach ($links[$locale] as $link => $title) {
                        echo '<a href="' . $link . '">' . $title . '</a> ';
                    }
                }
                ?>
            </p>
        </div>

        <script src="template/dependencies/bootstrap/js/bootstrap.bundle.min.js"></script>
        <?php
    }

}