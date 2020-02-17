<?php
/**
 * This file is part of the Wegmeister.SimpleCaptcha package.
 *
 * PHP version 7
 *
 * @category  Neos-Package
 * @package   Wegmeister\SimpleCaptcha
 * @author    Benjamin Klix <benjamin.klix@die-wegmeister.com>
 * @copyright 2018 die wegmeister gmbh
 * @license   https://github.com/die-wegmeister/Wegmeister.SimpleCaptcha/LICENSE MIT
 * @version   GIT: $Id$
 * @link      https://github.com/die-wegmeister/Wegmeister.SimpleCaptcha
 */

namespace Wegmeister\SimpleCaptcha\FormElements;

use TYPO3\Form\Core\Model\AbstractFormElement;
use TYPO3\Form\Core\Runtime\FormRuntime;
use TYPO3\Form\Exception;

/**
 * This is the implementation class of the SimpleCaptcha.
 * It checks and validates the saved time and
 * checks if more then $waitTime seconds passed.
 *
 * @category  Neos-Package
 * @package   Wegmeister\SimpleCaptcha
 * @author    Benjamin Klix <benjamin.klix@die-wegmeister.com>
 * @copyright 2018 die wegmeister gmbh
 * @license   https://github.com/die-wegmeister/Wegmeister.SimpleCaptcha/LICENSE MIT
 * @version   Release: 1.0.0
 * @link      https://github.com/die-wegmeister/Wegmeister.SimpleCaptcha
 */
class SimpleCaptcha extends AbstractFormElement
{
    /**
     * Get a customized default value
     *
     * @return array
     */
    public function getDefaultValue()
    {
        $now = time();
        return [
            'cts' => dechex($now),
            'confirmation' => sha1($now),
        ];
    }

    /**
     * Get a customized value
     *
     * @return array
     */
    public function getValue()
    {
        return $this->getDefaultValue();
    }


    /**
     * Run sum checks on submit of the captcha field.
     *
     * @param FormRuntime $formRuntime  The current form runtime
     * @param mixed       $elementValue The transmitted value of the form field.
     *
     * @return void
     */
    public function onSubmit(FormRuntime $formRuntime, &$elementValue)
    {
        $now = time();
        $time = hexdec($elementValue['cts']);
        $properties = $this->getProperties();

        if ($now < $time + $properties['waitTime']
            || sha1($time) !== $elementValue['confirmation']
        ) {
            $processingRule = $this
                ->getRootForm()
                ->getProcessingRule($this->getIdentifier());
            $processingRule
                ->getProcessingMessages()
                ->addError(
                    new Exception(
                        'Captcha validation failed. Please wait some seconds and try again.',
                        1533224074
                    )
                );
        }

        $elementValue['cts'] = dechex($now);
        $elementValue['confirmation'] = sha1($now);
    }
}
