{extends file="layout.tpl"}

{block name="content"}
    <h1 class="page-title">Категории</h1>

    {if $categories|@count == 0}
        <p class="empty-state">Пока нет ни одной категории со статьями.</p>
    {/if}

    {foreach $categories as $category}
        <section class="category-section">
            <div class="category-section__header">
                <h2>
                    <a href="/category/{$category.slug}">{$category.name|escape}</a>
                </h2>
                <a href="/category/{$category.slug}" class="btn btn--outline">Все статьи</a>
            </div>

            {if $category.description}
                <p class="category-section__description">{$category.description|escape}</p>
            {/if}

            <div class="card-grid">
                {foreach $category.latest_articles as $article}
                    {include file="partials/article_card.tpl" article=$article}
                {/foreach}
            </div>
        </section>
    {/foreach}
{/block}
