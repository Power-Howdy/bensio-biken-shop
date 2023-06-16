<?php

namespace Plugin\EccubePaymentLite3;

use Eccube\Application;
use Eccube\Common\Constant;
use Eccube\Entity\MailTemplate;
use Eccube\Entity\Master\DeviceType;
use Eccube\Entity\PageLayout;
use Eccube\Plugin\AbstractPluginManager;
use Symfony\Component\Filesystem\Filesystem;

class PluginManager extends AbstractPluginManager
{
    /**
     * Image folder path (cop source)
     * @var type
     */
    protected $imgSrc;

    /**
     * Image folder path (copy destination)
     * @var type
     */
    public function __construct()
    {
        // コピー元のディレクトリ
        $this->origin = __DIR__ . '/Resource/assets';
        // コピー先のディレクトリ
        $this->target = __DIR__ . '/../../../html';
        // Copy only image
        $this->imgSrc = __DIR__ . '/Resource/img/';
        $this->imgDst = __DIR__ . '/../../../html/plugin/gmo_epsilon';
    }

    public function install($config, $app)
    {
        $this->migrationSchema($app, __DIR__ . '/Migration', $config['code']);

        // リソースファイルのコピー
        $this->copyAssets();

        $this->createCreditCardPageLayout($app);
        $this->createTokenPaymentPageLayout($app);

        $this->createEccubePaymentLite3MailTemplate($app);
    }

    public function uninstall($config, $app)
    {
        $this->removeCreditCardPageLayout($app);
        $this->removeTokenPaymentPageLayout($app);

        $this->removeEccubePaymentLite3MailTemplate($app);

        $this->migrationSchema($app, __DIR__ . '/Migration', $config['code'], 0);

        // リソースファイルの削除
        $this->removeAssets();
    }

    public function enable($config, $app)
    {
        $this->createEccubePaymentLite3MailTemplate($app);
    }

    public function disable($config, $app)
    {
        $this->removeEccubePaymentLite3MailTemplate($app);
    }
    private function createTokenPaymentPageLayout($app)
    {
        $pageLayoutRepo = $app['orm.em']->getRepository('Eccube\Entity\PageLayout');
        $url = 'paylite_credit_card_for_token_payment';
        /** @var DeviceType $DeviceType */
        $DeviceType = $app['orm.em']->getRepository('Eccube\Entity\Master\DeviceType')->find(DeviceType::DEVICE_TYPE_PC);
        /** @var PageLayout $PageLayout */
        $PageLayout = $pageLayoutRepo->findOneBy(array('url' => $url));
        if (is_null($PageLayout)) {
            $PageLayout = $pageLayoutRepo->newPageLayout($DeviceType);
        }

        $PageLayout->setCreateDate(new \DateTime());
        $PageLayout->setUpdateDate(new \DateTime());
        $PageLayout->setName('商品購入/クレジットカード入力');
        $PageLayout->setUrl($url);
        $PageLayout->setFileName('EccubePaymentLite3/Twig/mypage/edit_credit_card');
        $PageLayout->setMetaRobots('noindex');
        $PageLayout->setEditFlg(PageLayout::EDIT_FLG_DEFAULT);

        $app['orm.em']->persist($PageLayout);
        $app['orm.em']->flush();
    }

    private function removeTokenPaymentPageLayout($app)
    {
        $pageLayoutRepo = $app['orm.em']->getRepository('Eccube\Entity\PageLayout');

        /** @var PageLayout $PageLayout */
        $PageLayout = $pageLayoutRepo->findOneBy(array('url' => 'paylite_credit_card_for_token_payment'));
        if(!is_null($PageLayout)){
            $app['orm.em']->remove($PageLayout);
            $app['orm.em']->flush();
        }
    }

    private function createCreditCardPageLayout($app)
    {
        $pageLayoutRepo = $app['orm.em']->getRepository('Eccube\Entity\PageLayout');
        //Start select method set application follow version, method setApp on 3.0.7 changed to setApplication
        $listOldVersion = array('3.0.1', '3.0.2', '3.0.3', '3.0.4', '3.0.5','3.0.6');
        in_array(Constant::VERSION, $listOldVersion) ? $pageLayoutRepo->setApp($app) : $pageLayoutRepo->setApplication($app);
        //End of select method set application follow version.

        $url = 'paylite_mypage_credit_card_index';
        /** @var DeviceType $DeviceType */
        $DeviceType = $app['orm.em']->getRepository('Eccube\Entity\Master\DeviceType')->find(DeviceType::DEVICE_TYPE_PC);
        /** @var PageLayout $PageLayout */
        $PageLayout = $pageLayoutRepo->findOneBy(array('url' => $url));
        if (is_null($PageLayout)) {
            $PageLayout = $pageLayoutRepo->newPageLayout($DeviceType);
        }

        $PageLayout->setCreateDate(new \DateTime());
        $PageLayout->setUpdateDate(new \DateTime());
        $PageLayout->setName('MYページ/カード編集');
        $PageLayout->setUrl($url);
        $PageLayout->setFileName('EccubePaymentLite3/Twig/mypage/edit_credit_card');
        $PageLayout->setMetaRobots('noindex');
        $PageLayout->setEditFlg(PageLayout::EDIT_FLG_DEFAULT);

        $app['orm.em']->persist($PageLayout);
        $app['orm.em']->flush();
    }

