<?php
/* Smarty version 4.5.7, created on 2026-09-11 10:26:11
  from '/var/www/html/templates/layout.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.7',
  'unifunc' => 'content_6aa3d7438555a3_74266269',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3a0c729172fafa92df9cfe9fa397716257ca8ee3' => 
    array (
      0 => '/var/www/html/templates/layout.tpl',
      1 => 1789122017,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6aa3d7438555a3_74266269 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/vendor/smarty/smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo (($tmp = $_smarty_tpl->tpl_vars['page_title']->value ?? null)===null||$tmp==='' ? "Блог" ?? null : $tmp);?>
 — Блог</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <a href="/" class="logo">Блог</a>
        </div>
    </header>

    <main class="container">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6418370896aa3d743853655_48786475', "content");
?>

    </main>

    <footer class="site-footer">
        <div class="container">
            <p>&copy; <?php echo smarty_modifier_date_format(time(),"%Y");?>
 Блог — тестовое задание</p>
        </div>
    </footer>
</body>
</html>
<?php }
/* {block "content"} */
class Block_6418370896aa3d743853655_48786475 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_6418370896aa3d743853655_48786475',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "content"} */
}
