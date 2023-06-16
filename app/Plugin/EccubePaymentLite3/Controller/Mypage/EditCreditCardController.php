<?php

namespace Plugin\EccubePaymentLite3\Controller\Mypage;

use Eccube\Application;
use Eccube\Controller\AbstractController;
use DateTime;
use Plugin\EccubePaymentLite3\Entity\EpsilonMember;

class EditCreditCardController extends AbstractController
{
    /**
     * Get card info
     * @param Application $app
     */
    public function index(Application $app){
        // Get info of customer from Epsilon
        $results = $app['eccube.plugin.epsilon.getinfo.services']->handle();
        $isRegisteredCreditCard = true;
        if ($results['status'] === 'NG') {
            $isRegisteredCreditCard = false;
        }
        return $app->render('EccubePaymentLite3/Twig/mypage/edit_credit_card.twig', array(
            'isRegisteredCreditCard' => $isRegisteredCreditCard,
            'cardBrand' => $results['cardBrand'],
            'cardExpire' => $results['cardExpire'],
            'cardNumberMask' => $results['cardNumberMask'],
        ));
    }

    /**
     * Add new card
     * @param Application $app
     */
    public function create(Application $app){
        if (!$app->isGranted('ROLE_USER')) {
            return $app->redirect($app->url('mypage_login'));
        }
        $Customer = $app->user();
        $results = $app['eccube.plugin.epsilon.service.request.receive_order']->handle($Customer, 3, 'paylite_mypage_credit_card_new');

        if ($results['status'] === 'NG') {
            return $app->redirect($app->url('paylite_mypage_credit_card_index'));
        }
        return $app->redirect($results['url']);
    }

    /**
     * Change card info
     * @param Application $app
     */
    public function edit(Application $app){
        if (!$app->isGranted('ROLE_USER')) {
            return $app->redirect($app->url('mypage_login'));
        }
        $Customer = $app->user();
        $results = $app['eccube.plugin.epsilon.service.request.receive_order']->handle($Customer, 4, 'paylite_mypage_credit_card_edit');

        if ($results['status'] === 'NG') {
            return $app->redirect($app->url('paylite_mypage_credit_card_index'));
        }
        return $app->redirect($results['url']);
    }

    /**
     * Complete update card info
     * @param Application $app
     */
    public function complete(Application $app){

        if ($app->isGranted('ROLE_USER')) {
            $Customer = $app->user();
            // Get user info from Epsilon
            $results = $app['eccube.plugin.epsilon.getinfo.services']->handle();
            if ($results['status'] === 'OK') {
                try {
                    // Check exist Epsilon Member
                    $EpsilonMember = $app['eccube.plugin.epsilon.repository.epsilon_member']->getEpsilonMemberByCustomerId($Customer->getId());
                    if (is_null($EpsilonMember)) {
                        $EpsilonMember = new EpsilonMember();
                    }
                    // Get card expire of customer from Epsilon
                    $cardExpire = $app['eccube.plugin.epsilon.service.get_card_expire_date']->getCardExpire($results['cardExpire']);
                    $EpsilonMember->setGmoEpsilonCreditCardExpirationDate($cardExpire);
                    $EpsilonMember->setCardChangeRequestMailSendDate(null);
                    $EpsilonMember->setCustomer($Customer);
                    $app['orm.em']->persist($EpsilonMember);
                    $app['orm.em']->flush();

                    return $app->redirect($app->url('paylite_mypage_credit_card_index'));
                } catch (\Exception $e) {
                    log_error('Create or update Epsilon Member errors ', array($e->getMessage()));
                    $app['monolog.gmoepsilon']->error($e);
                    return false;
                }
            }
        }
        return $app->redirect($app->url('paylite_mypage_credit_card_index'));
    }

}
