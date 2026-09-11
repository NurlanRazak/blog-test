<?php
/* Smarty version 4.5.7, created on 2026-09-11 10:40:21
  from '/var/www/html/templates/category.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.7',
  'unifunc' => 'content_6aa3da95548e96_10177369',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '613a09af5fd741260bb75385e34c7ae2f0d44960' => 
    array (
      0 => '/var/www/html/templates/category.tpl',
      1 => 1789036117,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:partials/article_card.tpl' => 1,
  ),
),false)) {
function content_6aa3da95548e96_10177369 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_9785350756aa3da955410a8_05609836', "content");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "layout.tpl");
}
/* {block "content"} */
class Block_9785350756aa3da955410a8_05609836 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_9785350756aa3da955410a8_05609836',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/vendor/smarty/smarty/libs/plugins/modifier.count.php','function'=>'smarty_modifier_count',),));
?>

    <h1 class="page-title"><?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['category']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</h1>

    <?php if ($_smarty_tpl->tpl_vars['category']->value['description']) {?>
        <p class="page-description"><?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['category']->value['description'], ENT_QUOTES, 'UTF-8', true);?>
</p>
    <?php }?>

    <div class="toolbar">
        <span class="toolbar__label">Сортировать:</span>
        <a
            href="/category/<?php echo $_smarty_tpl->tpl_vars['category']->value['slug'];?>
?sort=date"
            class="toolbar__link<?php if ($_smarty_tpl->tpl_vars['sort']->value == 'date') {?> toolbar__link--active<?php }?>"
        >по дате</a>
        <a
            href="/category/<?php echo $_smarty_tpl->tpl_vars['category']->value['slug'];?>
?sort=views"
            class="toolbar__link<?php if ($_smarty_tpl->tpl_vars['sort']->value == 'views') {?> toolbar__link--active<?php }?>"
        >по просмотрам</a>
    </div>

    <?php if (smarty_modifier_count($_smarty_tpl->tpl_vars['articles']->value) == 0) {?>
        <p class="empty-state">В этой категории пока нет статей.</p>
    <?php } else { ?>
        <div class="card-grid">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['articles']->value, 'article');
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

        <?php if ($_smarty_tpl->tpl_vars['paginator']->value->totalPages > 1) {?>
            <nav class="pagination">
                <?php if ($_smarty_tpl->tpl_vars['paginator']->value->hasPrev()) {?>
                    <a class="pagination__link" href="?sort=<?php echo $_smarty_tpl->tpl_vars['sort']->value;?>
&page=<?php echo $_smarty_tpl->tpl_vars['paginator']->value->currentPage-1;?>
">&laquo; Назад</a>
                <?php }?>

                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['paginator']->value->pageRange(), 'p');
$_smarty_tpl->tpl_vars['p']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['p']->value) {
$_smarty_tpl->tpl_vars['p']->do_else = false;
?>
                    <a
                        class="pagination__link<?php if ($_smarty_tpl->tpl_vars['p']->value == $_smarty_tpl->tpl_vars['paginator']->value->currentPage) {?> pagination__link--active<?php }?>"
                        href="?sort=<?php echo $_smarty_tpl->tpl_vars['sort']->value;?>
&page=<?php echo $_smarty_tpl->tpl_vars['p']->value;?>
"
                    ><?php echo $_smarty_tpl->tpl_vars['p']->value;?>
</a>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

                <?php if ($_smarty_tpl->tpl_vars['paginator']->value->hasNext()) {?>
                    <a class="pagination__link" href="?sort=<?php echo $_smarty_tpl->tpl_vars['sort']->value;?>
&page=<?php echo $_smarty_tpl->tpl_vars['paginator']->value->currentPage+1;?>
">Вперёд &raquo;</a>
                <?php }?>
            </nav>
        <?php }?>
    <?php }
}
}
/* {/block "content"} */
}
