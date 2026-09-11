<?php
/* Smarty version 4.5.7, created on 2026-09-11 10:26:11
  from '/var/www/html/templates/404.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.7',
  'unifunc' => 'content_6aa3d7438867b6_47122995',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '039b0441772362c9cf4d4018f072447c13b94309' => 
    array (
      0 => '/var/www/html/templates/404.tpl',
      1 => 1789121713,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6aa3d7438867b6_47122995 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7293683036aa3d743886078_99998089', "content");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "layout.tpl");
}
/* {block "content"} */
class Block_7293683036aa3d743886078_99998089 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_7293683036aa3d743886078_99998089',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="empty-state empty-state--404">
        <h1>404</h1>
        <p>Страница не найдена.</p>
        <a href="/" class="btn">На главную</a>
    </div>
<?php
}
}
/* {/block "content"} */
}
