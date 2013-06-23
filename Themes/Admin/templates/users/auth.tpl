{strip}
    <table class="login">
         <tr>
            <td align="center" valign="middle">
                <h2>{$smarty.server.SERVER_NAME}</h2>
                <div><img src="/Themes/Admin/i/icons/key.png" /> вход в систему управления</div>
                <div class="form">
                    <form method="post" action="">
                        <label for="auth-login">Логин:</label>
                        <input type="text" name="username" id="auth-login" />
                        
                        <label for="auth-pass">Пароль:</label>
                        <input type="password" name="password" id="auth-pass" />
                        
                        <div class="remember">
                            <input type="checkbox" name="remember" id="auth-remember" class="checkbox"/>
                            <label for="auth-remember">запомнить</label>
                        </div>
                        
                        <button type="submit">Вход</button>
                    </form>
                </div>
            </td>
        </tr>
    </table>
    <div class="logo-small">
        <a href="http://kopolocms.ru">
        <img height="32" align="left" width="32" title="Работает на Kopolo CMS" alt="Kopolo" onmouseout="this.src='/Themes/Admin/i/logo-small_gray.jpg'" onmouseover="this.src='/Themes/Admin/i/logo-small.jpg'" src="/Themes/Admin/i/logo-small_gray.jpg" />
        </a>
    </div>
{/strip}