<?php
/* Smarty version 4.5.7, created on 2026-09-11 10:26:11
  from '/var/www/html/templates/home.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.7',
  'unifunc' => 'content_6aa3d7438489f4_31861813',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f0a9a57fd920a50a8eaa8b6ed058c1db99dee6dc' => 
    array (
      0 => '/var/www/html/templates/home.tpl',
      1 => 1789036105,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:partials/article_card.tpl' => 1,
  ),
),false)) {
function content_6aa3d7438489f4_31861813 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7156702616aa3d74383a9c2_92167693', "content");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "layout.tpl");
}
/* {block "content"} */
class Block_7156702616aa3d74383a9c2_92167693 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_7156702616aa3d74383a9c2_92167693',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/vendor/smarty/smarty/libs/plugins/modifier.count.php','function'=>'smarty_modifier_count',),));
?>

    <h1 class="page-title">Категории</h1>

    <?php if (smarty_modifier_count($_smarty_tpl->tpl_vars['categories']->value) == 0) {?>
        <p class="empty-state">Пока нет ни одной категории со статьями.</p>
    <?php }?>

    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'category');
$_smarty_tpl->tpl_vars['category']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->do_else = false;
?>
        <section class="category-section">
            <div class="category-section__header">
                <h2>
                    <a href="/category/<?php echo $_smarty_tpl->tpl_vars['category']->value['slug'];?>
"><?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['category']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</a>
                </h2>
                <a href="/category/<?php echo $_smarty_tpl->tpl_vars['category']->value['slug'];?>
" class="btn btn--outline">Все статьи</a>
            </div>

            <?php if ($_smarty_tpl->tpl_vars['category']->value['description']) {?>
                <p class="category-section__description"><?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['category']->value['description'], ENT_QUOTES, 'UTF-8', true);?>
</p>
            <?php }?>

            <div class="card-grid">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['category']->value['latest_articles'], 'article');
$_smarty_tpl->tpl_vars['article']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['article']->value) {
$_smarty_tpl->tpl_vars['article']->do_else = false;
?>
                    <?php $_smarty_tpl->_subTemplateRender("file:partials/article_card.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('article'=>$_smarty_tpl->tpl_vars['article']->value), 0, true);
?>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </div>
        </section>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
/* {/block "content"} */
}
