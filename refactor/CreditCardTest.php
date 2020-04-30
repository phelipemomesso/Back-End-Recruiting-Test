<?php
require_once 'CreditCard.php';

/**
 * Class CreditCardTest
 *
 * @category Teste
 * @package  Pacote
 * @author   Phelipe <phelipe@gmail.com>
 * @license  https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

class CreditCardTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test if valid number.
     *
     * @return void
     */
    public function testValidNumber()
    {
        $credit_card = new CreditCard();
        $this->assertTrue($credit_card->Set('4444333322221111'));
    }

    /**
     * Test if invalid number.
     *
     * @return void
     */
    public function testInvalidNumberShouldReturError()
    {
        $credit_card = new CreditCard();
        $this->assertEquals(
            'ERROR_INVALID_LENGTH',
            $credit_card->Set('3333555522221111')
        );
    }

    /**
     * Test if valid number.
     *
     * @return void
     */
    public function testValidNumberShouldSetAndGet()
    {
        $credit_card = new CreditCard();
        $credit_card->Set('4444333322221111');
        $this->assertEquals('4444333322221111', $credit_card->Get());
    }
}
