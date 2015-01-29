<div id='loginForm'>
    <form data-bind="submit: processLogin">
        Emailt:      <input type="text" data-bind="value: email" />
        Password:   <input type="password" data-bind="value: password"/>
                    <input type="hidden" data-bind="value: hehe" />
        Merk mich   <input type="checkbox" data-bind="checked: remember"/>
        <button type="submit">Submit</button>
    </form>
</div>