<?php

namespace Plugin\EccubePaymentLite3\Form\Type;

use DateTime;
use Eccube\Application;
use Exception;
use Plugin\EccubePaymentLite3\Util\PluginUtil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class CreditCardForTokenPaymentType extends AbstractType
{
    private $app;

    /**
     * CreditCardForTokenPaymentType constructor.
     * @param Application $app
     */
    public function __construct(Application $app) {
        $this->app = $app;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $objPlugin =& PluginUtil::getInstance($this->app);
        // Get contract_code from setting data
        $contract_code = $objPlugin->getSubData('contract_code');
        $builder
            ->add('contract_code', 'hidden', array(
                'data' => $contract_code,
                'constraints' => array(
                    new NotBlank(),
                    new Length(array(
                        'max' => 8,
                        'min' => 8,
                    )),
                ),
            ))
            ->add('credit_card_number', 'text')
            ->add('holder_name', 'text')
            ->add('expiration_month', 'choice', array(
                'choices' => array(
                    '' => '-',
                    '1' => '1月',
                    '2' => '2月',
                    '3' => '3月',
                    '4' => '4月',
                    '5' => '5月',
                    '6' => '6月',
                    '7' => '7月',
                    '8' => '8月',
                    '9' => '9月',
                    '10' => '10月',
                    '11' => '11月',
                    '12' => '12月',
                ),
            ))
            ->add('expiration_year', 'choice', array(
                'choices' => $this->getExpirationYears(10),
            ))
            ->add('security_code', 'text')
            ->add('token', 'hidden', array(
                'constraints' => array(
                    new NotBlank(array(
                        'message' => '購入処理中にエラーが発生しました。',
                    )),
                ),
            ));
        $builder
            ->addEventListener(
                FormEvents::POST_SUBMIT,
                array($this, 'validateExpiration')
            );
    }

    public function validateExpiration(FormEvent $event)
    {
        /** @var Form $form */
        /*
        $form = $event->getForm();
        $form['expiration_month'];
        $form['expiration_year'];
        $inputExpirationDateTime = new DateTime($form['expiration_year']->getData().'-'.sprintf('%02d', $form['expiration_month']->getData()).'-01');
        $firstDayOfThisMonth = new Datetime('first day of this month');
        $firstDayOfThisMonth->setTime(00,00,00);

        if ($firstDayOfThisMonth > $inputExpirationDateTime) {
            $form['expiration_year']->addError(new FormError('有効な年月を入力する必要があります。'));
            $form['expiration_month']->addError(new FormError(''));
        }
        */
    }

    /**
     * Get list expiration year
     * @param $years
     * @return array
     * @throws Exception
     */
    public function getExpirationYears($years)
    {
        $DateTime = new DateTime('today');
        $thisYear = (int) $DateTime->format('Y');
        $arr = array();
        for ($i = 0; $i < $years; $i++) {
            $arr[$thisYear] = $thisYear.'年';
            $thisYear++;
        }

        return $arr;
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'credit_card_for_token_payment';
    }
}
