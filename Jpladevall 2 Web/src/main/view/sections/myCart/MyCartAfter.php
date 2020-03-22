<section class="section row">
    <div class="centered">


        <h1><?= Managers::literals()->get('MAIN_TITLE', 'MyCart') ?></h1>

        <ul id="cartHeaderContainer" class="cartTable row">
            <li></li>
            <li><?= Managers::literals()->get('CART_HEADER_NAME', 'Shared') ?></li>
            <li><?= Managers::literals()->get('CART_HEADER_UNIT_PRICE', 'Shared') ?></li>
            <li><?= Managers::literals()->get('CART_HEADER_QUANTITY', 'Shared') ?></li>
        </ul>
        <div id="cartContainer" class="row"></div>
        <button id="checkoutBtn">Comprar</button>

    </div>
</section>