    <label for="db-name">DataBase Name</label>
    <input type="text" name="db-name" id="db-name" value="<?php echo isset($_POST['db-name'])?$_POST['db-name']:'kopolocms'; ?>" />
    
    <label for="db-user">DataBase User Name</label>
    <input type="text" name="db-user" id="db-user" value="<?php echo isset($_POST['db-user'])?$_POST['db-user']:'kopolocms'; ?>" />
    
    <label for="db-host">DataBase Host</label>
    <input type="text" name="db-host" id="db-host" value="<?php echo isset($_POST['db-host'])?$_POST['db-host']:'localhost'; ?>"/>
    
    <label for="db-password">DataBase Password</label>
    <input type="text" name="db-password" id="db-password" value="<?php echo isset($_POST['db-password'])?$_POST['db-password']:''; ?>"/>
    
    <!--label for="db-prefix">DataBase Table Prefix</label-->
    <input type="hidden" name="db-prefix" id="db-prefix" value="<?php echo isset($_POST['db-prefix'])?$_POST['db-prefix']:'kpl_'; ?>"/>
    <p></p>