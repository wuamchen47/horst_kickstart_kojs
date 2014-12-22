<div id='loginForm' class='col_12'>
<form data-bind="submit: processLogin">
    Emailt:      <input type="text" data-bind="value: email" />
    Password:   <input type="password" data-bind="value: password"/>
                <input type="hidden" data-bind="value: hehe" />
    <button type="submit">Submit</button>
</form>
    <p>If you don't have a login, please <a href="register.php">register</a></p>
</div>