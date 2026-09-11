{extends file="layout.tpl"}

{block name="content"}
    <h1 class="page-title">{$category.name|escape}</h1>

    {if $category.description}
        <p class="page-description">{$category.description|escape}</p>
    {/if}

    <div class="toolbar">
        <span class="toolbar__label">Сортировать:</span>
        <a
            href="/category/{$category.slug}?sort=date"
            class="toolbar__link{if $sort == 'date'} toolbar__link--active{/if}"
        >по дате</a>
        <a
            href="/category/{$category.slug}?sort=views"
            class="toolbar__link{if $sort == 'views'} toolbar__link--active{/if}"
        >по просмотрам</a>
    </div>

    {if $articles|@count == 0}
        <p class="empty-state">В этой категории пока нет статей.</p>
    {else}
        <div class="card-grid">
            {foreach $articles as $article}
                {include file="partials/article_card.tpl" article=$article}
            {/foreach}
        </div>

        {if $paginator->totalPages > 1}
            <nav class="pagination">
                {if $paginator->hasPrev()}
                    <a class="pagination__link" href="?sort={$sort}&page={$paginator->currentPage - 1}">&laquo; Назад</a>
                {/if}

                {foreach $paginator->pageRange() as $p}
                    <a
                        class="pagination__link{if $p == $paginator->currentPage} pagination__link--active{/if}"
                        href="?sort={$sort}&page={$p}"
                    >{$p}</a>
                {/foreach}

                {if $paginator->hasNext()}
                    <a class="pagination__link" href="?sort={$sort}&page={$paginator->currentPage + 1}">Вперёд &raquo;</a>
                {/if}
            </nav>
        {/if}
    {/if}
{/block}
