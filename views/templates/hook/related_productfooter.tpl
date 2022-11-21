{if $cross_sell}
    <section>
        <h2>{if $cross_feature_name != ''}{l s='Prodotti della stessa %f_name% "%f_value%"' sprintf=['%f_name%' => $cross_feature_name, '%f_value%' => $cross_feature_value]}{else}{l s='You might also like' d='Shop.Theme.Catalog'}{/if}</h2>
        <div class="products">
            {foreach from=$cross_sell item="product"}
            {include file="catalog/_partials/miniatures/product.tpl" product=$product}
            {/foreach}
        </div>
    </section>
{/if}

{if $up_sell}
    <section>
        <h2>{if $up_feature_name != ''}{l s='Prodotti della stessa %f_name% "%f_value%"' sprintf=['%f_name%' => $up_feature_name, '%f_value%' => $up_feature_value]}{else}{l s='You might also like' d='Shop.Theme.Catalog'}{/if}</h2>
        <div class="products">
            {foreach from=$up_sell item="product"}
            {include file="catalog/_partials/miniatures/product.tpl" product=$product}
            {/foreach}
        </div>
    </section>
{/if}