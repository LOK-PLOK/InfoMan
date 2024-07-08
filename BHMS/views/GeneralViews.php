<?php

/**
 * This class contains all the general views that are used in the application.
 * 
 * @method burger_sidebar
 * @class GeneralViews
 */
class GeneralViews {

    /**
     * This method is used to display the burger sidebar.
     * 
     * @method burger_sidebar
     * @return void
     */
    public static function burger_sidebar() {
        echo <<<HTML
            <div class="hamburger-sidebar">
                <i class="fa-solid fa-bars"></i>
            </div>
        HTML;
    }

}

?>