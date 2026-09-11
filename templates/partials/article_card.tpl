{* Expects: $article = ['title','slug','image','description','views','published_at'] *}
<article class="card">
    <a href="/article/{$article.slug}" class="card__image-link">
        <img
            class="card__image"
            src="{$article.image|default:'/assets/img/placeholder.svg'}"
            alt="{$article.title|escape}"
            loading="lazy"
        >
    </a>
    <div class="card__body">
        <h3 class="card__title">
            <a href="/article/{$article.slug}">{$article.title|escape}</a>
        </h3>
        {if $article.description}
            <p class="card__excerpt">{$article.description|escape|truncate:120}</p>
        {/if}
        <div class="card__meta">
            <span class="card__date">{$article.published_at|date_format:"%d.%m.%Y"}</span>
            <span class="card__views">👁 {$article.views}</span>
        </div>
    </div>
</article>
