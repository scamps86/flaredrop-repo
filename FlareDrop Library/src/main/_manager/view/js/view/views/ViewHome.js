function ViewHomeClass(moduleContainerElement) {

    // Define this view
    var view = this;

    // Define the module container
    view.moduleContainer = moduleContainerElement;

    // Define the home container
    view.homeContainer = $('<div id="homeViewContainer" class="row"></div>');

    // Create the custom logo
    var customLogoContainer = $('<div id="customLogoContainer"></div>');
    var customLogo = $('<img src="' + GLOBAL_URL_BASE + 'view/resources/images/_manager/managerLogo.png" alt="">');
    $(customLogoContainer).append(customLogo);

    // Create the component used space
    var usedSpace = new ComponentUsedSpace();

    // Create component skin changer
    var skinChanger = new ComponentSkinChanger();

    // Create the literal chooser
    var literalChanger = new ComponentLocaleChanger();

    // Create the flareDrop icon
    var icon = $('<a id="flareDropLogo" href="http://www.flaredrop.com" target="_blank"><img src="' + GLOBAL_URL_BASE + 'view/resources/images/_manager/flareDropGrey.svg" alt="FlareDrop Development"><span>© 2015 FlareDrop. All Rights Reserved</span></a>');

    // DO THE APPENDS
    $(view.homeContainer).append(customLogoContainer, usedSpace.container, skinChanger.container, literalChanger.container, icon);
    $(view.moduleContainer).append(view.homeContainer);

    // Validate the domain expiration date and show a popup one month before
    var domainExpirationDate = UtilsDate.YYYYMMDDToDate(ModelApplication.configuration.global.domainExpirationDate);
    var currentDateAndMonth = UtilsDate.operate("MONTH", UtilsDate.create());

    if (currentDateAndMonth > domainExpirationDate) {
        // Generate the PayPal button
        var paymentBtn = $('<div></div>');
        UtilsPayPal.createBuyNowButton(paymentBtn, ModelApplication.payPalSandboxEnabled, {
            business: ModelApplication.payPalBusiness,
            currency_code: "EUR",
            item_name: "FlareDrop Plan " + ModelApplication.configuration.global.planType + " renew",
            amount: ModelApplication.configuration.global.planPrice,
            cpp_header_image: ModelApplication.payPalBannerUrl,
            notify_url: ModelApplication.payPalServiceUrl,
            custom: UtilsConversion.base64Encode(UtilsConversion.objectToJson([ModelApplication.rootId, ModelApplication.configuration.global.planType]))
        }, ModelApplication.literals.get("DO_PAYMENT", "ManagerApp"));

        // Generate the alert content HTML
        var contentHtml = "<p>" + ModelApplication.literals.get("DOMAIN_EXPIRATION_MESSAGE", "ManagerApp") + "</p>";
        contentHtml += '<div class="row">' + $(paymentBtn).html();
        contentHtml += '<a class="fontBold paymentMail" href="mailto:comercial@flaredrop.com" target="_blank">comercial@flaredrop.com</a></div>';
        contentHtml += "<p>" + ModelApplication.literals.get("DOMAIN_EXPIRATION_DATE", "ManagerApp") + "</p>";
        contentHtml += '<p class="fontBold">' + UtilsDate.toDDMMYYYY(domainExpirationDate, "/") + "</p>";

        // Show the alert
        ManagerPopUp.window(ModelApplication.literals.get("ALERT", "ManagerApp"), contentHtml);
    }
}

/*
 Update the home data
 */
ViewHomeClass.prototype.update = function () {
    // Get the used space
    ControlApplication.getFilesUsedSpace();
    ControlApplication.getPicturesUsedSpace();
};

