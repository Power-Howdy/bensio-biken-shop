<?php

namespace Plugin\MailMagazine\Event;

use Eccube\Application;
use Eccube\Common\Constant;
use Eccube\Entity\Master\CustomerStatus;
use Plugin\MailMagazine\Entity\MailmagaCustomer;
use Symfony\Component\HttpFoundation\Request;

class CommonEvent
{
    /**
     * @var Application
     */
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * カスタマーIDを取得する.
     *
     * @param Request $request
     *
     * @return int
     */
    protected function getEntryCustomerId($request)
    {
        // eMailは入力で重複チェックを行っているため整合性を保つ可能性が高い

        // EMailを取得する.
        $form = $this->app['form.factory']->createBuilder('entry')->getForm();
        $form->handleRequest($request);
        $email = $form->get('email')->getData();

        // 仮会員のEntityを取得する.
        $CustomerStatus = $this->app['orm.em']
            ->getRepository('Eccube\Entity\Master\CustomerStatus')
            ->find(CustomerStatus::NONACTIVE);

        // customer_idを取得する.
        $dql = "SELECT MAX(e.id) AS currentid FROM \Eccube\Entity\Customer e
            WHERE e.del_flg = 0 AND e.email = :email AND e.Status = :status";
        $q = $this->app['orm.em']->createQuery($dql);
        $q->setParameter('email', $email);
        $q->setParameter('status', $CustomerStatus);

        return $q->getSingleScalarResult();
    }

    /**
     * メール送付情報を保存する.
     *
     * @param int  $customerId
     * @param bool $mailmagaFlg
     */
    protected function saveMailmagaCustomer($customerId, $mailmagaFlg)
    {
        // メルマガ送付情報を取得する
        $MailmagaCustomerRepository = $this->app['eccube.plugin.mail_magazine.repository.mail_magazine_mailmaga_customer'];
        $MailmagaCustomer = $MailmagaCustomerRepository->findOneBy(array('customer_id' => $customerId));

        // メルマガ送付情報がない場合は新規に作成する
        if (is_null($MailmagaCustomer)) {
            $MailmagaCustomer = new MailmagaCustomer();
            $MailmagaCustomer->setCustomerId($customerId);
            $MailmagaCustomer->setDelFlg(Constant::DISABLED);
            $MailmagaCustomer->setCreateDate(new \DateTime());
        }
        $MailmagaCustomer->setMailmagaFlg($mailmagaFlg);
        $MailmagaCustomer->setUpdateDate(new \DateTime());

        $MailmagaCustomerRepository->save($MailmagaCustomer);
    }
}
