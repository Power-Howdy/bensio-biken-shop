<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace Eccube\Tests\Form\Type\Admin;

class PointUseTypeTest extends \Eccube\Tests\Form\Type\AbstractTypeTestCase
{
    /** @var \Eccube\Application */
    protected $app;

    /** @var array デフォルト値（正常系）を設定 */
    protected $formData = array(
        'plg_use_point' => null,
    );

    public function testValidData()
    {
        $form = $this->createForm();
        $form->submit($this->formData);
        $this->assertTrue($form->isValid(), $form->getErrorsAsString());
    }

    public function testMaxUsePoint()
    {
        $max = 100;
        $current = 500;

        $this->formData['plg_use_point'] = 99;
        $form = $this->createForm($max, $current);
        $form->submit($this->formData);
        $this->assertTrue($form->isValid(), $form->getErrorsAsString());

        $this->formData['plg_use_point'] = 100;
        $form = $this->createForm($max, $current);
        $form->submit($this->formData);
        $this->assertTrue($form->isValid(), $form->getErrorsAsString());

        $this->formData['plg_use_point'] = 101;
        $form = $this->createForm($max, $current);
        $form->submit($this->formData);
        $this->assertFalse($form->isValid(), $form->getErrorsAsString());
    }

    public function testCurrentUsePoint()
    {
        $max = 500;
        $current = 100;

        $this->formData['plg_use_point'] = 99;
        $form = $this->createForm($max, $current);
        $form->submit($this->formData);
        $this->assertTrue($form->isValid(), $form->getErrorsAsString());

        $this->formData['plg_use_point'] = 100;
        $form = $this->createForm($max, $current);
        $form->submit($this->formData);
        $this->assertTrue($form->isValid(), $form->getErrorsAsString());

        $this->formData['plg_use_point'] = 101;
        $form = $this->createForm($max, $current);
        $form->submit($this->formData);
        $this->assertFalse($form->isValid(), $form->getErrorsAsString());
    }

    public function testNotNumeric()
    {
        $this->formData['plg_use_point'] = 'あああ';
        $form = $this->createForm();
        $form->submit($this->formData);
        $this->assertFalse($form->isValid(), $form->getErrorsAsString());
    }

    private function createForm($maxUsePoint = 100, $currentPoint = 100)
    {
        // CSRF tokenを無効にしてFormを作成
        return $this->app['form.factory']
            ->createBuilder(
                'front_point_use',
                null,
                array(
                    'csrf_protection' => false,
                    'maxUsePoint' => $maxUsePoint,
                    'currentPoint' => $currentPoint,
                )
            )
            ->getForm();
    }
}
