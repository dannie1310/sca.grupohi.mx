<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php if(isset($this->titulo)) echo $this->titulo; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
        <link href="<?php echo $_layoutParams['ruta_css']; ?>estilos.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <body>
            <div id="main">
                <div id="header">
                    <div id="logo">
                        <h1><?php echo APP_NAME; ?></h1>
                    </div>

                    <div id="menu">
                        <div id="top_menu">
                            <ul>
                            <?php if(isset($_layoutParams['menu'])): ?>
                            <?php for($i = 0; $i < count($_layoutParams['menu']); $i++): ?>
                            <?php 

                            if($item && $_layoutParams['menu'][$i]['id'] == $item ){ 
                            $_item_style = 'current'; 
                            } else {
                            $_item_style = '';
                            }

                            ?>

                            <li><a class="<?php echo $_item_style; ?>" href="<?php echo $_layoutParams['menu'][$i]['enlace']; ?>"><?php  echo $_layoutParams['menu'][$i]['titulo']; ?></a></li>

                            <?php endfor; ?>
                            <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="content">