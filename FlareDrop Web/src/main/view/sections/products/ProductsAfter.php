<section id="content" class="row">
    <div class="centered">

        <!-- CONTENTS -->
        <div id="contentContainer" class="row">

            <h1 class="title fontThin"><?php echo Managers::literals()->get('TITLE', 'Products') ?></h1>

            <ul>

                <!-- WEB SIMPLE -->
                <li id="pack-web-simple" class="productsListItem">
                    <div class="itemLeft">
                        <div class="row">
                            <img
                                src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/shared/pack-web-simple.png') ?>"
                                alt="<?php echo Managers::literals()->get('PACK_0_TITLE', 'Products') ?>"/>

                            <h2><?php echo Managers::literals()->get('PACK_0_TITLE', 'Products') ?></h2>
                        </div>
                        <div class="row">
                            <p class="description"><?php echo Managers::literals()->get('PACK_0_DESCRIPTION', 'Products') ?></p>
                        </div>
                    </div>

                    <div class="itemRight">
                        <div class="row">
                            <h3 class="fontBold"><?php echo Managers::literals()->get('CHARACTERISTICS', 'Products') ?></h3>
                            <ul>
                                <li><p><?php echo Managers::literals()->get('PACK_0_C0', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_0_C1', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_0_C2', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_0_C3', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_0_C4', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_0_C5', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_0_C6', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_0_C7', 'Products') ?></p></li>
                            </ul>
                        </div>

                        <p class="price"><?php echo Managers::literals()->get('FROM', 'Products') ?>
                            <span><?php echo WebConstants::PRODUCT_PRICE_WS ?>€</span></p>
                        <a class="budgetRequest btnBlue"
                           href="<?php echo UtilsHttp::getSectionUrl('request', ['product' => 'web-simple']) ?>"><?php echo Managers::literals()->get('BUDGET_REQUEST', 'Products') ?></a>
                    </div>
                </li>

                <!-- WEB ADVANCED -->
                <li id="pack-web-advanced" class="productsListItem">
                    <div class="itemLeft">
                        <div class="row">
                            <img
                                src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/shared/pack-web-advanced.png') ?>"
                                alt="<?php echo Managers::literals()->get('PACK_1_TITLE', 'Products') ?>"/>

                            <h2><?php echo Managers::literals()->get('PACK_1_TITLE', 'Products') ?></h2>
                        </div>
                        <div class="row">
                            <p class="description"><?php echo Managers::literals()->get('PACK_1_DESCRIPTION', 'Products') ?></p>
                        </div>
                    </div>

                    <div class="itemRight">
                        <div class="row">
                            <h3 class="fontBold"><?php echo Managers::literals()->get('CHARACTERISTICS', 'Products') ?></h3>
                            <ul>
                                <li><p><?php echo Managers::literals()->get('PACK_1_C0', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_1_C1', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_1_C2', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_1_C3', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_1_C4', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_1_C5', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_1_C6', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_1_C7', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_1_C8', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_1_C9', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_1_C10', 'Products') ?></p></li>
                            </ul>
                        </div>

                        <p class="price"><?php echo Managers::literals()->get('FROM', 'Products') ?>
                            <span><?php echo WebConstants::PRODUCT_PRICE_WA ?>€</span></p>
                        <a class="budgetRequest btnRed"
                           href="<?php echo UtilsHttp::getSectionUrl('request', ['product' => 'web-advanced']) ?>"><?php echo Managers::literals()->get('BUDGET_REQUEST', 'Products') ?></a>
                    </div>
                </li>


                <!-- WEB SHOP -->
                <li id="pack-web-shop" class="productsListItem">
                    <div class="itemLeft">
                        <div class="row">
                            <img
                                src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/shared/pack-web-shop.png') ?>"
                                alt="<?php echo Managers::literals()->get('PACK_2_TITLE', 'Products') ?>"/>

                            <h2><?php echo Managers::literals()->get('PACK_2_TITLE', 'Products') ?></h2>
                        </div>
                        <div class="row">
                            <p class="description"><?php echo Managers::literals()->get('PACK_2_DESCRIPTION', 'Products') ?></p>
                        </div>
                    </div>

                    <div class="itemRight">
                        <div class="row">
                            <h3 class="fontBold"><?php echo Managers::literals()->get('CHARACTERISTICS', 'Products') ?></h3>
                            <ul>
                                <li><p><?php echo Managers::literals()->get('PACK_2_C0', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_2_C1', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_2_C2', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_2_C3', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_2_C4', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_2_C5', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_2_C6', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_2_C7', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_2_C8', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_2_C9', 'Products') ?></p></li>
                                <li><p><?php echo Managers::literals()->get('PACK_2_C10', 'Products') ?></p></li>
                            </ul>
                        </div>

                        <p class="price"><?php echo Managers::literals()->get('FROM', 'Products') ?>
                            <span><?php echo WebConstants::PRODUCT_PRICE_BO ?>€</span></p>
                        <a class="budgetRequest btnGreen"
                           href="<?php echo UtilsHttp::getSectionUrl('request', ['product' => 'web-shop']) ?>"><?php echo Managers::literals()->get('BUDGET_REQUEST', 'Products') ?></a>
                    </div>
                </li>


                <!-- DOMAIN AND HOSTING -->
                <li id="pack-domain-hosting" class="productsListItem">
                    <div class="productsListHeader row">
                        <img
                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/shared/pack-domain-hosting.png') ?>"
                            alt="<?php echo Managers::literals()->get('PACK_3_TITLE', 'Products') ?>"/>

                        <h2><?php echo Managers::literals()->get('PACK_3_TITLE', 'Products') ?></h2>
                    </div>
                    <div class="productsListContent row">

                        <div id="domainsHostingsTable" class="row">
                            <div class="dhHeader row">
                                <div class="dhCol">
                                    <p></p>
                                </div>
                                <div class="dhCol">
                                    <p>Plan<br>2M</p>
                                </div>
                                <div class="dhCol">
                                    <p>Plan<br>5M</p>
                                </div>
                                <div class="dhCol">
                                    <p>Plan<br>1G</p>
                                </div>
                                <div class="dhCol">
                                    <p>Plan<br>2G</p>
                                </div>
                                <div class="dhCol">
                                    <p>Plan<br>5G</p>
                                </div>
                            </div>

                            <div class="dhContent row">

                                <div class="row pair">
                                    <div class="dhCol">
                                        <p><?php echo Managers::literals()->get('DH_OPTION_0', 'Products') ?></p>
                                    </div>
                                    <div class="dhCol">
                                        <p>200 MB</p>
                                    </div>
                                    <div class="dhCol">
                                        <p>500 MB</p>
                                    </div>
                                    <div class="dhCol">
                                        <p>1 GB</p>
                                    </div>
                                    <div class="dhCol">
                                        <p>2 GB</p>
                                    </div>
                                    <div class="dhCol">
                                        <p>5 GB</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="dhCol">
                                        <p><?php echo Managers::literals()->get('DH_OPTION_1', 'Products') ?></p>
                                    </div>
                                    <div class="dhCol">
                                        <p>1</p>
                                    </div>
                                    <div class="dhCol">
                                        <p>1</p>
                                    </div>
                                    <div class="dhCol">
                                        <p>1</p>
                                    </div>
                                    <div class="dhCol">
                                        <p>1</p>
                                    </div>
                                    <div class="dhCol">
                                        <p>1</p>
                                    </div>
                                </div>

                                <div class="row pair">
                                    <div class="dhCol">
                                        <p><?php echo Managers::literals()->get('DH_OPTION_2', 'Products') ?></p>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="dhCol">
                                        <p><?php echo Managers::literals()->get('DH_OPTION_3', 'Products') ?></p>
                                    </div>
                                    <div class="dhCol">
                                        <p>2</p>
                                    </div>
                                    <div class="dhCol">
                                        <p>5</p>
                                    </div>
                                    <div class="dhCol">
                                        <p>10</p>
                                    </div>
                                    <div class="dhCol">
                                        <p>∞</p>
                                    </div>
                                    <div class="dhCol">
                                        <p>∞</p>
                                    </div>
                                </div>

                                <div class="row pair">
                                    <div class="dhCol">
                                        <p><?php echo Managers::literals()->get('DH_OPTION_4', 'Products') ?></p>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/cross.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="dhCol">
                                        <p><?php echo Managers::literals()->get('DH_OPTION_5', 'Products') ?></p>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                </div>

                                <div class="row pair">
                                    <div class="dhCol">
                                        <p><?php echo Managers::literals()->get('DH_OPTION_6', 'Products') ?></p>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="dhCol">
                                        <p><?php echo Managers::literals()->get('DH_OPTION_7', 'Products') ?></p>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/cross.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                    <div class="dhCol">
                                        <img
                                            src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/tic.svg') ?>"
                                            alt=""/>
                                    </div>
                                </div>

                            </div>

                            <div class="dhFooter row">
                                <div class="dhCol">
                                    <p class="fontBold"><?php echo Managers::literals()->get('ANNUAL_PRICES', 'Products') ?></p>
                                </div>
                                <div class="dhCol">
                                    <p><?php echo WebConstants::PLAN_PRICE_200 . '€' ?></p>
                                </div>
                                <div class="dhCol">
                                    <p><?php echo WebConstants::PLAN_PRICE_500 . '€' ?></p>
                                </div>
                                <div class="dhCol">
                                    <p><?php echo WebConstants::PLAN_PRICE_1000 . '€' ?></p>
                                </div>
                                <div class="dhCol">
                                    <p><?php echo WebConstants::PLAN_PRICE_2000 . '€' ?></p>
                                </div>
                                <div class="dhCol">
                                    <p><?php echo WebConstants::PLAN_PRICE_5000 . '€' ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <a class="budgetRequest btnYellow"
                                   href="<?php echo UtilsHttp::getSectionUrl('request', ['product' => 'domain-hosting']) ?>"><?php echo Managers::literals()->get('SERVICE_REQUEST', 'Products') ?></a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

            <!-- MANAGER -->
            <div id="managerContent" class="row">
                <h2 class="title fontThin"><?php echo Managers::literals()->get('TITLE_MANAGER', 'Products') ?></h2>

                <ul>
                    <li><?php echo Managers::literals()->get('MANAGER_OP_00', 'Products') ?></li>
                    <li><?php echo Managers::literals()->get('MANAGER_OP_01', 'Products') ?></li>
                    <li><?php echo Managers::literals()->get('MANAGER_OP_02', 'Products') ?></li>
                    <li><?php echo Managers::literals()->get('MANAGER_OP_03', 'Products') ?></li>
                    <li><?php echo Managers::literals()->get('MANAGER_OP_04', 'Products') ?></li>
                    <li><?php echo Managers::literals()->get('MANAGER_OP_05', 'Products') ?></li>
                    <li><?php echo Managers::literals()->get('MANAGER_OP_06', 'Products') ?></li>
                    <li><?php echo Managers::literals()->get('MANAGER_OP_07', 'Products') ?></li>
                    <li><?php echo Managers::literals()->get('MANAGER_OP_08', 'Products') ?></li>
                    <li><?php echo Managers::literals()->get('MANAGER_OP_09', 'Products') ?></li>
                    <li><?php echo Managers::literals()->get('MANAGER_OP_10', 'Products') ?></li>
                    <li><?php echo Managers::literals()->get('MANAGER_OP_11', 'Products') ?></li>
                    <li><?php echo Managers::literals()->get('MANAGER_OP_12', 'Products') ?></li>
                </ul>

                <div id="managerRight">
                    <img src="<?php echo UtilsHttp::getRelativeUrl('view/resources/images/products/manager.png') ?>"
                         alt="<?php echo Managers::literals()->get('TITLE_MANAGER', 'Products') ?>"/>
                </div>
            </div>

            <!-- CONTACT US -->
            <div class="row">
                <a class="contactUs" href="<?php echo UtilsHttp::getSectionUrl('contact') ?>">
                    <i><?php echo Managers::literals()->get('CONTACT_US', 'Products') ?></i>
                </a>
            </div>
        </div>
    </div>
</section>