    /**
     * @param Application $app
     */
    private function removeCreditCardPageLayout($app)
    {
        $pageLayoutRepo = $app['orm.em']->getRepository('Eccube\Entity\PageLayout');
        $listOldVersion = array('3.0.1', '3.0.2', '3.0.3', '3.0.4', '3.0.5','3.0.6');
        in_array(Constant::VERSION, $listOldVersion) ? $pageLayoutRepo->setApp($app) : $pageLayoutRepo->setApplication($app);

        /** @var PageLayout $PageLayout */
        $PageLayout = $pageLayoutRepo->findOneBy(array('url' => 'paylite_mypage_credit_card_index'));
        if(!is_null($PageLayout)){
            $app['orm.em']->remove($PageLayout);
            $app['orm.em']->flush();
        }
    }

    public function update($config, $app)
    {
        $this->migrationSchema($app, __DIR__ . '/Migration', $config['code']);
        $this->createCreditCardPageLayout($app);
        $this->createTokenPaymentPageLayout($app);
        // リソースファイルのコピー
        $this->copyAssets();
    }

    /**
     * ファイルをコピー
     */
    private function copyAssets()
    {
        $file = new Filesystem();
        $file->mirror($this->origin, $this->target);
        $file->mirror($this->imgSrc, $this->imgDst);
    }

    /**
     * コピーしたファイルを削除
     */
    private function removeAssets()
    {
        $file = new Filesystem();
        $file->remove($this->target . '/epsilon_recv.php');
        $file->remove($this->target . '/epsilon_pay_complete.php');
        $file->remove($this->imgDst . '/ps_banner_2101.gif');
    }

    /**
     * Define mail template
     * @return array
     */
    private function mailTemplateData()
    {
        return array(
            array(
                '注文受付メール',
                'EccubePaymentLite3/Twig/mail/epsilon_order.twig',
                'EC-CUBEペイメントLite3 - ご注文ありがとうございます',
            ),
            array(
                'クレジットカード有効期限通知メール',
                'EccubePaymentLite3/Twig/mail/expiration_notice_mail.twig',
                'ご登録されているクレジットカードの有効期限について',
            ),
        );
    }

    /**
     * Insert EccubePaymentLite3 mail template into dtb_mail_template
     * @param $app
     * @return bool
     * @throws \Exception
     */
    public function createEccubePaymentLite3MailTemplate($app) {
        $templateNewMails = $this->mailTemplateData();
        if(empty($templateNewMails)){
            return false;
        }

        foreach ($templateNewMails as $mailStruct) {
            $templateName = $mailStruct[0];
            $templateFile = $mailStruct[1];
            $templateSubject = $mailStruct[2];

            $Mail = $app['orm.em']
                ->getRepository('\Eccube\Entity\MailTemplate')
                ->findOneBy(array('file_name' => $templateFile));
            if (is_null($Mail)) {
                // Create new.
                $Mail = new MailTemplate();
                if ($app['security']->getToken() && $app['security']->isGranted('ROLE_ADMIN')) {
                    $creator = $app['security']->getToken()->getUser();
                    $Mail->setCreator($creator);
                    $Mail->setCreateDate(new \DateTime());
                }
            }
            // Update Content.
            $Mail->setName($templateName);
            $Mail->setFileName($templateFile);
            $Mail->setSubject($templateSubject);
            $Mail->setDelFlg(Constant::DISABLED);

            $app['orm.em']->persist($Mail);
            $app['orm.em']->flush();
        }
        return true;
    }

    /**
     * Remove EccubePaymentLite3 mail template from dtb_mail_template
     * @param $app
     * @return bool
     */
    public function removeEccubePaymentLite3MailTemplate($app) {
        $templateNewMails = $this->mailTemplateData();
        if(empty($templateNewMails)){
            return false;
        }

        foreach($templateNewMails as $mail){
            $templateFile = $mail[1];
            $Mail = $app['orm.em']
                ->getRepository('\Eccube\Entity\MailTemplate')
                ->findOneBy(array('file_name' => $templateFile));
            if(is_null($Mail)){
                continue;
            }
            $Mail->setDelFlg(Constant::ENABLED);
            $app['orm.em']->remove($Mail);
            $app['orm.em']->flush();
        }
        return true;

    }
}
