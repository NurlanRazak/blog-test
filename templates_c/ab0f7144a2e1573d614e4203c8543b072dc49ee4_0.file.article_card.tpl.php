<?php
/* Smarty version 4.5.7, created on 2026-09-11 10:26:11
  from '/var/www/html/templates/partials/article_card.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.7',
  'unifunc' => 'content_6aa3d74385e5e9_55089303',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ab0f7144a2e1573d614e4203c8543b072dc49ee4' => 
    array (
      0 => '/var/www/html/templates/partials/article_card.tpl',
      1 => 1789036099,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6aa3d74385e5e9_55089303 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/vendor/smarty/smarty/libs/plugins/modifier.truncate.php','function'=>'smarty_modifier_truncate',),1=>array('file'=>'/var/www/html/vendor/smarty/smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<article class="card">
    <a href="/article/<?php echo $_smarty_tpl->tpl_vars['article']->value['slug'];?>
" class="card__image-link">
        <img
            class="card__image"
            src="<?php echo (($tmp = $_smarty_tpl->tpl_vars['article']->value['image'] ?? null)===null||$tmp==='' ? '/assets/img/placeholder.svg' ?? null : $tmp);?>
"
            alt="<?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['article']->value['title'], ENT_QUOTES, 'UTF-8', true);?>
"
            loading="lazy"
        >
    </a>
    <div class="card__body">
        <h3 class="card__title">
            <a href="/article/<?php echo $_smarty_tpl->tpl_vars['article']->value['slug'];?>
"><?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['article']->value['title'], ENT_QUOTES, 'UTF-8', true);?>
</a>
        </h3>
        <?php if ($_smarty_tpl->tpl_vars['article']->value['description']) {?>
            <p class="card__excerpt"><?php echo smarty_modifier_truncate(htmlspecialchars((string)$_smarty_tpl->tpl_vars['article']->value['description'], ENT_QUOTES, 'UTF-8', true),120);?>
</p>
        <?php }?>
        <div class="card__meta">
            <span class="card__date"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['article']->value['published_at'],"%d.%m.%Y");?>
</span>
            <span class="card__views">👁 <?php echo $_smarty_tpl->tpl_vars['article']->value['views'];?>
</span>
        </div>
    </div>
</article>
<?php }
}
