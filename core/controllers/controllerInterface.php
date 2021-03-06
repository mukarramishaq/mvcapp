<?php
/**
 * controllerInterface file contains Interface named
 * controllerInterface.
 * @author Mukarram Ishaq
 */

namespace Core\Controllers;

/**
 * Interface ControllerInterface
 */
Interface ControllerInterface
{
    /**
     * @return mixed
     */
    public function beforeAction();

    /**
     * @return mixed
     */
    public function afterAction();

    /**
     * @param \Core\Request $request
     * @param array $filters
     * @return mixed
     */
    public function validate(\Core\Request $request, array $filters);

    /**
     * @param \Core\Request $request
     * @return mixed
     */
    public function handle(\Core\Request $request, array $otherParams);
}