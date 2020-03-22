<section id="page" class="row">
    <div class="centered">

        <!-- MAIN TITLE-->
        <div class="row">
            <h1 class="title"><?= Managers::literals()->get('TITLE_01', 'Checkout') ?></h1>
        </div>

        <!-- FORM -->
        <div id="left">
            <p><?= Managers::literals()->get('TEXT_01', 'Checkout') ?></p>
            <?php
            $payModeOptons = [
                ['value' => 'paypal', 'label' => 'PayPal'],
                ['value' => 'tpv', 'label' => 'TPV La Caixa']
            ];

            $form = new ComponentForm(UtilsHttp::getWebServiceUrl('CheckoutFormSend'), 'checkoutForm');
            $form->addInput('hidden', 'frmCart');
            $form->addInput('hidden', 'frmTotalPrice');
            $form->addInput('hidden', 'frmTpvMerchantUrl', '', '', '', '', '', UtilsHttp::getWebServiceUrl('ValidateTpv', null, true));
            $form->addInput('text', 'frmName', 'fill', Managers::literals()->get('FRM_ERROR_NAME', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_NAME', 'Shared') . ' *');
            $form->addInput('text', 'frmPhone', 'phone', Managers::literals()->get('FRM_ERROR_PHONE', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_PHONE', 'Shared') . ' *');
            $form->addInput('text', 'frmEmail', 'email', Managers::literals()->get('FRM_ERROR_EMAIL', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_EMAIL', 'Shared') . ' *');
            $form->addInput('text', 'frmLocation', 'fill', Managers::literals()->get('FRM_ERROR_LOCATION', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_LOCATION', 'Shared') . ' *');
            $form->addInput('text', 'frmCity', 'fill', Managers::literals()->get('FRM_ERROR_CITY', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_CITY', 'Shared') . ' *');
            $form->addInput('text', 'frmCp', 'fill', Managers::literals()->get('FRM_ERROR_CP', 'Shared') . ';' . Managers::literals()->get('DIALOG_ERROR', 'Shared'), Managers::literals()->get('FRM_CP', 'Shared') . ' *');
            $form->addOptionBarComponent('frmPayMode', $payModeOptons, Managers::literals()->get('FRM_PAY_MODE', 'Shared'), 0, 'payModeSelector');
            $form->addInput('submit', '', '', '', '', 'AND', '', Managers::literals()->get('FRM_BUY', 'Checkout'));
            $form->echoComponent();
            ?>
            <img id="payPalIcons"
                 src="<?= UtilsHttp::getRelativeUrl('view/resources/images/checkout/paypal_icons.jpg') ?>"
                 alt="PayPal"/>
        </div>

        <!-- SHOPPING CART DYNAMIC LIST LIST -->
        <div id="right">
            <div class="row">
                <h2 class="titleProduct"><?= Managers::literals()->get('TITLE_02', 'Checkout') ?></h2>
            </div>
            <div id="cartContainer" class="row"></div>
        </div>
    </div>
</section>