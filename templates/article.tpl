{extends file="layout.tpl"}

{block name="content"}
    <article class="article">
        <div class="article__categories">
            {foreach $categories as $cat}
                <a href="/category/{$cat.slug}" class="tag">{$cat.name|escape}</a>
            {/foreach}
        </div>

        <h1 class="article__title">{$article.title|escape}</h1>

        <div class="article__meta">
            <span>{$article.published_at|date_format:"%d.%m.%Y"}</span>
            <span>👁 {$article.views} просмотров</span>
        </div>

        {if $article.image}
            <img class="article__image" src="{$article.image}" alt="{$article.title|escape}">
        {/if}

        {if $article.description}
            <p class="article__lead">{$article.description|escape}</p>
        {/if}

        <div class="article__content">
            {$article.content}
        </div>
    </article>

    {if $similar|@count > 0}
        <section class="related">
            <h2>Похожие статьи</h2>
            <div class="card-grid">
                {foreach $similar as $rel}
                    {include file="partials/article_card.tpl" article=$rel}
                {/foreach}
            </div>
        </section>
    {/if}
{/block}
